<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Assets extends MY_Model 
{
	private $table_name = 'Asset';
	private $view_name 	= 'VIEW_ASSETS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}
