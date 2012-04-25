	<div id="nav">
		<?php

		if ($this->session->userdata('authed'))
		{
			# Logged in NAV
			print "<a href='user/logout' title='Logout'>logout</a>";
		}
		else
		{
			# Default NAV
			print "<a href='user/login' title='Login'>login</a>";
		}

		?>
	</div>
