<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Default parameters to be sent on each OAuth request
$config['oauthr_params'] = array('oauth_consumer_key'     => '',
                                 'oauth_signature_method' => '',
                                 'oauth_version'          => '1.0');

// Consumer secret used during building HMAC-SHA1 signatures.
// ** Required if you are using the HMAC-SHA1 signature method **
$config['oauthr_consumer_secret'] = '';

// Private key used during building RSA-SHA1 signatures.
// ** Required if you are using the RSA-SHA1 signature method **
$config['oauthr_private_key']     = '';
