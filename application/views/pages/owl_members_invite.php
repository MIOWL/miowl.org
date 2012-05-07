<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Member Invite
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">
            THIS IS THE INVITE PAGE!!!<br>
            (as you can see its not finished...)
            <br>
            <br>
            <pre><?php print var_dump($owl_info->result()); ?></pre>
        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
