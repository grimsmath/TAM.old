<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Statistics extends CI_Model 
{
	private $table_name = '';
	private $view_name 	= 'VIEW_DASHBOARD';

    function __construct()
    {
        parent::__construct();
    }
    
    function get()
    {
    	$return = NULL;
        $query 	= $this->db->get($this->view_name);
		
        if ($query->num_rows() > 0)
        {
            $return = $query->row(0);   
        }

		return ($return);
    }
}