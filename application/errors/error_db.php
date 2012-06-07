<?php $meh =& get_instance(); ?>
<?php $meh->load->view('template/header'); ?>

	<h1>
		<center>
			<?php echo $heading; ?>
		</center>
	</h1>

	<div id="body">
		<center>

			<div class="notification error" style="width: 400px ! important; text-align: left ! important;">
			        <p><strong>Error:</strong> </p><p><?php echo $message; ?></p>
			<p></p>
			</div>

			<p>
				Maybe you should just <a href="<?php print site_url(); ?>">pop back home?</a>
			</p>

		</center>
	</div>

<?php $meh->load->view('template/footer'); ?>
