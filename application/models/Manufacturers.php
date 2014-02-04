<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Manufacturers extends MY_Model 
{
	private $table_name = 'Manufacturer';
	private $view_name 	= 'VIEW_MANUFACTURERS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}
