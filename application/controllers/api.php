<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MY_Controller  
{
	function __construct()
	{
		parent::__construct();
		
		// Load the models
		$this->load->model('Assets');
		$this->load->model('Assignments');
		$this->load->model('Locations');
		$this->load->model('Manufacturers');
		$this->load->model('Models');
		$this->load->model('OperatingSystems');
		$this->load->model('People');
		$this->load->model('Positions');
		$this->load->model('Processors');
		$this->load->model('Statistics');
		$this->load->model('History');
		$this->load->model('Users');
		$this->load->model('Status');
	} // end __construct()
	 
	/**
	 * Begin: Dashboard Statistics
	 */
	function statistics_get()
	{
		$value = $this->Statistics->get();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		} // endif
	} // end statistics_get()
	
	/**
	 * Begin: History functions
	 */
	function history_get()
	{
		$object = $this->get('object');
		$id 	= $this->get('id');
		
		// Retrieve the data
		$value = $this->History->get($object, $id);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		} // endif		
	} // end history_get()
	
	/**
	 * Begin: Asset functions
	 */
	function asset_get()
	{
		$value = $this->Assets->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		} // endif
	} // end asset_get()

	function assets_get()
	{
		$value = $this->Assets->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}		
	}

	function assetoptions_get()
	{
		$value = $this->Assets->get_options('asset_decal');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
		
	function asset_post()
	{
		$values = array(	'asset_decal' 			=> $this->post('asset_decal'),
							'asset_serial' 			=> $this->post('asset_serial'),
							'asset_mac_addr' 		=> $this->post('asset_mac_addr'),
							'asset_wifi_mac_addr' 	=> $this->post('asset_wifi_mac_addr'),
							'asset_purchase_date' 	=> $this->post('asset_purchase_date'),
							'asset_warranty_begin' 	=> $this->post('asset_warranty_begin'),
							'asset_warranty_end' 	=> $this->post('asset_warranty_end'),
							'asset_loc_id' 			=> $this->post('asset_loc_id'),
							'asset_status_id' 		=> $this->post('asset_status_id'),
							'asset_model_id' 		=> $this->post('asset_model_id'),
							'asset_cpu_id' 			=> $this->post('asset_cpu_id'),
							'asset_ram' 			=> $this->post('asset_ram'),
							'asset_survey_number' 	=> $this->post('asset_survey_number'),
							'asset_survey_date' 	=> $this->post('asset_survey_date')		);
		
		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Create or update the record
		$value = $this->Assets->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function asset_delete()
	{
		$value = $this->Assets->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	/**
	 * Begin: Assignment functions
	 */
	function assignment_get() 
	{	
		$value = $this->Assignments->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}
	
	function assignments_get()
	{
		$value = $this->Assignments->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}
	
	function assignment_post()
	{
		$values = array(	'asset_decal' 	=> $this->post('asset_decal'),
							'asset_serial' 	=> $this->post('asset_serial')	);
		
		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Create or update the record
		$value = $this->Assignments->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
		
	}

	function assignment_delete($id)
	{
		$value = $this->Assignments->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}		
	}

	/**
	 * Begin: OperatingSystem functions
	 */
	function operatingsystem_get()
	{
		$value = $this->OperatingSystems->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function operatingsystems_get()
	{
		$value = $this->OperatingSystems->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}
	
	function operatingsystem_post()
	{
		$values = array(	'os_name' 		=> $this->post('os_name'),
							'os_mfg_id' 	=> $this->post('os_mfg_id'),
							'os_notes' 		=> $this->post('os_notes')		);
		
		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Create or update the record
		$value = $this->OperatingSystems->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function operatingsystem_delete()
	{
		$value = $this->OperatingSystems->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	/**
	 * Begin: Processor functions
	 */
	function processor_get()
	{
		$value = $this->Processors->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function processors_get()
	{
		$value = $this->Processors->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function processoroptions_get()
	{
		$value = $this->Processors->get_options('cpu_name');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function processor_post()
	{
		$values = array(	'cpu_name' 		=> $this->post('cpu_name'),
							'cpu_mfg_id' 	=> $this->post('cpu_mfg_id'),
							'cpu_notes' 	=> $this->post('cpu_notes')		);

		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Create or update the record
		$value = $this->Processors->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function processor_delete()
	{
		$value = $this->Processors->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	/**
	 * Begin: Manufacturer functions
	 */
	function manufacturers_get()
	{
		$value = $this->Manufacturers->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function manufacturer_get()
	{
		$value = $this->Manufacturers->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}
	
	function manufactureroptions_get()
	{
		$value = $this->Manufacturers->get_options('mfg_name');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	function manufacturer_post()
	{
		$values = array(	'mfg_name' 		=> $this->post('mfg_name'),
							'mfg_website' 	=> $this->post('mfg_website'),
							'mfg_notes' 	=> $this->post('mfg_notes')		);

		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Create or update the record
		$value = $this->Manufacturers->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function manufacturer_delete()
	{
		$value = $this->Manufacturers->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	/**
	 * Begin: Model functions
	 */
	function models_get()
	{
		$value = $this->Models->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}
	
	function model_get()
	{
		$value = $this->Models->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}
	
	function model_post()
	{
		$values = array(	'model_name' 	=> $this->post('model_name'),
							'model_mfg_id' 	=> $this->post('model_mfg_id'),
							'model_notes' 	=> $this->post('model_notes')		);

		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Create or update the record
		$value = $this->Models->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function model_delete()
	{
		$value = $this->Models->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	function modeloptions_get()
	{
		$value = $this->Models->get_options('model_name');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	/**
	 * Begin: Location functions
	 */
	function locations_get()
	{
		$value = $this->Locations->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function location_get()
	{
		$value = $this->Locations->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function location_post()
	{
		$values = array(	'loc_name' 		=> $this->post('loc_name'),
							'loc_building' 	=> $this->post('loc_building'),
							'loc_floor' 	=> $this->post('loc_floor'),
							'loc_room' 		=> $this->post('loc_room'),
							'loc_type_id' 	=> $this->post('loc_type_id'),
							'loc_notes' 	=> $this->post('loc_notes')			);

		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Insert or update the record
		$value = $this->Locations->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function location_delete()
	{
		$value = $this->Locations->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	function locationoptions_get()
	{
		$value = $this->Locations->get_options('loc_name', 'VIEW_LOCATIONS');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	function locationtypeoptions_get()
	{
		$value = $this->Locations->get_options('loc_type_name', 'LocationType');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	/**
	 * Begin: People functions
	 */
	function people_get()
	{
		$value = $this->People->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function person_get()
	{
		$value = $this->People->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}
	
	function person_post()
	{
		$values = array(	'person_username' 	=> $this->post('person_username'),
							'person_f_name' 	=> $this->post('person_f_name'),
							'person_l_name' 	=> $this->post('person_l_name'),
							'person_email' 		=> $this->post('person_email'),
							'person_extension' 	=> $this->post('person_extension'),
							'person_loc_id' 	=> $this->post('person_loc_id')		);

		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : '';

		// Create or update the record
		$value = $this->People->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function person_delete()
	{
		$value = $this->People->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function peopleoptions_get()
	{
		$value = $this->People->get_options('person_username');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	/**
	 * Begin: Position functions
	 */
	function positions_get()
	{
		$value = $this->Positions->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function position_get()
	{
		$value = $this->Positions->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function positionoptions_get()
	{
		$value = $this->Positions->get_options('position_name');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function position_post()
	{
		$values = array(	'position_name' 		=> $this->post('position_name'),
							'position_number' 		=> $this->post('position_number'),
							'position_person_id' 	=> $this->post('position_person_id'),
							'position_currency' 	=> $this->post('position_currency')		);
		
		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : NULL;

		// Create or update the record
		$value = $this->Positions->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function position_delete()
	{
		$value = $this->Positions->delete($this->delete('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	/**
	 * Begin: User functions
	 */
	function users_get()
	{
		$value = $this->Users->get_all();
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function user_get()
	{
		$value = $this->Users->get($this->get('id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}
	}

	function userroleoptions_get()
	{
		$value = $this->Users->get_options('role_name', 'UserRole');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	function userpassword_post()
	{
		// We need to encrypt the password before storing
		$password = $this->encrypt->encode($this->post('password'));

		// Build the array of values to send to the db
		$values = array('password' => $password);

		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id-hidden') != '') ? $this->post('id-hidden') : '';

		// Update the record
		$value = $this->Users->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function user_post()
	{
		// We need to encrypt the password before storing
		$password = $this->encrypt->encode($this->post('password'));

		// Build the array of values to send to the db
		$values = array(	'username' 			=> $this->post('username'),
							'password'	 		=> $password,
							'first_name'		=> $this->post('first_name'),
							'last_name'			=> $this->post('last_name'),
							'user_role_id'		=> $this->post('user_role_id'),
							'user_is_active'	=> $this->post('user_is_active')	);

		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : '';

		// Create or update the record
		$value = $this->Users->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}

	function user_delete()
	{
		$value = $this->Users->delete($this->delete('user_id'));
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	function statusoptions_get()
	{
		$value = $this->Status->get_options('status_name');
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}	
	}
	
	function comment_post()
	{
		$id 	= $this->post('id-hidden');
		$object = array();
		
		switch (objectType) {
			case 'asset':
				$object = array('comment_decal_id' => $id);
				break;
			case 'assignment':
				$object = array('comment_assignment_id' => $id);
				break;
			case 'manufacturer':
				$object = array('comment_mfg_id' => $id);
				break;
			case 'model':
				$object = array('comment_model_id' => $id);
				break;
			case 'processor':
				$object = array('comment_processor_id' => $id);
				break;
			case 'opersys':
				$object = array('comment_os_id' => $id);
				break;
			case 'people':
				$object = array('comment_person_id' => $id);
				break;
			case 'position':
				$object = array('comment_position_id' => $id);
				break;
			case 'location':
				$object = array('comment_location_id' => $id);
				break;
		}
		
		// Build the array of values to send to the db
		$values = array(	'comment_title' 	=> $this->post('username'),
							'comment_text' 		=> $this->post('comment_text'),
							'comment_date'		=> date("m/d/y", time()),
							'comment_time'		=> date("H:i:s", time())		);

		$values = array_merge($values, $object);
		
		// Here we determine if we are inserting a new record ($id = NULL), or 
		// if we are updating an existing record ($id != '');
		$id = ($this->post('id') != '') ? $this->post('id') : '';

		// Create or update the record
		$value = $this->Users->put($id, $values);
		if ($value)
		{
			$this->response($value, 200); 
		}
		else
		{
			$this->response($value, 404);
		}			
	}
}

/* End of file API.php */
/* Location: ./application/controllers/API.php */