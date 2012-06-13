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

                <div><br/><pre><span class="result">loading...</span></pre><br/></div>

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

                    <div id="province-selection" class="ctrlHolder" >
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

                    <div id="owl-selection" class="ctrlHolder" >
                        <label for="owl">Search within specific owls?</label>
                        <div id="owl" style="display: inline-block;" >
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

                    <div id="keyword-selection" class="ctrlHolder">
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
    <script type="text/javascript">
        // hide the areas from a clear button
        $("button[type=reset]").click(function(e) {
            // prevent the default
            e.preventDefault();

            // reset all checkbox's
            $("input[type=checkbox]").each(function() {
                this.checked = false ;
            });

            // reset all the text input box's
            $("input[type=text]").val(null);

            // reset all the select box's
            $("select").val('default');

            // hide the div's again
            $("#province-selection").css("display","none");
            $("#owl-selection").css("display","none");
            $("#keyword-selection").css("display","none");
        });

        // type selection change
        $("#type").change(function() {
            type_list();
        }).change();

        //check we have at least one checkbox chosen in the province list
        $('.province_list').click(function() {
            province_list();
        });

        //check we have at least one checkbox chosen in the owl list
        $('.owl_list').click(function() {
            owl_list();
        });

        // list functions
        function type_list() {
            var str = $("#type option:selected").val();
            if(str != "default") {
                $.get('search/get_results/type/' + str, function(data) {
                    $('.result').html(data);
                    alert('Load was performed.');
                });

                $("#province-selection").css("display","block");
                $("#owl-selection").css("display","none");
                $("#keyword-selection").css("display","none");
                province_list();
                owl_list();
            }
            else {
                $("#province-selection").css("display","none");
                $("#owl-selection").css("display","none");
                $("#keyword-selection").css("display","none");
            }
        }
        function province_list() {
            if(($("#type option:selected").val() != "default") && ($(".province_list:checked").length > 0)) {
                var province_list = null;
                $(".province_list:checked").each(function() {
                    province_list += '-' + $(this).val();
                });

                $.get('search/get_results/type/' + province_list, function(data) {
                    $('.result').html(data);
                    alert('Load was performed.');
                });

                $("#owl-selection").css("display","block");
                $("#keyword-selection").css("display","none");
                owl_list();
            }
            else {
                $("#owl-selection").css("display","none");
                $("#keyword-selection").css("display","none");
            }
        }
        function owl_list() {
            if(($("#type option:selected").val() != "default") && ($(".province_list:checked").length > 0) && ($(".owl_list:checked").length > 0)) {
                $("#keyword-selection").css("display","block");
            }
            else {
                $("#keyword-selection").css("display","none");
            }
        }

        // checkAll/uncheckAll functions
        function checkAll(field)
        {
            $(field).each(function() {
                this.checked = true ;
            });

            if(field === '.province_list') {
                province_list();
            }
            if(field === '.owl_list') {
                owl_list();
            }
        }

        function uncheckAll(field)
        {
            $(field).each(function() {
                this.checked = false ;
            });

            if(field === '.province_list') {
                province_list();
            }
            if(field === '.owl_list') {
                owl_list();
            }
        }
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
