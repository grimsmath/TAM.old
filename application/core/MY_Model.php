<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
define('SPACE', ' ');

class MY_Model extends CI_Model 
{
	const BOOL_YES 			= 'Yes';
	const BOOL_NO 			= 'No';
	const ACTION_STATUS		= 'status';
	const ACTION_ACTION		= 'action';
	const ACTION_INSERT		= 'Insert';
	const ACTION_UPDATE 	= 'Update';
	const ACTION_DELETE		= 'Delete';
	const STATUS_SUCCESS	= 'Success';
	const STATUS_FAILED		= 'Failure';
	const OPTION_DISPLAY	= 'optionDisplay';
	const OPTION_VALUE		= 'optionValue';
	
	private $table_name 	= '';
	private $view_name 		= '';

	function __construct($table_name = '', $view_name = '')
	{
		parent::__construct();
		
		// Set the instance values
		$this->table_name 	= $table_name;
		$this->view_name 	= $view_name;		
	}
	
	private function _get_action_status($status, $action)
	{
		$return = NULL;
		
		if ($status == FALSE)
		{
			$return = array(self::ACTION_STATUS => self::STATUS_FAILED, 
							self::ACTION_ACTION => $action); 
		}
		else
		{
			$return = array(self::ACTION_STATUS => self::STATUS_SUCCESS, 
							self::ACTION_ACTION => $action); 			
		}
		
		return ($return);
	}
	
	private function _add_history_item($table_name, $row_id, $username, $action, $sql_statement)
	{
		$return			= NULL;
		$rows_affected 	= 0;
		$values 		= array(	'date' 			=> date("m/d/y", time()),
									'time' 			=> date("H:i:s", time()),
									'table_name' 	=> $table_name,
									'row_id'		=> $row_id,
									'action'		=> $action,
									'username'		=> $username,
									'sql_statement'	=> $sql_statement			);
		
		// Create a new record
		$this->db->insert('History', $values);
		
		$rows_affected 	= $this->db->affected_rows();
		$action 		= self::ACTION_INSERT;

		// Check to see if we succeeded
		$return = ($rows_affected > 0) 	? $this->_get_action_status(TRUE, $action) 
										: $this->_get_action_status(FALSE, $action);
		
		return ($return);
	}
	
	public function get($id) 
	{
		$return = NULL;
		$query 	= $this->db->get_where($this->table_name, array('id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$return = $query->row(0);
		}
		
		return ($return);			
	}
	
	public function get_all()
	{
		// Retrieve the values from the view, NOT from the table!
		// this requires that the view_name be defined by the child class
		// and passed into the parent class via the constructor.  This also
		// means that the view defined in the child class be created in
		// the database.
		$query = $this->db->get($this->view_name);
		
		$data 			= array();
		$data['page'] 	= 1;
		$data['total'] 	= $query->num_rows();
		$data['rows'] 	= array();

		foreach($query->result() as $row)
		{
			$data['rows'][] = array('id' 	=> $row->id,
									'cell' 	=> $row);
		}
		
		return ($data);		
	}

	public function get_options($field_name, $table_name = '', $options = array())
	{
		$data 	= array();
		$table 	= ($table_name != '') ? $table_name : $this->table_name;
		
		// Execute the query and get the values
		$query = $this->db->get($table);	
		foreach($query->result_array() as $row)
		{
			// Start with the field_name
			$display = $row[$field_name];

			// Add the optionValue/optionDisplay to the array
			$data[] = array(self::OPTION_VALUE 		=> $row['id'], 
							self::OPTION_DISPLAY 	=> $display);					
		}
		
		return ($data);
	}
		
	public function put($id, $values)
	{
		$action			= '';
		$return			= NULL;
		$rows_affected 	= 0;
		
		if ($id != '')
		{
			// Update the existing record
			$this->db->where('id', $id);
			$this->db->update($this->table_name, $values);
			
			// These values control the return to the view
			$rows_affected 	= $this->db->affected_rows();
			$action 		= self::ACTION_UPDATE;
			
			// Generate the history item
			$this->_add_history_item(	$this->table_name, 
									 	$id, 
									 	'', 
									 	$action, 
									 	$this->db->last_query()		);
		}
		else
		{
			// Create a new record
			$this->db->insert($this->table_name, $values);

			// These values control the return to the view
			$rows_affected 	= $this->db->affected_rows();
			$action 		= self::ACTION_UPDATE;
			
			// Generate the history item
			$this->_add_history_item(	$this->table_name, 
								   		$this->db->insert_id(), 
										'', 
										$action,
										$this->db->last_query()		);
		}

		// Check to see if we succeeded
		$return = ($rows_affected > 0) 	? $this->_get_action_status(TRUE, $action) 
										: $this->_get_action_status(FALSE, $action);

		// Save some info for debug purposes 
		$debug = array(	'id' 			=> $id, 
						'table' 		=> $this->table_name,
						'rows_affected' => $rows_affected		);
		
		// Merge debug info with return info
		$return = array_merge($return, $debug);
		
		return ($return);		
	}
	
	public function delete($id)
	{
		// Perform the delete based on the passed-in $id
		$this->db->where('id', $id);
		$this->db->delete($this->table_name); 
		
		// These values control the return to the view
		$rows_affected 	= $this->db->affected_rows();
		$action 		= self::ACTION_DELETE;
			
		// Check to see if we succeeded
		$return = ($rows_affected > 0) 	? $this->_get_action_status(TRUE, $action) 
									 	: $this->_get_action_status(FALSE, $action);

		// Save some info for debug purposes 
		$debug = array(	'id' 			=> $id, 
						'table' 		=> $this->table_name,
						'rows_affected' => $rows_affected		);
		
		// Merge debug info with return info
		$return = array_merge($return, $debug);
		
		return ($return);	
	}	
}
	