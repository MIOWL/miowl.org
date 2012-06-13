<?php $meh =& get_instance(); ?>
<?php $meh->load->view('template/header'); ?>

	<h1>
		<center>
			<?php echo $heading; ?>
		</center>
	</h1>

	<div id="body">
			<div class="notification error">
			        <p><strong>Error:</strong> </p><pre><?php echo $message; ?></pre>
			<p></p>
			</div>
		</center>
	</div>

  <div class="clear">&nbsp;</div>
	<p class="footer">&nbsp;</p>
</div>

</body>
</html>