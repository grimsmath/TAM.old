<h1 class="blue-gradient">Operating Systems</h1>

<?php
	$data['api']		= '/api/operatingsystems';
	$data['apiNew'] 	= '/app/action/opersys/new';
	$data['apiEdit'] 	= '/app/action/opersys/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'operatingsystem', 
											'api'		=> '/api/operatingsystem',
											'returnApi'	=> '/api/operatingsystems'));

	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'operatingsystem'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.site_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 			name : 'id', 			width :  40, sortable : true, align: 'left'},
				{display: 'Name', 			name : 'os_name', 		width : 150, sortable : true, align: 'left'},
				{display: 'Manufacturer',	name : 'mfg_name', 	width : 100, sortable : true, align: 'left'},
				{display: 'Notes', 			name : 'os_notes', 		width : 400, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID', 	name : 'id'},
				{display: 'Name', 	name : 'os_name', isdefault: true}
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