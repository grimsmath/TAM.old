<input type="hidden" id="saveApi" name="saveApi" value="<?php echo $saveApi; ?>" />
<input type="hidden" id="backURL" name="backURL" value="<?php echo $backURL; ?>" />

<div class="command-bar">
	<ul>
		<li><a href="#" id="lnkSave">Save</a></li>
		<li><a href="#" id="lnkCancel">Cancel</a></li>
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
		// Handle the Save button
		$('#lnkSave').click(function() {
			// Get the full API url
			var url = CI.site_url + $('#saveApi').val();
			
			// Save the data using the TAM object
			TAM.saveData(url, $('#input-form'), $('#message'));

			// Change the cancel button's text
			$('#lnkCancel').html('Close');	
		}); // end lnkSave.click()
		
		$('#lnkCancel').click(function () {
			location.href = $('#backURL').val();
		}); // end lnkCancel.click()

		$('#lnkViewComments').click(function() {
			TAM.showComments($('#comments-dialog'));
		});

		$('#lnkHistory').click(function() {
			TAM.showHistory($('#history-dialog'));
		});

		$('#lnkComment').click(function() {
			TAM.addComment($('#comment-dialog'));
		}) // end lnkComment.click()
		
		// Handle the change password
		$('#lnkPassword').click(function () {
			TAM.showPasswordSetDialog($('#password_dialog'), 
									  $('#password'), 
									  $('#password_confirm'), 
									  $('#message'));
		});
	});	
</script>