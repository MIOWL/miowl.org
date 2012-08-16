<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			OWL Categories
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">
            <?php print ul($categories, array('id' => 'categories')); ?>
        </div>
        <div class="clear">&nbsp;</div>
    </div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {

        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
