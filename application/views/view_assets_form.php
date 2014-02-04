<h1 class="blue-gradient">Asset</h1>

<?php 
	$data['saveApi'] = '/api/asset';
	$data['backURL'] = site_url().'/app/action/assets/view';
	
	$this->load->view('partials/commands_form', $data); 
?>

<div class="form-container">
	<div id="message"></div>	
	<?php echo form_open('#', array('id' => 'input-form', 'name' => 'input-form')); ?>
		<fieldset>
			<legend>Asset Identification</legend>
			<input type="hidden" id="id" name="id" class="uniform" />
			
			<div class="row">
				<label for="asset_decal">Decal #:</label>
				<input type="text" id="asset_decal" name="asset_decal" class="uniform" />
			</div>
			
			<div class="row">
				<label for="asset_serial">Serial #:</label>
				<input type="text" id="asset_serial" name="asset_serial"  class="uniform"/>
			</div>

			<div class="row">
				<label for="asset_mac_addr">MAC Address:</label>
				<input type="text" id="asset_mac_addr" name="asset_mac_addr" class="uniform" />
			</div>

			<div class="row">
				<label for="asset_wifi_mac_addr">WiFi MAC Address:</label>
				<input type="text" id="asset_wifi_mac_addr" name="asset_wifi_mac_addr" class="uniform" />
			</div>

			<div class="row">
				<label for="asset_purchase_date">Purchase Date:</label>
				<input type="text" id="asset_purchase_date" name="asset_purchase_date" class="uniform" />
			</div>

			<div class="row">
				<label for="asset_warranty_begin">Warranty Begins:</label>
				<input type="text" id="asset_warranty_begin" name="asset_warranty_begin" class="uniform" />
			</div>

			<div class="row">
				<label for="asset_warranty_end">Warranty Ends:</label>
				<input type="text" id="asset_warranty_end" name="asset_warranty_end" class="uniform" />
			</div>

			<div class="row">
				<label for="asset_loc_id">Location:</label>
				<select id="asset_loc_id" name="asset_loc_id" class="uniform">
					<option>Please select ...</option>
				</select>
			</div>
			
			<div class="row">
				<label for="asset_status_id">Asset Status:</label>
				<select id="asset_status_id" name="asset_status_id" class="uniform">
					<option>Please select ...</option>
				</select>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>Asset Model &amp; Type</legend>
			<div class="row">
				<label for="asset_model_id">Model Type:</label>
				<select id="asset_model_id" name="asset_model_id" class="uniform">
					<option>Please select ...</option>
				</select>
			</div>

			<div class="row">
				<label for="asset_cpu_id">Processor:</label>
				<select id="asset_cpu_id" name="asset_cpu_id" class="uniform">
					<option>Please select ...</option>
				</select>
			</div>

			<div class="row">
				<label for="asset_ram">RAM (GB):</label>
				<input type="text" id="asset_ram" name="asset_ram" class="uniform" />
			</div>
		</fieldset>

		<fieldset>
			<legend>Survey Details</legend>
			<div class="row">
				<label for="asset_survey_number">Survey Number:</label>
				<input type="text" id="asset_survey_number" name="asset_survey_number" class="uniform" />
			</div>
			<div class="row">
				<label for="asset_survey_date">Survey Date:</label>
				<input type="text" id="asset_survey_date" name="asset_survey_date" class="uniform" />
			</div>
		</fieldset>
	</form>
</div>

<?php $this->load->view('dialogs/comments', array('object' => 'asset')); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#input-form').validate({
			errorLabelContainer: '#message',
			wrapper: "li",
			rules: {
				asset_decal: "required",
				asset_serial: "required"
			}, // end rules
			messages: {
				asset_decal: "Please specify the decal number.",
				asset_serial: "Please specify the serial number."
			} // end message
		}); // end input-form.validate
		
		// Load up the date pickers/masked edits/etc
		$("#asset_purchase_date").datepicker();
		$("#asset_warranty_begin").datepicker();
		$("#asset_warranty_end").datepicker();
		$("#asset_survey_date").datepicker();
		$("#asset_mac_addr").mask("**:**:**:**:**:**");
		$("#asset_wifi_mac_addr").mask("**:**:**:**:**:**");
		
		// Set the focus
		$('#asset_decal').focus();
		
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
					$('#asset_decal').val(data.asset_decal);
					$('#asset_serial').val(data.asset_serial);
					$('#asset_mac_addr').val(data.asset_mac_addr);
					$('#asset_wifi_mac_addr').val(data.asset_wifi_mac_addr);
					$('#asset_purchase_date').val(data.asset_purchase_date);
					$('#asset_warranty_begin').val(data.asset_warranty_begin);
					$('#asset_warranty_end').val(data.asset_warranty_end);
					$('#asset_ram').val(data.asset_ram);
					$('#asset_loc_id').val(data.asset_loc_id);
					$('#asset_survey_date').val(data.asset_survey_date);
					$('#asset_survey_number').val(data.asset_survey_number);

					TAM.loadSelect($('#asset_loc_id'), 		'locationoptions', 		'GET', data.asset_loc_id);
					TAM.loadSelect($('#asset_model_id'), 	'modeloptions', 		'GET', data.asset_loc_id);
					TAM.loadSelect($('#asset_cpu_id'), 		'processoroptions', 	'GET', data.asset_cpu_id);
					TAM.loadSelect($('#asset_status_id'), 	'statusoptions', 		'GET', data.asset_status_id);
				} // end success
			}); // end ajax
		} else {
			TAM.loadSelect($('#asset_loc_id'), 		'locationoptions', 	'GET', 0);
			TAM.loadSelect($('#asset_model_id'), 	'modeloptions', 		'GET', 0);
			TAM.loadSelect($('#asset_cpu_id'), 		'processoroptions', 	'GET', 0);
			TAM.loadSelect($('#asset_status_id'), 	'statusoptions', 		'GET', 0);
		} // endif
	}); // end $(document)
</script>