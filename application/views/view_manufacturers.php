<h1 class="blue-gradient">Manufacturers</h1>

<?php
	$data['api']		= '/api/manufacturers';
	$data['apiNew'] 	= '/app/action/manufacturers/new';
	$data['apiEdit'] 	= '/app/action/manufacturers/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'manufacturer', 
											'api'		=> '/api/manufacturer',
											'returnApi'	=> '/api/manufacturers'));

	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'manufacturer'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 		name : 'id', 			width :  40, sortable : true, align: 'left'},
				{display: 'Name', 		name : 'mfg_name', 		width : 150, sortable : true, align: 'left'},
				{display: 'Website', 	name : 'mfg_website', 	width : 250, sortable : true, align: 'left'},
				{display: 'Notes', 		name : 'mfg_notes', 	width : 400, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID', 	name : 'id'},
				{display: 'Name', 	name : 'mfg_name', isdefault: true}
			],
			sortname: "id",
			sortorder: "asc",
			usepager: true,
			showTableToggleBtn: false,
			useRp: true,
			rp: 25,
			height: 364
		});
	});
</script>