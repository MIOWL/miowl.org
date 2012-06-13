<?php $meh =& get_instance(); ?>
<?php $meh->load->view('template/header'); ?>

	<h1>
		<center>
			<?php echo $heading; ?>
		</center>
	</h1>

	<div id="body">
			<div class="notification error">
			        <p><strong>Error:</strong> </p><p><?php echo $message; ?></p>
			<p></p>
			</div>
		</center>
	</div>

  <div class="clear">&nbsp;</div>
	<p class="footer">&nbsp;</p>
</div>

</body>
</html>