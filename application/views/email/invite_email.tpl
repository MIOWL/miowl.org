    <p>{toName},<br />
        Your have been invited to join the owl "{owl_name}" by {fromName}.
    </p>
    <p>
    	Below is the message from {fromName}:<br />
    	<code>{msg}</code>
	</p>
    <p>
        If you would like to request membership to this owl please follow this link <a href="<?php print site_url('user/register'); ?>/{owl_id}" title="MiOwl Registration" target="_BLANK"><?php print site_url('user/register'); ?>/{owl_id}</a>
    </p>
    <br />
    <br />
    <p>
        <strong>If you believe you have been sent this email by mistake, please ignore it. If you believe this to be SPAM please report here:</strong><br />
        <code><a href="mailto:support@miowl.org" title="MiOwl Support">support@miowl.org</a></code>
    </p>
