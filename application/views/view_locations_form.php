<h1 class="blue-gradient">Location Form</h1>

<?php 
	$data['saveApi'] = '/api/location';
	$data['backURL'] = site_url().'/app/action/locations/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Location Details</legend>
			<input type="hidden" id="id" name="id" />

			<div class="row">
				<label for="loc_name">Name:</label>
				<input type="text" id="loc_name" name="loc_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="loc_building">Building:</label>
				<input type="text" id="loc_building" name="loc_building" class="uniform"/>
			</div>
			
			<div class="row">
				<label for="loc_floor">Floor:</label>
				<input type="text" id="loc_floor" name="loc_floor" class="uniform" />
			</div>

			<div class="row">
				<label for="loc_room">Room #:</label>
				<input type="text" id="loc_room" name="loc_room" class="uniform" />
			</div>
			
			<div class="row">
				<label for="loc_type_id">Location Type:</label>
				<input type="hidden" id="loc_type_id_save" name="loc_type_id_save" />
				<select id="loc_type_id" name="loc_type_id" class="uniform"></select>
				<a href="#" id="lnkNewMfg" class="link-new">New Location Type</a>
			</div>

			<div class="row">
				<label for="loc_notes">Notes:</label>
				<textarea id="loc_notes" name="loc_notes" cols="50" rows="10" class="uniform"></textarea>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'location')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#error',
			wrapper: "li",
			rules: {
				loc_name: "required",
				loc_type_id: "required"
			}, // end rules:
			messages: {
				loc_name: "Please specify the location name.",
				loc_type_id: "Please specify the location type."
			} // end messages:
		}); // end validate()

		// Set the focus
		$('#loc_name').focus();
		
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
					$('#loc_name').val(data.loc_name);
					$('#loc_building').val(data.loc_building);
					$('#loc_floor').val(data.loc_floor);
					$('#loc_room').val(data.loc_room);
					$('#loc_notes').val(data.loc_notes);
					$('#loc_type_id_save').val(data.loc_type_id);

					TAM.loadSelect($('#loc_type_id'), 'locationtypeoptions', 'GET', data.loc_type_id);
				} // end success:
			}); // end $.ajax
		} else {
			TAM.loadSelect($('#loc_type_id'), 'locationtypeoptions', 'GET', 0);
		} // end if
	});
</script>