	<div id="nav">
	<?php if ($this->session->userdata('authed')) : ?>
			Welcome Back <?php print $this->session->userdata('name'); ?> (<a href='<?php print site_url('user/logout'); ?>' title='Logout'>logout</a>)
	<?php else : ?>
			Welcome Guest (<a href='<?php print site_url('user/login'); ?>' title='Login'>login</a> | <a href='<?php print site_url('user/register'); ?>' title='Register a new account'>register</a>)
	<?php endif; ?>
	<br />
	<?php
		if ($this->session->userdata('authed'))
		{
			# Logged in NAV
			print "<a href='". site_url() . "' title='View your Owl'>my owl</a>";								# my owl
			print " | ";																						# spacer
			print "<a href='". site_url('upload') . "' title='Upload a new file'>upload</a>";					# upload
			print " | ";																						# spacer
		}

		# These are non specific nav options
		print "<a href='". site_url('owls') . "' title='Browse all the Owl\'s on the site'>owl's</a>";			# owls
		print " | ";																							# spacer
		print "<a href='". site_url('site search') . "' title='Search for a file'>search</a>";					# search
		print " | ";																							# spacer
		print "<a href='". site_url('about') . "' title='About the site'>about</a>";							# about
	?>
	</div>
