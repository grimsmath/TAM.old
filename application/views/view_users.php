<h1 class="blue-gradient">TAM Users</h1>

<?php
	$data['api']			= '/api/users';
	$data['apiNew'] 		= '/app/action/users/new';
	$data['apiEdit'] 		= '/app/action/users/edit/id/';
	$data['apiDelete']		= json_encode(array('object' 	=> 'user', 
												'api'		=> '/api/user',
												'returnApi'	=> '/api/users'));
	$data['isPasswordForm'] = true;

	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'user'));
?>

<?php $this->load->view('dialogs/password'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		// Handle the change password button
		$('#lnkPassword').click(function() {
			// retrieve the selected row
			var selected = TAM.getSelectedRows();
			
			// Update the id field for the dialog
			$('#id-hidden').val(selected[0][0]);
			
			// Show the password dialog
			TAM.showPasswordSetDialog($('#password_dialog'), 
									  $('#password'), 
									  $('#password_confirm'), 
									  $('#message'));
		});
		
		// Load the flexigrid
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 			name : 'id', 			width :  40, sortable : true, align: 'left'},
				{display: 'Username',		name : 'username', 		width : 100, sortable : true, align: 'left'},
				{display: 'First Name',		name : 'first_name',	width : 125, sortable : true, align: 'left'},
				{display: 'Last Name', 		name : 'last_name',		width : 125, sortable : true, align: 'left'},
				{display: 'Role', 			name : 'role_name',		width : 100, sortable : true, align: 'left'}				
			],
			searchitems : [
				{display: 'ID', 			name : 'id'},
				{display: 'Username', 		name : 'username'},
				{display: 'First Name',		name : 'first_name'},
				{display: 'Last Name',		name : 'last_name'},
				{display: 'Role',			name : 'role_name'}
			],
			autoload: true,
			sortname: "id",
			sortorder: "asc",
			usepager: true,
			showTableToggleBtn: false,
			useRp: true,
			rp: 25,
			height:364
		});
	});
</script>