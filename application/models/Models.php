<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Models extends MY_Model 
{
	private $table_name = 'Model';
	private $view_name 	= 'VIEW_MODELS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}