<?php 
	echo $this->load->view('partials/header');
	echo $this->load->view('partials/masthead');
?>

<div id="content-container">
	<div id="content" class="container_12 clearfix">
		<div class="grid_3">
			<?php echo $this->load->view('partials/navleft'); ?>
		</div>
		<div class="grid_9">
			<div id="content-frame">
				<?php echo $contents; ?>
			</div>
		</div>
	</div>
</div>

<?php
	echo $this->load->view('partials/footer');
?>