<?php print doctype('xhtml1-strict') . "\n"; ?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>

    <!-- Meta Information -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="distribution" content="global" />
    <meta name="robots" content="follow, all" />
    <meta name="language" content="en" />

    <!-- Title -->
    <title>MiOWL (Something else here!)</title>

    <!-- Icon -->
    <link rel="Shortcut Icon" href="<?php print site_url('favicon.ico'); ?>" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?php print site_url('style.css'); ?>" type="text/css" media="screen" charset="utf-8" />

    <!-- jQuery -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="<?php print site_url('/js/jquery.min.js'); ?>"><\/script>\n<script src="<?php print site_url('/js/jquery-ui.min.js'); ?>"><\/script>')
    </script>
    <script type="text/javascript" src="<?php print site_url('/js/uni-form.jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php print site_url('/js/tips.js'); ?>"></script>
    <script type="text/javascript" src="<?php print site_url('/js/jquery.countdown.js'); ?>"></script>

</head>
<body style="background:none repeat scroll 0 0 #F2F2F2;">

    <!-- message -->
    <div id="message-page">
        <div>
            <?php if (isset($success)) : ?><h3 class="success">Success!</h3><p><?php print $msg; ?></p>
            <?php elseif (isset($error)) : ?><h3 class="error">Error</h3><p><?php print $msg; ?></p>
            <?php else : ?><h3 class="info">Information</h3><p><?php print $msg; ?></p>
            <?php endif; ?>

            <p>Please hold as you will be redirected in <b id='textLayout'>3</b> seconds...</p>
        </div>

        <!-- redirect to $location -->
        <script type="text/javascript">
            setTimeout("location.href='<?php print site_url(); ?>';", 3000);
        </script>
    </div>
<script type="text/javascript">
$(function () {
    $('#textLayout').countdown({until: +3, layout: '{sn}'});
});
</script>
</body>
</html>
