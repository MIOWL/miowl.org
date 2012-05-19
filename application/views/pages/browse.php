<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			File Browser
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
