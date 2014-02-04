<div id="masthead" class="blue-gradient clearfix">
	<div class="container_12">
		<div id="logo-container" class="grid_2">
			<div id="logo"></div>
		</div>
		<div id="banner" class="grid_7">
			<h1>Tiny Asset Manager (TAM)</h1>
		</div>
		<div id="tools" class="grid_3">
			<h2>TAM User Tools</h2>
			<ul>
				<li>Logged in as: 
					<?php 
						echo anchor('#', $this->session->userdata('username'), array('id' => 'lnkUsername'));
						echo ' ('.anchor('login/logout', 'logout').')'; 
					?>
				</li>
			</ul>
		</div>
	</div>
</div>