<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

    <!-- Title -->
    <title><?php if(isset($page_title)) print $page_title . ' | ' ?>MiOWL (Something else here!)</title>

    <!-- Icon -->
    <link rel="Shortcut Icon" href="<?php print site_url('favicon.ico'); ?>" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?php print site_url('/style.css'); ?>" type="text/css" media="screen" charset="utf-8" />

<!-- jQuery -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script>
	window.jQuery || document.write('<script src="<?php print site_url('/js/jquery.min.js'); ?>"><\/script>\n<script src="<?php print site_url('/js/jquery-ui.min.js'); ?>"><\/script>')
</script>
<script type="text/javascript" src="<?php print site_url('/js/miowl.js'); ?>"></script>
<script type="text/javascript" src="<?php print site_url('/js/uni-form.jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php print site_url('/js/tips.js'); ?>"></script>
<script type="text/javascript" src="<?php print site_url('/js/jquery.countdown.js'); ?>"></script>
<?php if(isset($owl_selection) && $owl_selection) : ?><script type="text/javascript" src="<?php print site_url('/js/owl_selection.js'); ?>"></script><?php endif; ?>

<!-- Google Analytics -->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31288786-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>

<div id="container">

<?php $this->load->view('template/nav'); ?>

	<h1>
		<a href="<?php print site_url(); ?>" title="Go back home!">
			<img 
				src="<?php print site_url('images/miowl_red_black_small.png'); ?>"
				alt="MiOWL Logo"
				width="500"
				height="205"
			>
		</a>
	</h1>
