	<div id="nav">
	<?php if ($this->session->userdata('authed')) : ?>
			Welcome Back <?php print $this->session->userdata('name'); ?> (<a href='<?php print site_url('user/logout'); ?>' title='Logout'>logout</a>)
	<?php else : ?>
			Welcome Guest (<a href='<?php print site_url('user/login'); ?>' title='Login'>login</a> | <a href='<?php print site_url('user/register'); ?>' title='Register a new account'>register</a>)
	<?php endif; ?>
	<br />
	<?php
		if ($this->session->userdata('authed') && is_verified())
		{
			# Logged in NAV
			print "<a href='". site_url() . "' title='View your OWL library'>my library</a>";					# my library
			print " | ";																						# spacer
			if (is_editor())
			{
				print "<a href='". site_url('owl/uploads/upload') . "' title='Upload a new file'>upload</a>";	# upload
				print " | ";																					# spacer
			}
		}

		# These are non specific nav options
		print "<a href='". site_url('owls') . "' title=\"Browse all the OWLs on the site\">OWLs</a>";			# owls
		print " | ";																							# spacer
		print "<a href='". site_url('search') . "' title='Search for a file'>site search</a>";					# search
		print " | ";																							# spacer
		print "<a href='". site_url('about') . "' title='About the site'>about</a>";							# about
	?>
	</div>
