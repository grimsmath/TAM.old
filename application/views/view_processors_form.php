<h1 class="blue-gradient">Processor</h1>

<?php 
	$data['saveApi'] = '/api/processor';
	$data['backURL'] = site_url().'/app/action/processors/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Processor Details</legend>
			<input type="hidden" id="id" name="id" />
			
			<div class="row">
				<label for="cpu_name">Name:</label>
				<input type="text" id="cpu_name" name="cpu_name" class="uniform" />
			</div>
			
			<div class="row">
				<label for="cpu_mfg_id">Manufacturer:</label>
				<input type="hidden" id="cpu_mfg_id_save" name="cpu_mfg_id_save" />
				<select id="cpu_mfg_id" name="cpu_mfg_id" class="uniform"></select>
				<a href="#" id="lnkNewMfg" class="link-new">New Manufacturer</a>
			</div>
			
			<div class="row">
				<label for="cpu_notes">Notes:</label>
				<textarea id="cpu_notes" name="cpu_notes" cols="50" rows="10" class="uniform"></textarea>
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'processor')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#error',
			wrapper: "li",
			rules: {
				cpu_name: "required",
				cpu_mfg_id: "required"
			}, // end rules:
			messages: {
				cpu_name: "Please specify the processor name.",
				cpu_mfg_id: "Please specify the manufacturer."
			} // end messages:
		}); // end validate()

		// Set the focus
		$('#cpu_name').focus();

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
					$('#cpu_name').val(data.cpu_name);
					$('#cpu_notes').val(data.cpu_notes);
					$('#cpu_mfg_id_save').val(data.cpu_mfg_id);
					
					TAM.loadSelect($('#cpu_mfg_id'), 'manufactureroptions', 'GET', data.cpu_mfg_id);
				} // end success:
			}); // end $.ajax
		} else {
			TAM.loadSelect($('#cpu_mfg_id'), 'manufactureroptions', 'GET', 0);
		} // end if
	}); // end ready()
</script>