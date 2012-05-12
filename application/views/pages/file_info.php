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

        <form class="uniForm">
            <fieldset class="inlineLabels">

                <div class="ctrlHolder">
                    <label for="id">file id</label>
                    <input type="text" name="id" id="id" size="35" class="textInput medium" value="<?php print $info->row()->id; ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="upload_time">upload time (gmt)</label>
                    <input type="text" name="upload_time" id="upload_time" size="35" class="textInput medium" value="<?php print date("H:i:s d/m/Y", $info->row()->upload_time); ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="upload_user">upload user</label>
                    <input type="text" name="upload_user" id="upload_user" size="35" class="textInput medium" value="<?php print $this->user_model->get_user_by_id($info->row()->upload_user)->row()->user_name; ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="owl">owl</label>
                    <input type="text" name="owl" id="owl" size="35" class="textInput medium" value="<?php print $this->owl_model->get_owl_by_id($info->row()->owl)->row()->owl_name; ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="file_name">filename</label>
                    <input type="text" name="file_name" id="file_name" size="35" class="textInput medium" value="<?php print $info->row()->file_name; ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="upload_catagory">catagory</label>
                    <input type="text" name="upload_catagory" id="upload_catagory" size="35" class="textInput medium" value="<?php print $this->miowl_model->get_category($info->row()->upload_catagory)->row()->name; ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="file_type">filetype</label>
                    <input type="text" name="file_type" id="file_type" size="35" class="textInput medium" value="<?php print $info->row()->file_type; ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="file_size">file size</label>
                    <input type="text" name="file_size" id="file_size" size="35" class="textInput medium" value="<?php print $info->row()->file_size; ?>" disabled="disabled" />
                </div>

                <div class="ctrlHolder">
                    <label for="description">description</label>
                    <textarea name="description" id="description" size="35" class="textInput medium" rows="5" cols="50" disabled="disabled"><?php print $info->row()->description; ?></textarea>
                </div>

            </fieldset>

        </form>

        <div class="buttonHolder right">
            <br />
            <button onclick="window.location.href='<?php print site_url('browse'); ?>'" class="button">back</button>
            <button onclick="window.location.href='<?php print site_url('download/' . $info->row()->id); ?>'" class="button">download</button>
        </div>
        <div class="clear">&nbsp;</div>

    </div>

<?php $this->load->view('template/footer'); ?>
