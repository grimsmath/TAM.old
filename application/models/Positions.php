<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Positions extends MY_Model 
{
	private $table_name = 'Position';
	private $view_name 	= 'VIEW_POSITIONS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}