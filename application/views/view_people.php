<h1 class="blue-gradient">People</h1>

<?php
	$data['api']		= '/api/people';
	$data['apiNew'] 	= '/app/action/people/new';
	$data['apiEdit'] 	= '/app/action/people/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'person', 
											'api'		=> '/api/person',
											'returnApi'	=> '/api/people'));

	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'person'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 		name : 'id', 				width :  40, sortable : true, align: 'left'},
				{display: 'Username',	name : 'person_username',	width : 100, sortable : true, align: 'left'},
				{display: 'Last Name',	name : 'person_l_name', 	width : 100, sortable : true, align: 'left'},
				{display: 'First Name',	name : 'person_f_name',		width : 100, sortable : true, align: 'left'},
				{display: 'Email', 		name : 'person_email',		width : 150, sortable : true, align: 'left'},
				{display: 'Extension',	name : 'person_extension',	width :  50, sortable : true, align: 'left'},
				{display: 'Location',	name : 'loc_name',			width : 200, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID', 		name : 'id'},
				{display: 'Username',	name : 'person_username', isdefault: true},
				{display: 'Last Name', 	name : 'person_l_name',},
				{display: 'First Name',	name : 'person_f_name',},
				{display: 'Email',		name : 'person_email',},
				{display: 'Extension',	name : 'person_extension',}
			],
			sortname: "person_username",
			sortorder: "asc",
			usepager: true,
			showTableToggleBtn: false,
			useRp: true,
			rp: 25,
			height:364
		});
	});
</script>