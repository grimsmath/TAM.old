<div id="navleft">
	<div class="panel">
		<h1 class="blue-gradient active">Main Menu</h1>
		<ul>
			<li><?php echo anchor('/', 								'Dashboard', 			array('id' => 'lnkDashboard')); 		?></li>
			<li><?php echo anchor('app/action/assets/view', 		'Assets', 				array('id' => 'lnkAssets')); 			?></li>
			<li><?php echo anchor('app/action/assignments/view', 	'Assignments', 			array('id' => 'lnkAssignments')); 		?></li>
			<li><?php echo anchor('app/action/models/view', 		'Models', 				array('id' => 'lnkModels'));			?></li>
			<li><?php echo anchor('app/action/manufacturers/view', 	'Manufacturers', 		array('id' => 'lnkManufacturers')); 	?></li>
			<li><?php echo anchor('app/action/processors/view', 	'Processors', 			array('id' => 'lnkProcessors')); 		?></li>
			<li><?php echo anchor('app/action/opersys/view', 		'Operating Systems', 	array('id' => 'lnkOperatingSystems')); 	?></li>
			<li><?php echo anchor('app/action/locations/view', 		'Locations', 			array('id' => 'lnkLocations')); 		?></li>
			<li><?php echo anchor('app/action/positions/view', 		'Positions', 			array('id' => 'lnkPositions')); 		?></li>
			<li><?php echo anchor('app/action/people/view',			'People',				array('id' => 'lnkPeople'));			?></li>
		</ul>
	</div>
	<div class="panel">
		<h1 class="blue-gradient">Configuration</h1>
		<ul>
			<li><?php echo anchor('app/action/users/view', 'Users', array('id' => 'lnkUsers')); ?></li>			
		</ul>
	</div>
	<div class="panel">
		<h1 class="blue-gradient">Utilities</h1>
		<ul>
			<li><a href="<?php echo base_url().'/wiki'; ?>" target="_blank">Documentation</a></li>
			<li><?php echo anchor('app/action/analyze/view', 'SQL Analyzer', array('id' => 'lnkAnalyze')); 	?></li>
			<li><?php echo anchor('app/action/config/view', 'Import Data', array('id' => 'lnkImport'));	?></li>
			<li><?php echo anchor('app/action/config/view', 'Export Data', array('id' => 'lnkExport'));	?></li>
		</ul>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
		$(".panel").collapse({
			head: 'h1',
			show: function(){
				this.animate({ opacity: 'toggle', height: 'toggle' }, 300);
			},
			hide: function(){
				this.animate({ opacity: 'toggle', height: 'toggle' }, 300);
			}
		});
		
		$('#navleft ul li a').hover(
			function() {
				$(this).addClass('grey2-gradient');
			},
			function() {
				$(this).removeClass('grey2-gradient');
			}
		);
    });
</script>