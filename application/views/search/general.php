<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">

            <div>
                <h2>General Site Search</h2>
                <br />
                <div>
                	<?php if($query) : ?>
                		<?php $this->load->view('search/__table'); ?>
                	<?php else : ?>
                		No Results Found...
                	<?php endif; ?>
                </div>

                <!-- pagination -->
                <div class="pagination">
                    <center><?php print $this->pagination->create_links(); ?></center>
                </div>
            </div>

        <?php /*
        </div>
        <div class="clear">&nbsp;</div>
        */ ?>
    </div>

<?php $this->load->view('template/footer'); ?>
