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

            <div class="column left quarter">
                <div id="owl_name">
                    <?php print $details->row()->owl_name; ?>
                </div>
                <div id="owl_address">
                    <?php print $details->row()->owl_address; ?>
                    <br />
                    <?php print $details->row()->owl_city; ?>
                    <br />
                    <?php print $details->row()->owl_province; ?>
                    <br />
                    <?php print $details->row()->owl_post_code; ?>
                </div>
            </div>
            <div class="column right threequarter">
                <div id="map_canvas">Loading Map...</div>
            </div>
            <div class="clear">&nbsp;</div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
