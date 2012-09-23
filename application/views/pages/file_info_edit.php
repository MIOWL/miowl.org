<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">

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
                    <input type="text" name="file_name" id="file_name" class="textInput large" value="<?php print $upload_info->row()->file_name; ?>" />
                </div>

                <div class="ctrlHolder">
                    <label for="upload_category">category</label>
                    <select name="upload_category" id="upload_category" class="textInput large">
                        <?php foreach ( gen_drop_categories( FALSE, FALSE, $upload_info->row()->upload_category ) as $category ) : ?>
                            <option value="<?php print $category['id']; ?>" <?php print $upload_info->row()->upload_category === $category['id'] ? 'selected="selected"' : NULL; ?>>
                                <?php print $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="ctrlHolder">
                    <label for="upload_license">license</label>
                    <?php $license = $this->lic_model->get_license($upload_info->row()->upload_license); ?>
                    <select name="upload_license" id="upload_license" class="textInput large">
                        <?php foreach ( $license_data->result() as $license ) : ?>
                            <option value="<?php print $license->id; ?>" <?php print $upload_info->row()->upload_license === $license->id ? 'selected="selected"' : NULL; ?>>
                                <?php print $license->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="ctrlHolder">
                    <label for="description">description</label>
                    <textarea name="description" id="description" size="35" class="textInput large" rows="5" cols="50" maxlength="255"><?php print trim($upload_info->row()->description); ?></textarea>
                    <div id="description-chars" style="margin-left: 34%;">Loading...</div>
                    <p class="formHint">Enter a description for the file. Maximum character count is 255.</p>
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
                var id = <?php print $upload_info->row()->id; ?>,
                    uri = "<?php print site_url('browse/info'); ?>/" + id;

                // get the JSON data from the request
                $.post('/owl/uploads/edit/' + id, {
                    name:   $('#file_name').val(),
                    cat:    $('#upload_category').val(),
                    lic:    $('#upload_license').val(),
                    desc:   $('#description').val(),
                    date:   $('#revDate').val()
                },
                function(response) {
                    // was the edit a success?
                    if (response.success) {
                        // send back to the file view
                        window.location.href = uri;
                    }
                    else {
                        alert('Sorry, an error has occured. Please report this to the site admin.');
                    }
                }, "json");
            })

            $( "#revDate" ).datepicker({
                showOn: "button",
                buttonImage: "/images/calendar.gif",
                buttonImageOnly: true,
                dateFormat: "dd MM yy"
            });

            // jQuery Limit counter
            $("#description").limiter($("#description-chars"));
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
