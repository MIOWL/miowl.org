<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">

            <!-- Search Form -->
            <form action="" name="search" class="uniForm" method="post">

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">

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

                    <div id="provinceSelection" class="ctrlHolder" >
                        <label for="province[]">Province</label>
                        <div id="province_list" style="display: inline-block;" >
                            <?php foreach ($province_list as $province) : ?>
                                <input
                                    type="checkbox"
                                    name="province[]"
                                    class="province_list"
                                    value="<?php print $province; ?>"
                                    <?php
                                        $plist = $this->input->post('province');
                                        if(is_array($plist))
                                            print in_array($province, $plist) ? 'checked="checked"' : NULL;
                                    ?>
                                />&nbsp;&nbsp;&nbsp;&nbsp;<?php print $province; ?>
                                <br />
                            <?php endforeach; ?>
                            <span class="save button"   onclick="checkAll('.province_list')"   > Check All </span>
                            <span class="delete button" onclick="uncheckAll('.province_list')" > Uncheck All </span>
                        </div>
                        <p class="formHint">Choose the province search within.</p>
                    </div>

                    <div id="owlSelection" class="ctrlHolder" >
                        <label for="owl">Search within specific owls?</label>
                        <div id="owl_list" style="display: inline-block;" >
                            <?php foreach ($this->owl_model->get_all_owls()->result() as $row) : ?>
                                <input
                                    type="checkbox"
                                    name="owl[]"
                                    class="owl_list"
                                    value="<?php print $row->id; ?>"
                                    <?php
                                        $plist = $this->input->post('owl');
                                        if(is_array($plist))
                                            print in_array($row->id, $plist) ? 'checked="checked"' : NULL;
                                    ?>
                                />&nbsp;&nbsp;&nbsp;&nbsp;<?php print $row->owl_name; ?>
                                <br />
                            <?php endforeach; ?>
                            <span class="save button"   onclick="checkAll('.owl_list')"   > Check All </span>
                            <span class="delete button" onclick="uncheckAll('.owl_list')" > Uncheck All </span>
                        </div>
                        <p class="formHint">Choose the owl's you wish to search within.</p>
                    </div>

                    <div id="keywordSelection" class="ctrlHolder">
                        <label for="keyword">Keyword</label>
                        <input type="text" name="keyword" id="keyword" size="35" class="textInput medium" value="<?php print set_value('keyword'); ?>" />
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
    <script type="text/javascript" src="<?php print site_url('/js/miowl.search.js'); ?>"></script>
    <script type="text/javascript">
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
