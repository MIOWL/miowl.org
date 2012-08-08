    <p>{username},<br />
        Thank you for registering with us here at miowl.org. In order to better serve you we need to verify your email address.
    </p>
    <p>
        Someone, hopefully you, has registered an account with us supplying this email to be validated. To do this you can use the link below, or if that does not work direct your web browser to <a href="<?php print site_url('user/validate'); ?>/{authcode}" title="MI OWL User Validation" target="_BLANK"><?php print site_url('user/validate/'); ?></a> and enter the authorization code below.
    </p>
    <p>
        <strong>Authorization Code: </strong><code>{authcode}</code>
    </p>
