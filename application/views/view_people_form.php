<h1 class="blue-gradient">Person Form</h1>

<?php 
	$data['saveApi'] = '/api/person';
	$data['backURL'] = site_url().'/app/action/people/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Person Details</legend>
			<input type="hidden" id="id" name="id" />

			<div class="row">
				<label for="person_username">Username:</label>
				<input type="text" id="person_username" name="person_username" class="uniform" />
			</div>
			
			<div class="row">
				<label for="person_f_name">First Name:</label>
				<input type="text" id="person_f_name" name="person_f_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="person_l_name">Last Name:</label>
				<input type="text" id="person_l_name" name="person_l_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="person_email">Email:</label>
				<input type="text" id="person_email" name="person_email" class="uniform" />
			</div>
			
			<div class="row">
				<label for="person_extension">Extension:</label>
				<input type="text" id="person_extension" name="person_extension" class="uniform" />
			</div>
			
			<div class="row">
				<label for="person_loc_id">Location:</label>
				<select id="person_loc_id" name="person_loc_id" class="uniform"></select>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'person')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#message',
			wrapper: "li",
			rules: {
				person_username: "required",
				person_f_name: "required",
				person_l_name: "required",
				person_loc_id: "required"
			}, // end rules:
			messages: {
				person_username: "Please specify the person's username.",
				person_f_name: "Please specify the person's first name.",
				person_l_name: "Please specify the person's last name.",
				person_loc_id: "Please select the person's location."
			}, // end messages:
		});

		// Set the focus
		$('#person_username').focus();
		
		// Form load
		var url = $.url();
		if (url.attr('source').indexOf('edit') > -1) {
			$.ajax({
				type: 'GET',
				url: CI.site_url + "<?php echo $data['saveApi']; ?>",
				data: { id: url.segment(url.segment().length) },
				dataType: 'json',
				success: function(data) {
					// Populate the form values
					$('#id').val(data.id);
					$('#person_username').val(data.person_username);
					$('#person_f_name').val(data.person_f_name);
					$('#person_l_name').val(data.person_l_name);
					$('#person_email').val(data.person_email);
					$('#person_extension').val(data.person_extension);
					
					TAM.loadSelect($('#person_loc_id'), 'locationoptions', 'GET', data.person_loc_id);
				} // end success:
			}); // end $.ajax
		} else {
			TAM.loadSelect($('#person_loc_id'), 'locationoptions', 'GET', 0);
		} // end if
	}); // end ready()
</script>