<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php
            if (isset($browse_by_owl) && $browse_by_owl) || (isset($browse_by_cat) && $browse_by_cat) : ?><a href="javascript:history.go(-1)" title="Back to the default browse page"><< back</a> | <?php endif; ?><?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">

		<?php print $table; ?>

        <!-- pagination -->
        <div class="pagination">
            <center><?php print $this->pagination->create_links(); ?></center>
        </div>

	</div>

<?php $this->load->view('template/footer'); ?>
