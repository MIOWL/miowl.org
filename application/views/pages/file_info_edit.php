<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			File Info
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
                        upload_category
                        upload_license
                        file_type
                        file_size
                        description
        -->

        <div
        class="uniForm"
        <?php if (isset($deleted) && $deleted) : ?>
            style="background-image: url(<?php print base_url('images/data-deletion.png'); ?>); background-position: center center; background-repeat: no-repeat;"
        <?php endif; ?>
        >

            <fieldset class="inlineLabels">

                <?php $this->load->view('messages/message_inline'); ?>

                <div class="ctrlHolder">
                    <label for="file_name">filename</label>
                    <input type="text" name="file_name" id="file_name" size="35" class="textInput medium" value="<?php print $upload_info->row()->file_name; ?>" />
                </div>

                <div class="ctrlHolder">
                    <label for="upload_category">category</label>
                    <span name="upload_category" id="upload_category" size="35" class="textInput medium"><?php print cat_breadcrumb($upload_info->row()->upload_category); ?></span>
                </div>

                <div class="ctrlHolder">
                    <label for="upload_license">license</label>
                    <?php $license = $this->miowl_model->get_license($upload_info->row()->upload_license); ?>
                    <span name="upload_license" id="upload_category" size="35" class="textInput medium">
                        <a href="<?php print $license->row()->url; ?>" target="_BLANK">
                            <?php print $license->row()->short_description; ?>
                        </a>
                    </span>
                </div>

                <div class="ctrlHolder">
                    <label for="description">description</label>
                    <span name="description" id="description" class="textInput medium"><?php print str_replace(array("\n", '\n'), "<br>", $upload_info->row()->description); ?></span>
                </div>

                <div class="ctrlHolder">
                    <label for="revDate">revision date</label>
                    <input type="text" name="revDate" id="revDate" class="textInput medium" value="<?php
                        print ( !is_null( $upload_info->row()->revision_date ) ) ?
                            date("d/m/Y", $upload_info->row()->revision_date) :
                            '';
                    ?>" />
                </div>

            </fieldset>

        </div>

        <div class="buttonHolder right">
            <br />
            <a href="javascript:history.back()" class="button pv">back</a>
            <button class="button delete">delete</button>
            <button class="button edit">update</button>
        </div>

        <div class="clear">&nbsp;</div>

    </div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {
            $('button.delete').click( function(e) {
                // prevent the default action
                e.preventDefault();

                // set the id
                var id = <?php print $upload_info->row()->id; ?>,
                    uri = "<?php print site_url('deleted/info'); ?>/" + id;

                $.ajax({
                    type: 'GET',
                    url: '/owl/uploads/remove/' + id,
                    dataType: 'text',
                    success: function(response) {
                        if (response == "1") {
                            $('#r-' + id).fadeOut('slow', function() {
                                $('#r-' + id).empty();
                            });
                            window.location.href = uri;
                        }
                    }
                });
            })

            $('button.edit').click( function(e) {
                // prevent the default action
                e.preventDefault();

                // set the id
                var id = <?php print $upload_info->row()->id; ?>;
            })
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
