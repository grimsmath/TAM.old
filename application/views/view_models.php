<h1 class="blue-gradient">Models</h1>

<?php
	$data['api']		= '/api/models';
	$data['apiNew'] 	= '/app/action/models/new';
	$data['apiEdit'] 	= '/app/action/models/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'model', 
											'api'		=> '/api/model',
											'returnApi'	=> '/api/models'));

	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'model'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 			name: 'id', 			width :  40, sortable : true, align: 'left'},
				{display: 'Name', 			name: 'model_name', 	width : 150, sortable : true, align: 'left'},
				{display: 'Manufacturer', 	name: 'mfg_name',	 	width : 100, sortable : true, align: 'left'},
				{display: 'Notes', 			name: 'model_notes', 	width : 400, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID', 	name : 'id'},
				{display: 'Name', 	name : 'model_name', isdefault: true}
			],
			sortname: "name",
			sortorder: "asc",
			usepager: true,
			showTableToggleBtn: false,
			useRp: true,
			rp: 25,
			height: 364
		});
	});
</script>