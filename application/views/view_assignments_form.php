<h1 class="blue-gradient">Assignment Form</h1>

<?php 
	$data['saveApi'] = '/api/assignment';
	$data['backURL'] = site_url().'/app/action/assignments/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>	
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Asset Assignment Details</legend>
			<div class="row">
				<label for="assignment_decal_id">Asset Decal:</label>
				<select id="assignment_decal_id" name="assignment_decal_id" class="uniform"></select>
			</div>
			
			<div class="row">
				<label for="assignment_person_id">Person:</label>
				<select id="assignment_person_id" name="assignment_person_id" class="uniform"></select>
			</div>
			
			<div class="row">
				<label for="assignment_position_id">Position:</label>
				<select id="assignment_position_id" name="assignment_position_id" class="uniform"></select>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'assignment')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#error',
			wrapper: "li",
			rules: {
				assignment_decal_id: "assignment_decal_id",
				assignment_person_id: "assignment_person_id",
				assignment_position_id: "assignment_position_id",
			}, // end rules
			messages: {
				assignment_decal_id: "Please choose a decal number.",
				assignment_person_id: "Please choose a person.",
				assignment_position_id: "Please choose a position."
			} // end message
		}); // end validate
	
		// Form load
		var url = $.url();
		if (url.attr('source').indexOf('edit') > -1)
		{
			$.ajax({
				type: 'GET',
				url: CI.site_url + "<?php echo $data['saveApi']; ?>",
				data: { id: url.segment(url.segment().length) },
				dataType: 'json',
				success: function(data) {
					// Populate the form values
					$('#id').val(data.id);
					$('#asset_decal_id').val(data.asset_decal_id);
					$('#assignment_person_id').val(data.assignment_person_id);
					$('#assignment_position_id').val(data.assignment_position_id);

					TAM.loadSelect($('#assignment_decal_id'), 		'assetoptions', 	'GET', data.asset_decal_id);
					TAM.loadSelect($('#assignment_person_id'), 		'peopleoptions', 	'GET', data.assignment_person_id);
					TAM.loadSelect($('#assignment_position_id'), 	'positionoptions', 	'GET', data.assignment_position_id);
				} // end success
			}); // end ajax
		} else {
			TAM.loadSelect($('#assignment_decal_id'), 		'assetoptions', 	'GET', 0);
			TAM.loadSelect($('#assignment_person_id'), 		'peopleoptions', 	'GET', 0);
			TAM.loadSelect($('#assignment_position_id'), 	'positionoptions', 	'GET', 0);
		} // endif
	}); // end $(document)
</script>