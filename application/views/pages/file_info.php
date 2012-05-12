<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">

        <!--
        Details Page :
                        id
                        upload_time
                        upload_user
                        owl
                        file_name
                        upload_catagory
                        file_type
                        file_size
                        description
        -->

        <fieldset class="inlineLabels">

            <div class="ctrlHolder">
                <label for="id">File</label>
                <input type="text" name="id" id="id" size="35" class="textInput medium" value="<?php print $info->row()->id; ?>" />
            </div>

        </fieldset>

    </div>

<?php $this->load->view('template/footer'); ?>
