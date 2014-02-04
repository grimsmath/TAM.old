<h1 class="blue-gradient">Assets</h1>

<?php
	$data['api']		= '/api/assets';
	$data['apiNew'] 	= '/app/action/assets/new';
	$data['apiEdit'] 	= '/app/action/assets/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'asset', 
											'api'		=> '/api/asset',
											'returnApi'	=> '/api/assets'));

	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'asset'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 		name : 'id', 			width :  50, sortable : true, align: 'left'},
				{display: 'Decal #', 	name : 'asset_decal', 	width : 100, sortable : true, align: 'left'},
				{display: 'Serial #', 	name : 'asset_serial', 	width : 100, sortable : true, align: 'left'},
				{display: 'Model', 		name : 'model_name', 	width : 125, sortable : true, align: 'left'},
				{display: 'RAM', 		name : 'asset_ram',		width :  50, sortable : true, align: 'left'},
				{display: 'CPU', 		name : 'cpu_name', 		width : 100, sortable : true, align: 'left'},
				{display: 'Location',	name : 'loc_name', 		width : 125, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID', 		name : 'id'},
				{display: 'Decal #', 	name : 'Decal', isdefault: true}
			],
			sortname: "Decal",
			sortorder: "asc",
			usepager: true,
			useRp: true,
			rp: 15,
			height: 364,
			showTableToggleBtn: false,
		});
	});
</script>