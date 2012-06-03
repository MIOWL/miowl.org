<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">
        <div id="search_nav" class="column left quarter">
            <?php $this->load->view('search/_nav'); ?>
        </div>
        <div id="search_body" class="column right threequarter">

            <div>
                <h2>General Site Search</h2>
                <?php $this->load->view('search/__search_bar'); ?>
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

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
