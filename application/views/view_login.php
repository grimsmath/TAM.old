<?php $this->load->view('partials/header'); ?>

<div id="login-wrapper" class="center-page grey3-gradient">
	<div id="login-header">
	</div>
	
	<div id="login-form-container" class="login-form">
		<?php echo form_open('login/authenticate', array('id' => 'login-form', 'name' => 'login-form')); ?>
			<div id="logo"></div>
			<fieldset id="login-fieldset">
				<legend>Tiny Asset Manager</legend>
				<div class="row">
					<label for="username">Username</label>
					<?php echo form_input(array('name' => 'username', 'id' => 'username', 'value' => '', 'class' => 'uniform')); ?>
				</div>
				
				<div class="row">
					<label for="password">Password</label>
					<?php echo form_password(array('name' => 'password', 'id' => 'password', 'value' => '', 'class' => 'uniform')); ?>
				</div>
				
				<div class="row">
					<label for="submit">&nbsp;</label>
					<?php
						echo form_button(array('name' 		=> 'help', 
											   'id' 		=> 'help', 
											   'content'	=> 'Help', 
											   'class'		=> 'login-button'));
											    
						echo form_submit(array('name' 		=> 'submit', 
											   'id' 		=> 'submit', 
											   'value'		=> 'Login', 
											   'class' 		=> 'login-button')); 
					?>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(window).resize(function(){
			TAM.centerDiv($('.center-page'));
		});
		
		// To initially run the function:
		$(window).resize();	
		
		// Set the focus on the first field
		$('#username').focus();
	});
</script>

<?php $this->load->view('partials/footer'); ?>