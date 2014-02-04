<?php

class MY_Loader extends CI_Loader {
	
	private $_javascript = array();
	private $_css = array();
	private $_inline_scripting = array("infile"=>"", "stripped"=>"", "unstripped"=>"");
	private $_inline_style = array("infile"=>"", "stripped"=>"", "unstripped"=>"");
	private $_sections = array();
	
	function __construct(){
		parent::__construct();
	}
	
	function css(){
		$css_files = func_get_args();
		
		foreach($css_files as $css_file){
			$is_external = false;
			if(is_bool($css_file))
				continue;
				
			if(substr($css_file,0,1) == "/")
			{
				$css_file = "http://".$_SERVER['HTTP_HOST'].$css_file;
			}
				
			$is_external = preg_match("/^https?:\/\//", trim($css_file)) > 0 ? true : false;
			
			if(!$is_external)
				if(!file_exists($css_file))
					show_error("Cannot locate javascript file: {$css_file}.");		
					
			$css_file = $is_external == FALSE ? base_url() . $css_file : $css_file;
			
			if(!in_array($css_file, $this->_css))
				$this->_css[] = $css_file;
		}
		return;
	}
	
	function js(){
		$script_files = func_get_args();
		
		foreach($script_files as $script_file){
			
			$is_external = false;
			if(is_bool($script_file))
				continue;
			
			if(substr($script_file,0,1) == "/")
			{
				$script_file = "http://".$_SERVER['HTTP_HOST'].$script_file;
			}
				
			$is_external = preg_match("/^https?:\/\//", trim($script_file)) > 0 ? true : false;
			
			if(!$is_external)
				if(!file_exists($script_file) && !file_exists($script_file))
					show_error("Cannot locate javascript file: {$script_file}.");
			
			$script_file = $is_external == FALSE 
				?  base_url() . $script_file 
				: $script_file;
					
			if(!in_array($script_file, $this->_javascript))
				$this->_javascript[] = $script_file ;
	
		}
		
		return;
	}
	
	function get_css_files(){
		return $this->_css;
	}
	
	function get_js_files(){
		return $this->_javascript;
	}
	
	/**
	 * Loads the requested view in the given area
	 * <em>Useful if you want to fill a side area with data</em>
	 * <em><b>Note: </b> Areas are defined by the template, those might differs in each template.</em>
	 * 
	 * @param string $area
	 * @param string $view
	 * @param array $data
	 * @return string
	 */
	function section($area, $view, $data=array()){
		$ci = &get_instance();
		
		if(!array_key_exists($area, $this->_sections))
			$this->_sections[$area] = array();
	
		$orig_view_path = $ci->load->_ci_view_path;
		$ci->load->_ci_view_path = APPPATH.'third_party/grocery_crud/views/';
		$content = $ci->load->view($view, $data, true);
		$ci->load->_ci_view_path = $orig_view_path;
		
		$checksum = md5( $view . serialize($data) );

		$this->_sections[$area][$checksum] = $content;
		
		return $checksum;
	}
	
	/**
	 * Gets the declared sections
	 * 
	 * @return object
	 */
	function get_sections(){
		return (object)$this->_sections;
	}
	
	
}	
/* End of file  user  */
/* Location:  file_path */