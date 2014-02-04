<h1 class="blue-gradient">TAM User</h1>

<?php 
	$data['saveApi'] 		= '/api/user';
	$data['backURL'] 		= site_url().'/app/action/users/view';
	$data['isPasswordForm'] = true;
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form')); ?>
		<fieldset>
			<legend>User Details</legend>
			<input type="hidden" id="id" name="id" />

			<div id="row" class="row">
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" class="uniform" />
			</div>
			
			<div class="row">
				<label for="first_name">First Name:</label>
				<input type="text" id="first_name" name="first_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="last_name">Last Name:</label>
				<input type="text" id="last_name" name="last_name" class="uniform" />
			</div>

			<div id="row" class="row">
				<label for="user_role_id">User Role:</label>
				<select id="user_role_id" name="user_role_id" class="uniform">
					<option>Please select ...</option>
				</select>
			</div>
			
			<div id="row" class="row">
				<label for="user_is_active">User Status:</label>
				<select id="user_is_active" name="user_is_active" class="uniform">
					<option value="" selected>Select status ...</option>
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/password'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#message',
			wrapper: "li",
			rules: {
				username: "required",
				first_name: "required",
				last_name: "required"
			}, // end rules:
			messages: {
				username: "Please specify the username.",
				first_name: "Please enter a first name for this user.",
				last_name: "Please enter a last name for this user."
			} // end messages:
		}); // end validate()
		
		// Set the focus
		$('#username').focus();

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
					$('#username').val(data.username);
					$('#first_name').val(data.first_name);
					$('#last_name').val(data.last_name);
					$('#user_is_active').val(data.user_is_active);
					$.uniform.update($('#user_is_active'));

					$('#id-hidden').val(data.id);
				
					TAM.loadSelect($('#user_role_id'), 'userroleoptions', 'GET', data.user_role_id);
				} // end success
			}); // end $.ajax
		} else {
			TAM.loadSelect($('#user_role_id'), 'userroleoptions', 'GET', 0);
		} // end if
	}); // end document.ready
</script>