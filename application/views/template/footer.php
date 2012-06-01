  <div class="clear">&nbsp;</div>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

<!-- ---------------------------------------------------------------------------------------------- -->
<!-- -------------------------------------- JAVASCRRIPT HERE -------------------------------------- -->
<!-- ---------------------------------------------------------------------------------------------- -->

<!-- jQuery -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script>
	window.jQuery || document.write('<script src="<?php print site_url('/js/jquery.min.js'); ?>"><\/script>\n<script src="<?php print site_url('/js/jquery-ui.min.js'); ?>"><\/script>')
</script>

<!-- 3rd Party and Custom -->
<script type="text/javascript" src="<?php print site_url('/js/miowl.js'); ?>"></script>
<script type="text/javascript" src="<?php print site_url('/js/uni-form.jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php print site_url('/js/tips.js'); ?>"></script>
<script type="text/javascript" src="<?php print site_url('/js/jquery.countdown.js'); ?>"></script>

<?php if(isset($owl_selection) && $owl_selection) : ?>
  <script type="text/javascript" src="<?php print site_url('/js/owl_selection.js'); ?>"></script>
<?php endif; ?>

<?php if(isset($search_vars)) : ?>
  <!-- Fancy IOS Switch Button -->
  <script type="text/javascript" src="<?php print site_url('/js/jquery.option-switch.js'); ?>"></script>
  <script type="text/javascript">
  <?php foreach ($search_vars as $name => $description) : ?>
    $('.<?php print $name; ?>Image').optionSwitch("on", 
      function() {
        $(".<?php print $name; ?>").css('display', 'block' );
      },
      function() {
        $(".<?php print $name; ?>").css('display', 'none');
      },
      {
        switch_on_container_path: '<?php print site_url("images/switch_container_on.png"); ?>',
        switch_off_container_path: '<?php print site_url("images/switch_container_off.png"); ?>',
        switch_path: '<?php print site_url("images/switch.png"); ?>'
      }
    );
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

<!-- ---------------------------------------------------------------------------------------------- -->

</body>
</html>