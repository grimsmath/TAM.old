<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Locations extends MY_Model 
{
	private $table_name = 'Location';
	private $view_name 	= 'VIEW_LOCATIONS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}