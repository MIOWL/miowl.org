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

            <form action="" class="uniForm" method="post">

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">
                    <div class="ctrlHolder">
                        <label for="owl">Organization</label>
                        <select name="owl" id="owl" class="textInput medium" autocompelete="OFF" />
                            <?php foreach ($this->owl_model->get_all_owls()->result() as $owl) : ?>
                                <option value="<?php print $owl->id; ?>" <?php print set_select('owl', $owl->id); ?>><?php print $owl->owl_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="formHint">Choose the organization you wish to browse, aka owl.</p>
                    </div>
                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="submit">Choose</button>
                </div>

            </form>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
