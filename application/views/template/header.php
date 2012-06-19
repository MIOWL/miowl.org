<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

    <!-- Title -->
    <title><?php if(isset($page_title)) print $page_title . ' | '; elseif (isset($heading))  print $heading . ' | '; ?>MiOWL (Something else here!)</title>

    <!-- Icon -->
    <link rel="Shortcut Icon" href="<?php print site_url('favicon.ico'); ?>" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?php print site_url('/style.css'); ?>" type="text/css" media="screen" charset="utf-8" />

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/blitzer/jquery-ui.css" type="text/css" media="screen" charset="utf-8" />
    <!-- <link rel="stylesheet" href="<?php print site_url('/css/jquery-ui.css'); ?>" type="text/css" media="screen" charset="utf-8" /> -->

	<!-- jQuery -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.js"></script>
	<script> /* localhost fallback if CDN goes down */
		window.jQuery || document.write('<script src="<?php print site_url('/js/jquery.min.js'); ?>"><\/script>\n<script src="<?php print site_url('/js/jquery-ui.min.js'); ?>"><\/script>')
	</script>

	<!-- 3rd Party and Custom -->
	<script type="text/javascript" src="<?php print site_url('/js/miowl.js'); ?>"></script>
	<script type="text/javascript" src="<?php print site_url('/js/uni-form.jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php print site_url('/js/tips.js'); ?>"></script>
	<script type="text/javascript" src="<?php print site_url('/js/jquery.countdown.js'); ?>"></script>

	<!--[if gte IE 9]>
	  <style type="text/css">
	    .gradient {
	       filter: none;
	    }
	  </style>
	<![endif]-->

</head>
<body>

<div id="container">

<?php $this->load->view('template/nav'); ?>

	<h1>
		<?php if ($this->session->userdata('owl_verified')) : ?>
			<div id="header_owl_name"><?php print $this->owl_model->get_owl_by_id($this->session->userdata('owl'))->row()->owl_name; ?></div>
		<?php endif; ?>
		<a id="site_logo" href="<?php print site_url(); ?>" title="Go back home!">
			<img 
				src="<?php print site_url('images/miowl_red_black_small.png'); ?>"
				alt="MiOWL Logo"
				width="500"
				height="205"
			>
		</a>
	</h1>
