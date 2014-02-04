<h1 class="blue-gradient">Operating System</h1>

<?php 
	$data['saveApi'] = '/api/operatingsystem';
	$data['backURL'] = site_url().'/app/action/opersys/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Operating System Details</legend>
			<input type="hidden" id="id" name="id" />
			
			<div class="row">
				<label for="os_name">Name:</label>
				<input type="text" id="os_name" name="os_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="os_mfg_id">Manufacturer:</label>
				<select id="os_mfg_id" name="os_mfg_id" class="uniform"></select>
				<a href="#" id="lnkNewMfg" class="link-new">New Manufacturer</a>
			</div>
			
			<div class="row">
				<label for="os_notes">Notes:</label>
				<textarea id="os_notes" name="os_notes" cols="50" rows="10" class="uniform"></textarea>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'operatingsystem')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#error',
			wrapper: "li",
			rules: {
				os_name: "required"
			}, // end rules:
			messages: {
				os_name: "Please specify the operating system name."
			} // end messages:
		}); // end validate()
		
		// Set the focus
		$('#os_name').focus();

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
					$('#os_name').val(data.os_name);
					$('#os_notes').val(data.os_notes);
					
					TAM.loadSelect($('#os_mfg_id'), 'manufactureroptions', 'GET', data.os_mfg_id);
				} // end success:
			}); // end $.ajax
		} else {
			TAM.loadSelect($('#os_mfg_id'), 'manufactureroptions', 'GET', 0);
		} // end if
	});
</script>