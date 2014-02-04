<h1 class="blue-gradient">Position Form</h1>

<?php 
	$data['saveApi'] = '/api/position';
	$data['backURL'] = site_url().'/app/action/positions/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Position Details</legend>
			<input type="hidden" id="id" name="id" />
			
			<div class="row">
				<label for="position_name">Name:</label>
				<input type="text" id="position_name" name="position_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="position_number">Position Number:</label>
				<input type="text" id="position_number" name="position_number" class="uniform" />
			</div>
			
			<div class="row">
				<label for="position_person_id">User ID:</label>
				<select id="position_person_id" name="position_person_id" class="uniform"></select>
			</div>

			<div class="row">
				<label for="position_currency">Currency Eligible:</label>
				<select id="position_currency" name="position_currency" class="uniform">
					<option value>Please Select ...</option>
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'position')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#error',
			wrapper: "li",
			rules: {
				position_name: "required",
				position_number: "required",
				position_currency: "required"
			}, // end rules:
			messages: {
				position_name: "Please specify the position name.",
				position_number: "Please specify the position number.",
				position_currency: "Please specify the currency eligibility."
			} // end messages:
		}); // end validate()
		
		// Set the focus
		$('#position_name').focus();

		// Form load
		var url = $.url();
		if (url.attr('source').indexOf('edit') > -1) {
			$.ajax({
				type: 'POST',
				url: CI.site_url + "<?php echo $data['saveApi']; ?>",
				data: { id: url.segment(url.segment().length) },
				dataType: 'json',
				success: function(data) {
					// Populate the form values
					$('#id').val(data.id);
					$('#position_name').val(data.position_name);
					$('#position_number').val(data.position_number);
					$('#position_currency').val(data.position_currency);
					$.uniform.update('#position_currency');
					
					TAM.loadSelect($('#position_person_id'), 'getPeopleOptions', data.position_person_id);
				} // end success:
			}); // end $.ajax
		} else {
			TAM.loadSelect($('#position_person_id'), 'getPeopleOptions', 0);
		} // end if
	});
</script>