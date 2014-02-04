<?php

class MY_Output extends CI_Output {
	const OUTPUT_MODE_NORMAL = 10;
	const OUTPUT_MODE_TEMPLATE = 11;

	const TEMPLATE_ROOT = "templates/";
	
	private $_title = "grocery CRUD";
	private $_charset = "utf-8";
	private $_language = "en-us";
	private $_meta = "";
	private $_rdf = "";
	private $_template = null;
	private $_mode = self::OUTPUT_MODE_NORMAL;
	private $_messages = array("error"=>"", "info"=>"", "debug"=>"");
	private $_output_data = array();
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Set the  template that should be contain the output <br /><em><b>Note:</b> This method set the output mode to MY_Output::OUTPUT_MODE_TEMPLATE</em>
	 * 
	 * @uses MY_Output::set_mode()
	 * @param string $template_view
	 * @return void
	 */
	function set_template($template_view){
		$this->set_mode(self::OUTPUT_MODE_TEMPLATE);
		$template_view = str_replace(".php", "", $template_view);
		$this->_template = self::TEMPLATE_ROOT . $template_view . "/template.php";
	}
	
	function unset_template()
	{
		$this->_template = null;
		$this->set_mode(self::OUTPUT_MODE_NORMAL);
	}
	
	/**
	 * Sets the way that the final output should be handled.<p>Accepts two possible values 	MY_Output::OUTPUT_MODE_NORMAL for direct output
	 * or MY_Output::OUTPUT_MODE_TEMPLATE for displaying the output contained in the specified template.</p>
	 * 
	 * @throws Exception when the given mode hasn't defined. 
	 * @param integer $mode one of the constants MY_Output::OUTPUT_MODE_NORMAL or MY_Output::OUTPUT_MODE_TEMPLATE
	 * @return void
	 */
	function set_mode($mode){
		
		switch($mode){
			case self::OUTPUT_MODE_NORMAL:
			case self::OUTPUT_MODE_TEMPLATE:
				$this->_mode = $mode;
				break;
			default:
				throw new Exception(lang("Unknown output mode."));
		}
		
		return;
	}
	
	/**
	 * Set the title of a page, it works only with MY_Output::OUTPUT_MODE_TEMPLATE
	 * 
	 * 
	 * @param string $title
	 * @return void
	 */
	function set_title($title){
		$this->_title = $title;
	}
	
	/**
	 * Append the given string at the end of the current page title
	 * 
	 * @param string $title
	 * @return void
	 */
	function append_title($title){
		$this->_title .= " - {$title}";
	}
	
	/**
	 * Prepend the given string at the bigining of the curent title.
	 * 
	 * @param string $title
	 * @return void
	 */
	function prepend_title($title){
		$this->_title = "{$title} - {$this->_title}";
	}

	/**
	 * Adds meta tags.
	 *
	 * @access protected
	 * @param string $name the name of the meta tag
	 * @param string $content the content of the mneta tag
	 * @return bool
	 */
	public function add_meta($name, $content){
		$this->_meta[$name] = $content;
		return true;
	}
  
    public function add_canonical_metatag($url)
    {
       $this->canonical = $url; 
    }
  
	/**
	 * Adds RDF meta tags (3rd generation meta tags).
	 *
	 * @access protected
	 * @param string $name the name of the meta tag
	 * @param string $content the content of the mneta tag
	 * @return bool
	 */
	public function add_RDF($name, $content){
		$this->_rdf[$name] = $content;
		return true;
	}
	
	public function _meta_rdf_title_packet($title,$description,$keywords)
	{
		$this->add_meta("description",$description);
		$this->add_meta("keywords",$keywords);
		$this->add_meta("DC.Title",$title);
		$this->add_meta("DC.Description",$description);
		$this->add_RDF("dc:title", $title);
		$this->add_RDF("dc:Description:",$description);
		$this->set_title($title);
	}
	
	
	function set_message($message, $type="error"){
		log_message($type, $message);
		$this->_messages[$type] .= $message;
		get_instance()->session->set_flashdata("__messages", serialize($this->_messages));
	}
	
	function get_messages($type="error"){
		return $this->_messages[$type];	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see system/libraries/CI_Output#_display($output)
	 */
	function _display($output=''){
		
		if($output=='')
			$output = $this->get_output();
		
		switch($this->_mode){
			case self::OUTPUT_MODE_TEMPLATE:
				$output = $this->get_template_output($output);
				break;
			case self::OUTPUT_MODE_NORMAL:
			default:
				$output = $output;
				break;		
		}
		
		parent::_display($output);
	}
	
	function set_output_data($varname, $value){
		$this->_output_data[$varname] = $value;
	}
	
	private function get_template_output($output){
		if(function_exists("get_instance")){
			$ci = get_instance();

			$this->_messages = null;				
			
			$data = array();
			
			$data["errors"] = $this->get_messages("error");
			$data["info"] = $this->get_messages("info");
			$data["debug"] = $this->get_messages("debug");
			
			$data["output"] = $output;
			$data["modules"] = $ci->load->get_sections();
			$data["title"] = $this->_title;
			$data["meta"] = $this->_meta;
			$data["language"] = $this->_language;
			$data["rdf"] = $this->_rdf;
			$data["charset"] = $this->_charset;
			$data["js"] = $ci->load->get_js_files();
			$data["css"] = $ci->load->get_css_files();
			$data["inline_scripting"] = '';
			
			$data = array_merge($data, $this->_output_data);
			
			$orig_view_path = $ci->load->_ci_view_path;
			$ci->load->_ci_view_path = '';
			
			$output = $ci->load->view($this->_template, $data, true, true);
			$ci->load->_ci_view_path = $orig_view_path;

		}
			
		return $output;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see system/libraries/CI_Output#_display_cache($CFG, $URI)
	 */
	function _display_cache(&$CFG, &$URI){
		return parent::_display_cache($CFG, $URI);
	}
	
	private function _get_content_type($filepath, $content_type){
		if(file_exists($filepath)){
			$fp = fopen($filepath, "rb");
			
			$line = $fp != false ? fgets($fp) : "";
			
			if($fp)
				fclose($fp);
			
			$matches = array();
			preg_match("/\/\*\s{1,}(CSS|JS){1}\s{1,}\*\//", $line, $matches);
			
			if(isset($matches[1])){
				switch($matches[1]){
					case "JS":
						$content_type = "text/javascript";
						break;
					case "CSS":
						$content_type = "text/css";
						break;
				}
			}
		}
		
		return $content_type;
	}
	
	private function _debug(){
		$ci = &get_instance();
		
		if(isset($ci->load->firephp)){
			$ci->firephp->dump("error", $this->_messages["error"]);
		}
	}
}


/* End of file  user  */
/* Location:  file_path */