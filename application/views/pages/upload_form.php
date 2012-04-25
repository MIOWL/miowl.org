<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Upload a new file
		</center>
	</h1>

	<div id="body">

        <!-- login -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">

                <div class="ctrlHolder">
                    <label for="userfile">File</label>
                    <input type="file" name="userfile" id="userfile" size="35" class="textInput medium" value="<?php print !isset($post_back['userfile']) ? '' : $post_back['userfile']; ?>" />
                    <p class="formHint">Choose the file you want to upload. Must be <strong><?php print $allow_types; ?></strong></p>
                </div>

                <div class="ctrlHolder">
                    <label for="filename">Name</label>
                    <input type="text" name="filename" id="filename" size="35" class="textInput medium" value="<?php print !isset($post_back['filename']) ? '' : $post_back['filename']; ?>" />
                    <p class="formHint">Choose the file's display name.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="catagory">Catagory</label>
                    <input type="text" name="catagory" id="catagory" size="35" class="textInput medium" value="<?php print !isset($post_back['catagory']) ? '' : $post_back['catagory']; ?>" />
                    <p class="formHint">Choose the file's catagory.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" size="35" class="textInput medium" rows="5" cols="50">
                    	<?php print !isset($post_back['description']) ? '' : $post_back['description']; ?>
                    </textarea>
                    <p class="formHint">Enter a description for the file.</p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="submit">Upload</button>
            </div>

        </form>

	</div>

<?php $this->load->view('template/footer'); ?>
