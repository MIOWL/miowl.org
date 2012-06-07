<?php $meh =& get_instance(); ?>
<?php $meh->load->view('template/header'); ?>

	<h1>
		<center>
			404 Page Not Found
		</center>
	</h1>

	<div id="body">
		<center>

			<div class="notification error" style="width: 400px ! important; text-align: left ! important;">
			        <p><strong>Error:</strong> </p><p>The page you requested was not found.</p>
			<p></p>
			</div>

			<p>
				Maybe you should just <a href="<?php print site_url(); ?>">pop back home?</a>
			</p>

		</center>
	</div>

  <div class="clear">&nbsp;</div>
	<p class="footer">&nbsp;</p>
</div>

</body>
</html>