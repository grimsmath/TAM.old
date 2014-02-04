<h1 class="blue-gradient">Model Details</h1>

<?php 
	$data['saveApi'] = '/api/model';
	$data['backURL'] = site_url().'/app/action/models/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Model Identification</legend>
			<input type="hidden" id="id" name="id" />
			
			<div class="row">
				<label for="model_name">Name:</label>
				<input type="text" id="model_name" name="model_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="model_mfg_id">Manufacturer:</label>
				<input type="hidden" id="model_mfg_id_save" name="model_mfg_id_save" />
				<select id="model_mfg_id" name="model_mfg_id" class="uniform"></select>
				<a href="#" id="lnkNewMfg" class="link-new">New Manufacturer</a>
			</div>
			
			<div class="row">
				<label for="model_notes">Notes:</label>
				<textarea id="model_notes" name="model_notes" cols="30" rows="10" class="uniform"></textarea>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'model')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#error',
			wrapper: "li",
			rules: {
				model_name: "required"
			}, // end rules:
			messages: {
				model_name: "Please specify the model name."
			} // end messages:
		}); // end validate()

		// Set the focus	
		$('#model_name').focus();

		// Form load
		var url = $.url();
		if (url.attr('source').indexOf('edit') > -1)
		{
			$.ajax({
				type: 'GET',
				url: CI.site_url + "<?php echo $data['saveApi']; ?>",
				data: { id: url.segment(url.segment().length)  },
				dataType: 'json',
				success: function(data) {
					// Populate the form values
					$('#id').val(data.id);
					$('#model_name').val(data.model_name);
					$('#model_notes').val(data.model_notes);
					$('#model_mfg_id_save').val(data.model_mfg_id);
					
					TAM.loadSelect($('#model_mfg_id'), 'manufactureroptions', 'GET', data.model_mfg_id);
				} // end success:
			}); // end $.ajax
		} else {
			TAM.loadSelect($('#model_mfg_id'), 'manufactureroptions', 'GET', 0);
		} // end if
	}); // end ready()
</script>