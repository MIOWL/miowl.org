	<div id="nav">
		<?php

		if ($this->session->userdata('authed'))
		{
			# Logged in NAV
			print "<a href='". site_url('user/logout') . "' title='Logout'>logout</a>";				# logout
			print " | ";																			# spacer
			print "<a href='". site_url('upload') . "' title='Upload a new file'>upload</a>";		# upload
		}
		else
		{
			# Default NAV
			print "<a href='". site_url('user/login') . "' title='Login'>login</a>"; 				# login
		}

		# These are non specific nav options
		print " | ";																				# spacer
		print "<a href='". site_url('browse') . "' title='Browse all the files'>browse</a>";		# browse
		print " | ";																				# spacer
		print "<a href='". site_url('search') . "' title='Search for a file'>search</a>";			# search
		print " | ";																				# spacer
		print "<a href='". site_url('about') . "' title='About the site'>about</a>";				# about

		?>
	</div>
