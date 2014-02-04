<input type="hidden" id="apiNew" name="apiNew" value="<?php echo $apiNew; ?>" />
<input type="hidden" id="apiEdit" name="apiEdit" value="<?php echo $apiEdit; ?>" />
<textarea id="apiDelete" name="apiDelete" class="x-hidden">
	<?php echo $apiDelete; ?>
</textarea>

<div class="command-bar">
	<ul>
		<li><a href="#" id="lnkNew">New</a></li>
		<li><a href="#" id="lnkEdit">Edit</a></li>
		<li><a href="#" id="lnkDelete">Delete</a></li>
		<?php if (isset($isPasswordForm) && $isPasswordForm == true): ?>
			<li><a href="#" id="lnkPassword">Set Password</a></li>
		<?php endif; ?>
		<li><a href="#" id="lnkHistory">View History</a></li>
		<li><a href="#" id="lnkComment" class="comment-button">Add Comment</a></li>
		<li><a href="#" id="lnkViewComments" class="comment-button">View Comments</a></li>
	<ul>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		// Form load
		var isUserForm = $('#isUserForm').val();
		if (isUserForm == "true") {
			$('#lnkPassword').removeClass('x-hidden');
		}

		// New button handler
		$('#lnkNew').click(function() {
			location.href = CI.site_url + $('#apiNew').val();
		});
		
		// Edit button handler
		$('#lnkEdit').click(function() {
			TAM.editData($('#apiEdit').val());
		});
		
		// Delete button44 handler
		$('#lnkDelete').click(function() {
			var apiDelete	= $.parseJSON($('#apiDelete').val());
			var selected 	= TAM.getSelectedRows();
			
			// Perform the delete
			TAM.deleteData(apiDelete.object, 
						   apiDelete.api, 
						   selected[0][0], 
						   apiDelete.returnApi, 
						   $('#message'));
		});
		
		// Comment button handler
		$('#lnkComment').click(function() {
			TAM.addComment($('#comment-dialog'), $('#message'));			
		});
		
		$('#lnkViewComments').click(function() {
			TAM.showComments($('#comments-dialog'));
		});

		$('#lnkHistory').click(function() {
			TAM.showHistory($('#history-dialog'));	
		});
		
		// Set password button handler
		$('a#lnkPassword').click(function () {
			// The user needs to select something from the table
			var selected = TAM.getSelectedRows();
			if (selected) {
				// User slected something, save the value
				$('#id-hidden').val(selected[0][0]);
				
				// Show the dialog
				TAM.showPasswordSetDialog($('#password_dialog'), 
										  $('#password'), 
										  $('#password_confirm'), 
										  $('#message'));
			} else {
				// User didn't select anything
				alert("Please select an entry");
			}
		});		
	});
</script>
