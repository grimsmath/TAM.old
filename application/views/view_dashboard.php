<h1 class="blue-gradient">TAM Dashboard</h1>
<table id="dashboard-table">
	<tr>
		<td class="label">Database Path</td>
		<td class="value">
			<p id="db_path">
				<?php echo $this->db->database; ?>
			</p>
		</td>
		<td class="label">Database Size</td>
		<td class="value">
			<p id="db_size">
				<?php echo number_format(filesize($this->db->database)).' bytes'; ?>
			</p>
		</td>
	</tr>
	<tr>
		<td class="label">Last Updated</td>
		<td class="value">
			<p id="last_updated">
				<?php 
					echo date("F d, Y H:i:s", filemtime($this->db->database));
				?>
			</p>
		</td>
		<td class="label">Last User</td>
		<td class="value"><p id="last_user" /></td>		
	</tr>
	<tr>
		<td class="label">Database Driver</td>
		<td class="value">
			<p id="db_driver">
				<?php echo $this->db->dbdriver; ?>
			</p>
		</td>
		<td class="label">Driver Version</td>
		<td class="value"><p id="db_driver_ver" /></td>		
	</tr>		
</table>

<h1 class="blue-gradient">TAM Database Statistics</h1>
<table id="dashboard-table">
	<tr>
		<td class="label">Total Assets</td>
		<td class="value"><p id="num_assets" /></td>
		<td class="label">Total Assignments</td>
		<td class="value"><p id="num_assignments" /></td>
	</tr>
	<tr>
		<td class="label">Total People</td>
		<td class="value"><p id="num_people" /></td>
		<td class="label">Total Positions</td>
		<td class="value"><p id="num_positions" /></td>		
	</tr>
	<tr>
		<td class="label">Total Models</td>
		<td class="value"><p id="num_models" /></td>
		<td class="label">Total Manufacturers</td>
		<td class="value"><p id="num_mfg" /></td>
	</td>
	<tr>
		<td class="label">Total Operating Systems</td>
		<td class="value"><p id="num_os" /></td>			
		<td class="label">Total Processors</td>
		<td class="value"><p id="num_processors" /></td>
	</tr>		
</table>

<script type="text/javascript">
	$(document).ready(function() {
		$.ajax({
			type: 'GET',
			url: CI.site_url + '/api/statistics',
			dataType: 'json',
			success: function(data) {
				// Populate the page
				$('#num_assets').text(data.num_assets);
				$('#num_assignments').text(data.num_assignments);
				$('#num_people').text(data.num_people);
				$('#num_positions').text(data.num_positions);
				$('#num_models').text(data.num_models);
				$('#num_mfg').text(data.num_mfg);
				$('#num_os').text(data.num_os);
				$('#num_processors').text(data.num_processors);
				$('#db_driver_ver').text(data.sqlite_version);
			}
		});
	});
</script>