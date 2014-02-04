<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Comments extends CI_Model 
{
	private $table_name = 'Comment';
	private $view_name 	= 'VIEW_COMMENTS';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
}