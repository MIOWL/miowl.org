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
            <form action="" name="search" class="uniForm" method="post">

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">

                    <div class="ctrlHolder">
                        <label for="keyword">Keyword</label>
                        <input type="text" name="keyword" id="keyword" size="35" class="textInput medium" value="<?php print set_value('keyword'); ?>" />
                    </div>

                    <div class="ctrlHolder" >
                        <label for="type">Clinic, Hospital or Both?</label>
                        <select id="type" name="type" >
                            <option value="default" <?php print set_select('type', 'default', TRUE); ?> />Select...</option>
                            <option value="clinic" <?php print set_select('type', 'clinic'); ?> />Clinic</option>
                            <option value="hospital" <?php print set_select('type', 'hospital'); ?> />Hospital</option>
                            <option value="both" <?php print set_select('type', 'both'); ?> />Both</option>
                        </select>
                        <p class="formHint">Choose the type of owl you wish to search within.</p>
                    </div>

                    <div id="province-selection" class="ctrlHolder" >
                        <label for="province[]">Province</label>
                        <div id="province_list" style="display: inline-block;" >
                            <?php $i=0; foreach ($province_list as $province) : ?>
                                <input type="checkbox" name="province[]" class="province_list" value="<?php print $province; ?>" <?php $plist = $this->input->post('province'); print isset($plist[$i]) ? 'checked="checked"' : NULL;) ?> />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $province; ?>
                                <br /><?php $i++; ?>
                            <?php endforeach; ?>
                            <span class="save button"   onclick="checkAll('.province_list')"   > Check All </span>
                            <span class="delete button" onclick="uncheckAll('.province_list')" > Uncheck All </span>
                        </div>
                        <p class="formHint">Choose the province search within.</p>
                    </div>

                    <div id="owls-selection" class="ctrlHolder" >
                        <label for="owl">Search within specific owls?</label>
                        <div id="owl" style="display: inline-block;" >
                            <?php foreach ($this->owl_model->get_all_owls()->result() as $row) : ?>
                                <input type="checkbox" name="owl[]" class="owl_list" value="<?php print $row->id; ?>" <?php print set_checkbox('owl[]', $row->id); ?> />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $row->owl_name; ?>
                                <br />
                            <?php endforeach; ?>
                            <span class="save button"   onclick="checkAll('.owl_list')"   > Check All </span>
                            <span class="delete button" onclick="uncheckAll('.owl_list')" > Uncheck All </span>
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

        // type selection change
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

        // checkAll/uncheckAll functions
        function checkAll(field)
        {
            $(field).each(function (i)
            {
                $(this).checked = true ;
            });
        }

        function uncheckAll(field)
        {
            $(field).each(function (i)
            {
                $(this).checked = false ;
            });
        }
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
