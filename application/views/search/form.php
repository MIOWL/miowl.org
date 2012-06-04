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

            <!-- Search Form -->
            <form action="" class="uniForm" method="post">

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">

                    <div class="ctrlHolder">
                        <label for="keyword">Keyword</label>
                        <input type="text" name="keyword" id="keyword" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('keyword'); ?>" />
                    </div>

                    <div class="ctrlHolder">
                        <label for="s_owl_id">Search within specific owls?</label>
                        <div class="s_owl_id" style="display: inline-block;" >
                            <?php foreach ($this->owl_model->get_all_owls()->result() as $row) : ?>
                                <input type="checkbox" name="owls-<?php print $row->id; ?>" id="owls-<?php print $row->id; ?>" value="<?php print $row->id; ?>" <?php echo set_checkbox('owls-' . $row->id, $row->id, TRUE); ?> autocompelete="OFF" style="margin: 0.5em 0pt 0pt 16.5em;" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $row->owl_name; ?>
                                <br />
                            <?php endforeach; ?>
                        </div>
                    <p class="formHint">Choose the owl's you wish to search within.<br /><strong>NOTE:</strong> selecting none will search all.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="s_lic_id">Search within specific licenses?</label>
                        <div class="s_lic_id" style="display: inline-block;" >
                            <span>TODO</span>
                        </div>
                    <p class="formHint">Choose the owl licenses you wish to search within.<br /><strong>NOTE:</strong> selecting none will search all.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="s_file_ext">Search for a specific filetype?</label>
                        <div class="s_file_ext" style="display: inline-block;" >
                            <?php foreach (array('txt', 'rtf', 'pdf', 'doc', 'docx') as $ext) : ?>
                                <input type="checkbox" name="file_ext-<?php print $ext; ?>" id="file_ext-<?php print $ext; ?>" value="<?php print $ext; ?>" <?php echo set_checkbox('file_ext-' . $ext, $ext, TRUE); ?> autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $ext; ?>
                                <br />
                            <?php endforeach; ?>
                        </div>
                    <p class="formHint">Choose the owl licenses you wish to search within.<br /><strong>NOTE:</strong> selecting none will search all.</p>
                    </div>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="reset">Clear</button>
                    <button class="button" type="submit">Search</button>
                </div>

            </form>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
