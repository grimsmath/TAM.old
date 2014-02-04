<div id="comment-dialog" class="x-hidden">
	<div class="dialog-form-container">
		<?php echo form_open('#', array('id' => 'comment-form')); ?>
			<fieldset>
				<div class="row">
					<input type="hidden" name="id-hidden" id="id-hidden" />
					<input type="hidden" name="objectType" id="objectType" value="<?php echo $object; ?>" />
				</div>
				<div class="row">
					<label for="comment_title">Title:</label>
					<input type="text" id="comment_title" name="comment_title" class="uniform" />
				</div>
				<div class="row">
					<label for="comment_text">Comment:</label>
					<textarea id="comment_text" name="comment_text" rows="5" cols="80" class="uniform"></textarea>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<div id="comments-dialog" class="x-hidden">
	<textarea id="comments" name="comments" rows="10" cols="60"></textarea>
</div>

<div id="history-dialog" class="x-hidden">
	<textarea id="history" name="history" rows="10" cols="60"></textarea>
</div>
