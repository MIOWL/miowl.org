    <p>
        {username},<br />
        Someone, <i>hopefully you</i>, has requested an account password reset. To do this you can use the link below, or if that does not work direct your web browser to <a href="<?php print base_url('user/forgot_validate'); ?>/{authcode}" title="PixlDrop password reset form" target="_BLANK"><?php print base_url('user/forgot/'); ?></a> and enter the authorization code below.
    </p>
    <br />
    <p>
        The request has come from the following IP address: <i><b><a href="http://whatismyipaddress.com/ip/{ip}" title="IP lookup">{ip}</a></b></i>.<br />
        If you did not request this password reset, please ignore this email.
    </p>
    <br />
    <br />
    <p>
        <strong>Authorization Code: </strong>{authcode}
    </p>
