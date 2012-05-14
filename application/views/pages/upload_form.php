<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Upload a new file
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <!-- upload -->
            <?php echo form_open_multipart('', array('class' => 'uniForm'));?>

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">

                    <div class="ctrlHolder">
                        <label for="userfile">File <span class="right">(required)</span></label>
                        <input type="file" name="userfile" id="userfile" size="35" class="textInput medium" value="<?php print set_value('userfile'); ?>" />
                        <p class="formHint">Choose the file you want to upload. Must be <strong><?php print $allow_types; ?></strong></p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="filename">Name <span class="right">(optional)</span></label>
                        <input type="text" name="filename" id="filename" size="35" class="textInput medium" value="<?php print set_value('filename'); ?>" />
                        <p class="formHint">Choose the file's display name.<br><strong>NOTE:</strong> leave blank to use the uploaded filename.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="category">Category <span class="right">(required)</span></label>
                        <select name="category" id="category" class="textInput medium" autocompelete="OFF" />
                            <?php foreach ($categories->result() as $row) : ?>
                            <?php if ($row->parent_id == "0") : ?>
                                <option value="<?php print $row->id; ?>" <?php echo set_select('category', $row->id); ?>>
                                    <?php print $row->name; ?>
                                </option>
                            <?php endif; endforeach; ?>
                        </select>
                        <p class="formHint">Choose the file's catagory.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="license">License <span class="right">(required)</span></label>
                        <select name="license" id="license" class="textInput medium" autocompelete="OFF" />
                            <?php foreach ($license->result() as $row) : ?>
                                <option value="<?php print $row->id; ?>" <?php echo set_select('license', $row->id); ?>>
                                    <?php print $row->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="formHint">Choose the file's license.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="description">Description <span class="right">(required)</span></label>
                        <textarea name="description" id="description" size="35" class="textInput medium" rows="5" cols="50"><?php print trim(set_value('description')); ?></textarea>
                        <p class="formHint">Enter a description for the file.</p>
                    </div>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="submit">Upload</button>
                </div>

            </form>

        </div>
        <div class="clear">&nbsp;</div>
	</div>

<?php $this->load->view('template/footer'); ?>
