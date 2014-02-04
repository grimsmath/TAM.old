<div id="password_dialog" class="x-hidden">
	<div class="dialog-form-container">
		<div id="dialog_message" class="message"></div>
		<?php echo form_open('#', array('id' => 'password-form', 'name' => 'password-form')); ?>
			<fieldset>
				<div class="row">
					<input type="hidden" name="id-hidden" id="id-hidden" />
				</div>
				<div class="row">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" class="uniform" />
				</div>
				<div class="row">
					<label for="password_confirm">Confirm:</label>
					<input type="password" id="password_confirm" name="password_confirm" class="uniform" />
				</div>
			</fieldset>
		</form>
	</div>	
</div>