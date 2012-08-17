  <div class="clear">&nbsp;</div>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

<!-- ---------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------- JAVASCRRIPT HERE -------------------------------------- -->
<!-- ---------------------------------------------------------------------------------------------- -->

<?php if(isset($owl_selection) && $owl_selection) : ?>
  <script type="text/javascript" src="<?php print site_url('/js/owl_selection.js'); ?>"></script>
<?php endif; ?>

<?php if(isset($search_page) && $search_page) : ?>
  <!-- Fancy Search jQuery -->
  <script type="text/javascript">
    <?php foreach ($this->owl_model->get_all_owls()->result() as $row) : ?>
      $('#owls-<?php print $row->id; ?>').click(function() {
          $("#owls_lic-<?php print $row->id; ?>").toggle(this.checked);
      });
    <?php endforeach; ?>
  </script>
<?php endif; ?>

<?php if(isset($google_maps) && $google_maps) : ?>
  <!-- Google Maps -->
  <script type="text/javascript"
    <?php $api_key = 'AIzaSyDjexgoW5CHCXZEBj0mq2lEFfRIudNUITk'; ?>
    src="https://maps.googleapis.com/maps/api/js?key=<?php print $api_key; ?>&sensor=false">
  </script>
  <script type="text/javascript">
      $(document).ready(function() {
          function generate_map(status, accuracy, location1, location2) {
              var myOptions = {
                  center: new google.maps.LatLng(location1, location2),
                  zoom: 17,
                  mapTypeId: google.maps.MapTypeId.HYBRID
              };
              var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
          };

          generate_map(<?php print $location; ?>);
      });
  </script>
  <script type="text/javascript">
      var chatSymbols = ['d', 'e'],
          chatRate = 300,
          chatIndex = 0,
          chat = function() {
                  document.getElementById('tel').innerHTML = chatSymbols[chatIndex];
                  chatIndex = chatIndex < chatSymbols.length - 1 ? chatIndex + 1 : 0;
                  setTimeout(chat, chatRate);
              };
      chat();
  </script>
<?php endif; ?>

<!-- Google Analytics -->
  <script>
    var _gaq=[['_setAccount','UA-31288786-1'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>

<!-- ---------------------------------------------------------------------------------------------- -->

</body>
</html>