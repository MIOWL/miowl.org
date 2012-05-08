<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <div class="column left third">
                <div id="owl_name">
                    <h2><?php print $details->row()->owl_name; ?></h2>
                </div>
                <div id="owl_address">
                    <?php print $address; ?>
                </div>
                <div id="owl_tel">
                    <h3><span id="tel" class="icon_font">d</span> Telephone Number</h3>
                    <?php print $details->row()->owl_tel; ?>
                </div>
                <div id="owl_website">
                    <h3><span id="www" class="icon_font">@</span> Homepage</h3>
                    <?php print $details->row()->owl_site; ?>
                </div>
            </div>
            <div class="column right twothird">
                <div id="map_canvas">Loading Map...</div>
            </div>
            <div class="clear">&nbsp;</div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
