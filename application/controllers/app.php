<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		
		$this->_is_logged_in();
    }
	
	public function index()
	{
		$this->template->load('templates/main', 'view_dashboard');
	}
		
	public function action()
	{
		$this->_handle_view_state($this->uri->segment(3),
								  $this->uri->segment(4),
								  $this->uri->uri_to_assoc());	
	}
	
	public function config()
	{
		$view = $this->uri->segment(3);
		$this->_load_page('view_'.$view);
	}
	
	private function _handle_view_state($controller, $action, $full_uri)
	{
		// Define the default view/action relationship
		$views = array(	'new' 	=> 'view_'.$controller.'_form',
						'edit' 	=> 'view_'.$controller.'_form',
						'view' 	=> 'view_'.$controller	);
						
		$data["action"] = $action;
		$data["uri"] 	= json_encode($full_uri);

		$this->template->load('templates/main', $views[$action], $data);
	}

	private function _is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if (! isset($is_logged_in) || ! $is_logged_in)
		{
			redirect('login/index');
		}
	}
}

/* End of file app.php */
/* Location: ./application/controllers/app.php */