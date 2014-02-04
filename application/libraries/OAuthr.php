<?php

class OAuthr
{
    var $CI;

    var $private_key;
    var $consumer_secret;
    var $token_secret;

    var $_ch;
    var $_params = array();
    var $_opt = array();
    var $_url;
    var $_method;
    var $_scheme;
    var $_signature_base_string;

    function __construct()
    {
        $this->CI =& get_instance();

        // Load the Oauth config file
        $this->CI->config->load('oauthr');

        // Fetch the config parameters
        $this->_params = $this->CI->config->item('oauthr_params');

        // Fetch the config private key and consumer secret
        $this->private_key     = $this->CI->config->item('oauthr_private_key');
        $this->consumer_secret = $this->CI->config->item('oauthr_consumer_secret');
    }

    function add_param($param, $val = NULL)
    {
        if(is_array($param))
        {
            $this->_params = array_merge($this->_params, $param);
        }

        else if(is_string($param) && isset($val))
        {
            $this->_params[$param] = $val;
        }
    }

    function add_opt($opt, $val = NULL)
    {
        if(is_array($opt))
        {
            foreach($opt as $key => $val) $this->add_opt($key, $val);
        }

        else if(defined($opt) && isset($val))
        {
            $this->_opt[$opt] = $val;
        }
    }

    function request($url, $method = 'POST')
    {
        // Store the url and method as class variables
        $this->_url = $url;
        $this->_method = strtoupper($method);

        // Add a nonce and a timestamp to the parameters
        $this->_params['oauth_nonce']     = $this->_generate_nonce();
        $this->_params['oauth_timestamp'] = time();

        // Build signature, if user has not himself
        if(!isset($this->_params['oauth_signature'])) $this->_params['oauth_signature'] = $this->_build_signature();

        // Setup $init string based on method
        $init = (strtoupper($this->_method) == 'POST') ? $this->_url : $this->_url . '?' . $this->_build_http_query($this->_params);

        // Initialize a cURL request
        $this->_ch = curl_init($init);

        // Setup cURL options
        $this->_set_curl_opts();

        // Replace/add any cURL options if set
        if(!empty($this->_opt)) foreach($this->_opt as $op=> $val) curl_setopt($this->_ch, $opt, $val);

        // Execute the request
        $response = curl_exec($this->_ch);

        // Create an array of response
        $response = array('raw'                   => $response,
                          'curl_getinfo'          => curl_getinfo($this->_ch),
                          'sent_params'           => $this->_params,
                          'signature_base_string' => $this->_signature_base_string);

        // Close cURL request
        curl_close($this->_ch);
        
        return $response;
    }

    function _generate_nonce()
    {
        $mt = microtime();
        $rand = mt_rand();

        return md5($mt . $rand); // md5s look nicer than numbers
    }

    function _set_curl_opts()
    {
        // Primary cURL options
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($this->_ch, CURLOPT_FAILONERROR,    FALSE);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);

        // Method-specific cURL options
        if($this->_method == 'POST')
        {
            curl_setopt($this->_ch, CURLOPT_POST, TRUE);
            curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $this->_build_http_query($this->_params));
        }

        else
        {
            curl_setopt($this->_ch, CURLOPT_HTTPGET, TRUE);
        }

        // Set additional options if user is doing a secure request (SSL)
        if($this->_scheme == 'https')
        {
            curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, TRUE);
            curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        }
    }

    function _build_signature()
    {
        // HMAC-SHA1 signature support
        if(($this->_params['oauth_signature_method']) == 'HMAC-SHA1')
        {
            return $this->_build_hmac_signature();
        }
        // RSA-SHA1 signature support
        else if(($this->_params['oauth_signature_method']) == 'RSA-SHA1')
        {
            return $this->_build_rsa_signature();
        }
        // PLAINTEXT signature support
        else if(($this->_params['oauth_signature_method']) == 'PLAINTEXT')
        {
            return $this->_build_plaintext_signature();
        }
    }

    function _build_hmac_signature()
    {
        $this->_signature_base_string = $this->_get_signature_base_string();

        $key_parts = array(
          	$this->consumer_secret,
          	($this->token_secret) ? $this->token_secret : ""
        );

        $key_parts = $this->_urlencode_rfc3986($key_parts);
        $key = implode('&', $key_parts);

        return base64_encode(hash_hmac('sha1',  $this->_signature_base_string, $key, true));
    }

    function _build_rsa_signature()
    {
        $this->_signature_base_string = $this->_get_signature_base_string();

        // Sign using the private key
        openssl_sign($this->_signature_base_string, $signature, $this->private_key);

        return base64_encode($signature);
    }

    function _build_plaintext_signature()
    {
        $key_parts = array(
          	$this->consumer_secret,
          	($this->token_secret) ? $this->token_secret : ""
        );

        $key_parts = $this->_urlencode_rfc3986($key_parts);
        $key = implode('&', $key_parts);
        
        return $this->_urlencode_rfc3986($key);
    }

    function _get_signature_base_string()
    {
        $parts = array(
          $this->_get_normalized_http_method(),
          $this->_get_normalized_http_url(),
          $this->_build_http_query($this->_params)
        );

        $parts = $this->_urlencode_rfc3986($parts);

        return implode('&', $parts);
    }

    function _get_normalized_http_method()
    {
        return strtoupper($this->_method);
    }

    private function _get_normalized_http_url()
    {
        $parts = parse_url($this->_url);

        $scheme = (isset($parts['scheme'])) ? $parts['scheme'] : 'http';
        $port   = (isset($parts['port']))   ? $parts['port'] : (($scheme == 'https') ? '443' : '80');
        $host   = (isset($parts['host']))   ? $parts['host'] : '';
        $path   = (isset($parts['path']))   ? $parts['path'] : '';

        if (($scheme == 'https' && $port != '443') || ($scheme == 'http' && $port != '80'))
        {
            $host = "$host:$port";
        }

        // Save a class copy of the $scheme variable
        $this->_scheme = $scheme;

        return "$scheme://$host$path";
    }

    private function _build_http_query($params)
    {
        if (!$params) return '';

        // Urlencode both keys and values
        $keys = $this->_urlencode_rfc3986(array_keys($params));
        $values = $this->_urlencode_rfc3986(array_values($params));
        $params = array_combine($keys, $values);

        // Parameters are sorted by name, using lexicographical byte value ordering.
        // Ref: Spec: 9.1.1 (1)
        uksort($params, 'strcmp');

        $pairs = array();
        foreach ($params as $parameter => $value)
        {
            if (is_array($value))
            {
                // If two or more parameters share the same name, they are sorted by their value
                // Ref: Spec: 9.1.1 (1)
                // June 12th, 2010 - changed to sort because of issue 164 by hidetaka
                sort($value, SORT_STRING);
                foreach ($value as $duplicate_value)
                {
                    $pairs[] = $parameter . '=' . $duplicate_value;
                }
            }

            else
            {
                $pairs[] = $parameter . '=' . $value;
            }
        }

        // For each parameter, the name is separated from the corresponding value by an '=' character (ASCII code 61)
        // Each name-value pair is separated by an '&' character (ASCII code 38)
        return implode('&', $pairs);
    }

    function _urlencode_rfc3986($input)
    {
        if(is_array($input))
        {
            return array_map(array($this, '_urlencode_rfc3986'), $input);
        }

        else if(is_scalar($input))
        {
            return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
        }

        else
        {
            return '';
        }
    }
}