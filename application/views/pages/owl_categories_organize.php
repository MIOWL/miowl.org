<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Categories Organization Page
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <div id="categories_list">
                <h2>Categories</h2>
                <?php
                    if (!empty(gen_categories()))
                        print ul(gen_categories(), array('id' => 'categories'));
                    else
                        print "You have no custom categories created...";
                ?>
            </div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
