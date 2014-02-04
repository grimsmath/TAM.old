<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class OperatingSystems extends MY_Model 
{
	private $table_name = 'OS';
	private $view_name 	= 'VIEW_OPERATINGSYSTEMS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}