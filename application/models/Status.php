<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Status extends MY_Model 
{
	private $table_name = 'Status';
	private $view_name 	= 'VIEW_STATUSES';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}