<h1 class="blue-gradient">Positions</h1>

<?php
	$data['api']		= '/api/positions';
	$data['apiNew'] 	= '/app/action/positions/new';
	$data['apiEdit'] 	= '/app/action/positions/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'position', 
											'api'		=> '/api/position',
											'returnApi'	=> '/api/positions'));

	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'position'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 		name: 'id', 				width :  50, sortable : true, align: 'left'},
				{display: 'Name', 		name: 'position_name', 		width : 125, sortable : true, align: 'left'},
				{display: 'Number', 	name: 'position_number', 	width : 100, sortable : true, align: 'left'},
				{display: 'Username', 	name: 'person_username', 	width : 100, sortable : true, align: 'left'},
				{display: 'Last Name', 	name: 'person_l_name', 		width : 100, sortable : true, align: 'left'},
				{display: 'First Name', name: 'person_f_name', 		width : 100, sortable : true, align: 'left'},
				{display: 'Currency', 	name: 'position_currency',	width : 100, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID', 		name : 'id'},
				{display: 'Name', 		name : 'position_name', isdefault: true}
			],
			sortname: "id",
			sortorder: "asc",
			usepager: true,
			useRp: true,
			rp: 15,
			height: 364,
			showTableToggleBtn: false,
		});
	});
</script>