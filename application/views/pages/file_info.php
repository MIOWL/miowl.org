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

                <!--div class="ctrlHolder">
                    <label for="id">file id</label>
                    <span name="id" id="id" size="35" class="textInput medium"><?php print $upload_info->row()->id; ?></span>
                </div-->

                <!--div class="ctrlHolder">
                    <label for="file_size">file size</label>
                    <span name="file_size" id="file_size" size="35" class="textInput medium"><?php print $upload_info->row()->file_size; ?></span>
                </div-->

                <div class="ctrlHolder">
                    <label for="file_name">filename</label>
                    <span name="file_name" id="file_name" size="35" class="textInput medium"><?php print $upload_info->row()->file_name; ?></span>
                </div>

                <div class="ctrlHolder">
                    <label for="description">description</label>
                    <span name="description" id="description" class="textInput medium"><?php print str_replace(array("\n", '\n'), "<br>", $upload_info->row()->description); ?></span>
                </div>

                <div class="ctrlHolder">
                    <label for="owl">OWL</label>
                    <span name="owl" id="owl" size="35" class="textInput medium">
                        <a href="<?php print site_url('browse/owl/' . $upload_info->row()->owl); ?>">
                            <?php print $this->owl_model->get_owl_by_id($upload_info->row()->owl)->row()->owl_name; ?>
                        </a>
                    </span>
                </div>

                <div class="ctrlHolder">
                    <label for="upload_category">category</label>
                    <span name="upload_category" id="upload_category" size="35" class="textInput medium"><?php print cat_breadcrumb($upload_info->row()->upload_category); ?></span>
                </div>

                <div class="ctrlHolder">
                    <label for="file_type">filetype</label>
                    <span name="file_type" id="file_type" size="35" class="textInput medium"><?php print $upload_info->row()->file_type; ?></span>
                </div>

                <div class="ctrlHolder">
                    <label for="upload_license">license</label>
                    <?php $license = $this->lic_model->get_license($upload_info->row()->upload_license); ?>
                    <span name="upload_license" id="upload_category" size="35" class="textInput medium">
                        <a href="<?php print $license->row()->url; ?>" target="_BLANK">
                            <?php print $license->row()->short_description; ?>
                        </a>
                    </span>
                </div>

                <div class="ctrlHolder">
                    <label for="upload_time">upload time (est)</label>
                    <span name="upload_time" id="upload_time" size="35" class="textInput medium"><?php print date("H:i:s d/m/Y", $upload_info->row()->upload_time); ?></span>
                </div>

                <div class="ctrlHolder">
                    <label for="revDate">revision date</label>
                    <span name="revDate" id="revDate" class="textInput medium"><?php
                        print ( !is_null( $upload_info->row()->revision_date ) ) ?
                            date("d/m/Y", $upload_info->row()->revision_date) :
                            'N/A';
                    ?></span>
                </div>

                <?php if(is_member($upload_info->row()->owl)) : ?>
                    <div class="ctrlHolder">
                        <label for="upload_user">upload user</label>
                        <?php $user = $this->user_model->get_user_by_id($upload_info->row()->upload_user); ?>
                        <span name="upload_user" id="upload_user" size="35" class="textInput medium"><?php print $user->row()->user_first_name; ?> <?php print $user->row()->user_last_name; ?> (<?php print $user->row()->user_name; ?>)</span>
                    </div>
                <?php endif; ?>

            </fieldset>

        </div>

        <div class="buttonHolder right">
            <br />

            <?php if ( ( (int)$this->session->userdata('owl') === (int)$upload_info->row()->owl ) && ( is_editor() ) ) : ?>
                <?php if (isset($deleted) && !$deleted) : ?>
                    <button class="button edit" onclick="window.location.href='<?php print site_url('browse/info_edit/' . $upload_info->row()->id); ?>'">edit</button>
                <?php endif; ?>
                <?php if ( $this->uri->segment(1) != 'deleted' ) : ?>
                    <button class="button delete">delete</button>
                <?php else : ?>
                    <button class="button go">restore</button>
                <?php endif; ?>
            <?php endif; ?>

            <a href="javascript:history.back()" class="button pv">back</a>
            <button onclick="window.location.href='<?php print site_url('download/' . $upload_info->row()->id); ?>'" class="button like">download</button>
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

            $('button.go').click( function(e) {
                // prevent the default action
                e.preventDefault();

                // set the id
                var id = <?php print $upload_info->row()->id; ?>,
                    uri = "<?php print site_url('browse/info'); ?>/" + id;

                $.ajax({
                    type: 'GET',
                    url: '/owl/uploads/restore/' + id,
                    dataType: 'text',
                    success: function(response) {
                        if (response == "1") {
                            window.location.href = uri;
                        }
                    }
                });
            })
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
