    <p>{username},<br />
        30 days ago you registered with us here at miowl.org. To start using this site you first need to activate it using the information below.
    </p>
    <p>
    	<strong>NOTE:</strong> If you do not activate this account within 30 days from today then we will delete the account.
    </p>
    <p>
        Someone, <i>hopefully you</i>, has registered with us supplying this email. To do this you can use the link below, or if that does not work direct your web browser to <a href="<?php print site_url('user/validate'); ?>/{authcode}" title="MiOWL User Validation" target="_BLANK"><?php print site_url('user/validate'); ?></a> and enter the authorization code below.
    </p>
    <p>
        <strong>Activation Code: </strong><code>{authcode}</code>
    </p>
