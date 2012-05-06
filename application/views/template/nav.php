	<div id="welcome_nav">
	<?php if ($this->session->userdata('authed')) : ?>
			Welcome Back <?php print $this->session->userdata('name'); ?> (<a href='<?php print site_url('user/logout'); ?>' title='Logout'>logout</a>)
	<?php else : ?>
			Welcome Guest (<a href='<?php print site_url('user/login'); ?>' title='Login'>login</a> | <a href='<?php print site_url('user/register'); ?>' title='Register a new account'>register</a>)
	<?php endif; ?>
	</div>
	<div id="nav">
	<?php
		if ($this->session->userdata('authed'))
		{
			# Logged in NAV
			print "<a href='". site_url('user/owl') . "' title='View your Owl'>my owl</a>";						# my owl
			print " | ";																						# spacer
			print "<a href='". site_url('upload') . "' title='Upload a new file'>upload</a>";					# upload
		}

		# These are non specific nav options
		print " | ";																							# spacer
		print "<a href='". site_url('browse') . "' title='Browse all the files'>browse</a>";					# browse
		print " | ";																							# spacer
		print "<a href='". site_url('search') . "' title='Search for a file'>search</a>";						# search
		print " | ";																							# spacer
		print "<a href='". site_url('about') . "' title='About the site'>about</a>";							# about
	?>
	</div>
