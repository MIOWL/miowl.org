<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			404 Page Not Found!
		</center>
	</h1>

	<div id="body">
		<center>
			<h3>
				The page you requested was not found.
			</h3>
			<p>
				Maybe you should just <a href="<?php print site_url(); ?>">pop back home?</a>
			</p>
		</center>
	</div>

<?php $this->load->view('template/footer'); ?>
