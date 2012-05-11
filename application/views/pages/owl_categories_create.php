<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Category Creation
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
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('name'); ?>" />
                        <p class="formHint">Your new category name.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="sub_category">Sub Category?</label>
                        <select name="sub_category" id="sub_category" class="textInput medium" autocompelete="OFF" />
                            <option value="0" <?php echo set_select('sub_category', '0', TRUE); ?>>
                                None (top level category)
                            </option>
                            <?php foreach ($categories->result() as $row) : ?>
                            <?php if ($row->parent_id == "0") : ?>
                                <option value="<?php print $row->id; ?>" <?php echo set_select('sub_category', $row->parent_id, TRUE); ?>>
                                    <?php print $row->name; ?>
                                </option>
                            <?php endif; endforeach; ?>
                        </select>
                        <p class="formHint">If this is a sub category please choose it from the list.</p>
                    </div>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="reset">Clear</button>
                    <button class="button" type="submit">Create</button>
                </div>

            </form>
        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
