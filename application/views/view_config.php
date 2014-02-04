<h1 class="blue-gradient">System Configuration</h1>
<div class="command-bar">
	<ul>
		<li><a href="#">Edit</a></li>
	<ul>
</div>			
<div class="data-table-container">
	<div id="dataTable"></div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').flexigrid({
			url: CI.base_url + '/api/getConfig',
			dataType: 'json',
			colModel : [
				{display: 'Key', 	name : 'key', 		width : 150, sortable : true, align: 'left'},
				{display: 'Value', 	name : 'value', 	width : 250, sortable : true, align: 'left'},
				{display: 'Locked', name : 'locked', 	width :  50, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'Key', 	name : 'key', isdefault: true},
				{display: 'Value', 	name : 'value'}
			],
			autoload: false,
			sortname: "Key",
			sortorder: "asc",
			title: 'All Configuration Options',
			usepager: true,
			useRp: true,
			rp: 15,
			height: 350,
			showTableToggleBtn: false,
		});
	});
</script>