<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		
		// Load necessary models
		$this->load->model('Users');
    } // end __construct()
	
	function index()
	{
		// Send the user to the login page
		$this->login();
	} // end index()

	function login()
	{
		$this->load->view('view_login');
	} // end login()

	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	} // end logout()

	function signup()
	{
		$this->load->view('view_signup');		
	} // end signup()
		
	function authenticate()
	{
		$return = false;

		// Retrieve the supplied credentials
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');

		// Make sure the user provided a username
		if ($this->Users->validate($username, $password)) 
		{
			echo "<h1>User is logged in</h1>";
			
			$data = array('username' 		=> $username,
						  'is_admin_user'	=> 'true',
						  'is_logged_in'	=> 'true');
			
			// Save the login status in the session
			$this->session->set_userdata($data);

			// User is logged in and authorized
			redirect('app/index');
        }
		else
		{
			// Redirect the user back to the login page
			redirect('login');
		} // endif
	} // end authenticate()
} // end Login class
