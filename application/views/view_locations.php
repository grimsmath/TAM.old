<h1 class="blue-gradient">Locations</h1>

<?php
	$data['api']		= '/api/locations';
	$data['apiNew'] 	= '/app/action/locations/new';
	$data['apiEdit'] 	= '/app/action/locations/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'asset', 
											'api'		=> '/api/location',
											'returnApi'	=> '/api/locations'));
	
	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'location'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 		name: 'id', 			width :  50, sortable : true, align: 'left'},
				{display: 'Name', 		name: 'loc_name', 		width : 125, sortable : true, align: 'left'},
				{display: 'Type', 		name: 'loc_type_name',	width : 100, sortable : true, align: 'left'},
				{display: 'Building', 	name: 'loc_building', 	width : 100, sortable : true, align: 'left'},
				{display: 'Floor', 		name: 'loc_floor', 		width : 100, sortable : true, align: 'left'},
				{display: 'Room', 		name: 'loc_room', 		width : 100, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID', 		name: 'id'},
				{display: 'Name', 		name: 'loc_name', 		isdefault: true},
				{display: 'Type',		name: 'loc_type_name', 	isdefault: true},
				{display: 'Building',	name: 'loc_building', 	isdefault: true},
				{display: 'Floor',		name: 'loc_floor', 		isdefault: true},
				{display: 'Room',		name: 'loc_room', 		isdefault: true}
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