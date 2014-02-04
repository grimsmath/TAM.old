<h1 class="blue-gradient">Manufacturer</h1>

<?php 
	$data['saveApi'] = '/api/manufacturer';
	$data['backURL'] = site_url().'/app/action/manufacturers/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Manufacturer Details</legend>
			<input type="hidden" id="id" name="id" />
			
			<div class="row">
				<label for="mfg_name">Name:</label>
				<input type="text" id="mfg_name" name="mfg_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="mfg_website">Website:</label>
				<input type="text" id="mfg_website" name="mfg_website" class="uniform" />
			</div>
			
			<div class="row">
				<label for="mfg_notes">Notes:</label>
				<textarea id="mfg_notes" name="mfg_notes" cols="50" rows="10" class="uniform"></textarea>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'manufacturer')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#error',
			wrapper: "li",
			rules: {
				mfg_name: "required"
			}, // end rules:
			messages: {
				mfg_name: "Please specify the manufacturer's name."
			} // end messages:
		}); // end validate()
		
		// Set the focus
		$('#mfg_name').focus();
									
		// Form load
		var url = $.url();
		$.ajax({
			type: 'GET',
			url: CI.site_url + "<?php echo $data['saveApi']; ?>",
			data: { id: url.segment(url.segment().length) },
			dataType: 'json',
			success: function(data) {
				// Populate the form values
				$('#id').val(data.id);
				$('#mfg_name').val(data.mfg_name);
				$('#mfg_website').val(data.mfg_website);
				$('#mfg_notes').val(data.mfg_notes);
			} // end success
		}); // end $.ajax
	}); // end ready()
</script>