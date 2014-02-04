<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Processors extends MY_Model 
{
	private $table_name = 'CPU';
	private $view_name 	= 'VIEW_PROCESSORS';

	public function __construct()
	{
		parent::__construct($this->table_name, 
							$this->view_name);
	}
}