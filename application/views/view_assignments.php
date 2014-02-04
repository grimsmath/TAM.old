<h1 class="blue-gradient">Assignments</h1>

<?php
	$data['api']		= '/api/assignments';
	$data['apiNew'] 	= '/app/action/assignments/new';
	$data['apiEdit'] 	= '/app/action/assignments/edit/id/';
	$data['apiDelete']	= json_encode(array('object' 	=> 'assignment', 
											'api'		=> '/api/assignment',
											'returnApi'	=> '/api/assignments'));
	
	$this->load->view('partials/commands_list', $data);
	$this->load->view('partials/flexigrid');
	$this->load->view('dialogs/comments', array('object' => 'assignment'));
?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.base_url + "<?php echo $data['api']; ?>",
			dataType: 'json',
			method: 'GET',
			colModel : [
				{display: 'ID', 		name : 'id', 		width :  50, sortable : true, align: 'left'},
				{display: 'Decal #', 	name : 'Decal', 	width : 100, sortable : true, align: 'left'},
				{display: 'Position', 	name : 'Serial', 	width : 100, sortable : true, align: 'left'},
				{display: 'User', 		name : 'User', 		width : 100, sortable : true, align: 'left'},
				{display: 'Currency', 	name : 'Currency', 	width : 100, sortable : true, align: 'left'}				
			],
			searchitems : [
				{display: 'ID', 		name : 'id'},
				{display: 'Decal #', 	name : 'Decal', isdefault: true}
			],
			autoload: false,
			sortname: "Decal",
			sortorder: "asc",
			usepager: true,
			useRp: true,
			rp: 15,
			height:364,
			showTableToggleBtn: false,
		});
	});
</script>