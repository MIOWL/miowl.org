<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">
        <?php /*
        <div id="search_nav" class="column left quarter">
            <?php $this->load->view('search/_nav'); ?>
        </div>
        <div id="search_body" class="column right threequarter">
        */ ?>

            <!-- Search Form -->
            <form action="" class="uniForm" method="post">

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">

                    <div class="ctrlHolder">
                        <label for="keyword">Keyword</label>
                        <input type="text" name="keyword" id="keyword" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('keyword'); ?>" />
                    </div>

                    <div class="ctrlHolder" >
                        <label for="type">Clinic, Hospital or Both?</label>
                        <select id="type" name="type" >
                            <option value="default" autocompelete="OFF" <?php echo set_select('type', 'default', TRUE); ?> />Select...</option>
                            <option value="clinic" autocompelete="OFF" <?php echo set_select('type', 'clinic'); ?> />Clinic</option>
                            <option value="hospital" autocompelete="OFF" <?php echo set_select('type', 'hospital'); ?> />Hospital</option>
                            <option value="both" autocompelete="OFF" <?php echo set_select('type', 'both'); ?> />Both</option>
                        </select>
                        <p class="formHint">Choose the type of owl you wish to search within.</p>
                    </div>

                    <div id="province-selection" class="ctrlHolder" >
                        <label for="province">Province</label>
                        <div style="display: inline-block;" >
                            <input type="checkbox" id="select_all-owls" autocompelete="OFF" />&nbsp;&nbsp;&nbsp;&nbsp; Select All
                            <br />
                            <?php foreach ($province_list as $province) : ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="province" id="province-<?php print $province; ?>" value="<?php print $province; ?>" <?php if($this->input->post('province-' . $province)) print 'checked="checked"'; ?> autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $province; ?>
                                <br />
                            <?php endforeach; ?>
                        </div>
                        <p class="formHint">Choose the province search within.</p>
                    </div>

                    <div id="owls-selection" class="ctrlHolder" >
                        <label for="s_owl_id">Search within specific owls?</label>
                        <div class="s_owl_id" style="display: inline-block;" >
                            <?php foreach ($this->owl_model->get_all_owls()->result() as $row) : ?>
                                <input type="checkbox" name="owls-<?php print $row->id; ?>" id="owls-<?php print $row->id; ?>" value="<?php print $row->id; ?>" <?php if($this->input->post('owls-' . $row->id)) print 'checked="checked"'; ?> autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $row->owl_name; ?>
                                <br />
                            <?php endforeach; ?>
                        </div>
                        <p class="formHint">Choose the owl's you wish to search within.<br /><strong>NOTE:</strong> selecting none will search all.</p>
                    </div>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="reset">Clear</button>
                    <button class="button" type="submit">Search</button>
                </div>

            </form>

        <?php /*
        </div>
        <div class="clear">&nbsp;</div>
        */ ?>
    </div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $("#type").change(function () {
            var str = $("#type option:selected").val();
            if(str != "default") {
                $("#province-selection").css("display","block");
            }
            else{
                $("#province-selection").css("display","none");
                $("#owls-selection").css("display","none");
            }
        }).change();
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
