<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class People extends MY_Model 
{
	private $table_name = 'Person';
	private $view_name 	= 'VIEW_PEOPLE';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}