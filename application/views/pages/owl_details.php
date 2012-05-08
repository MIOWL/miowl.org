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
                    <h3>
                        Telephone Number
                        <span style="vertical-align: super; color: lightBlue ! important;" id="tel" class="icon_font">d</span>
                    </h3>
                    <?php print $details->row()->owl_tel == '0' ? 'N/A' : $details->row()->owl_tel; ?>
                </div>
                <br>
                <div id="owl_website">
                    <h3>
                        <span id="www" class="icon_font">K</span>
                        Homepage
                    </h3>
                    <?php print $details->row()->owl_site == NULL ? 'N/A' : '<a href="' . $details->row()->owl_site . '" title="Owl Homepage" target="_BLANK">' . $details->row()->owl_site . '</a>'; ?>
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
