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
                    <h2><?php print $details->row()->owl_name; ?></h2>
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
                <script type="text/javascript"
                  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwyacbEev3PdXvfNuAJZCrLy3StRXsKLI&sensor=false">
                </script>
                <script type="text/javascript">
                    $(function() {
                        function generate_map(location1, location2) {
                            var myOptions = {
                                center: new google.maps.LatLng(location1, location2),
                                zoom: 8,
                                mapTypeId: google.maps.MapTypeId.HYBRID
                            };
                            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                        };

                        generate_map(-34.397, 150.644);
                    });
                </script>
                <script type="text/javascript">
                </script>
                <div id="map_canvas">Loading Map...</div>
            </div>
            <div class="clear">&nbsp;</div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
