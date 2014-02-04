<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class History extends MY_Model 
{
	private $table_name = 'History';
	private $view_name 	= 'VIEW_HISTORY';

    public function __construct() 
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    }
	
	public function get($object, $id)
	{
		$table_name = '';
		
		// Using active record
		$this->db->where('table_name', $object);
		$this->db->where('row_id', $id);
		$this->db->order_by("date", "desc"); 
		$this->db->order_by("time", "desc");
		
		// Retrieve the user record
		$query = $this->db->get($this->table_name);
				
		
	} // end get()
	
	private function asset_history_get($id)
	{
		
	}
}