<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class Users extends MY_Model 
{
	private $table_name = 'User';
	private $view_name 	= 'VIEW_USERS';
	
	function __construct()
    {
        parent::__construct($this->table_name, 
        					$this->view_name);
    } // end __construct()
	
	function validate($username, $password)
	{
		// Using active record
		$this->db->where('username', $username);
		
		// Retrieve the user record
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			
			// Decode the passwords and compare
			$pass = $this->encrypt->decode($row->password);
			
			// Compare the passwords
			if ($pass == $password)
			{
				// Passwords match
				return true;
			}
			else
			{
				// Passwords don't match
				return false;
			} // endif			
		}
		else
		{
			return (false);
		} // endif
	} // end validate()
} // end Users class
