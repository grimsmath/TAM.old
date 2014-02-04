<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Assignments extends CI_Model 
{
	private $table_name = 'Assignment';
	private $view_name 	= 'VIEW_ASSIGNMENTS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}