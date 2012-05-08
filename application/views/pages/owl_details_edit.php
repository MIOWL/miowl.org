<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <form action="" class="uniForm" method="post">

                <?php
                    if($this->input->post('new_owl'))
                        $this->load->view('messages/message_inline');
                ?>

                <fieldset class="inlineLabels">
                    <div class="ctrlHolder">
                        <label for="name">Organization Name</label>
                        <input type="text" name="name" id="name" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('name') == '' ? $details->row()->owl_name : set_value('name'); ?>" />
                        <p class="formHint">Your organization name, aka owl name.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="acronym">Organization Acronym</label>
                        <input type="text" name="acronym" id="acronym" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('acronym') == '' ? $details->row()->owl_name_short : set_value('acronym'); ?>" />
                        <p class="formHint">Short acronym for your owl.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="type">Owl Type</label>
                        <select name="type" id="type" class="textInput medium" autocompelete="OFF" />
                            <?php if($details->row()->owl_type == 'clinic') : ?>
                                <option value="clinic" <?php echo set_select('type', 'clinic', TRUE); ?>>Clinic</option>
                                <option value="hospital" <?php echo set_select('type', 'hospital'); ?>>Hospital</option>
                            <?php else : ?>
                                <option value="clinic" <?php echo set_select('type', 'clinic'); ?>>Clinic</option>
                                <option value="hospital" <?php echo set_select('type', 'hospital', TRUE); ?>>Hospital</option>
                            <?php endif; ?>
                        </select>
                        <p class="formHint">Please choose your Owl type from the list.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="address">Address</label>
                        <input type="address" name="address" id="address" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('address') == '' ? $details->row()->owl_address : set_value('address'); ?>" />
                        <p class="formHint">Your Organizations 1st line of address.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="province">Province</label>
                        <select name="province" id="province" class="textInput medium" autocompelete="OFF" />
                            <?php foreach ($province as $value) : if ($value == $details->row()->owl_province) :?>
                                <option value="<?php print $value; ?>" <?php echo set_select('province', $value, TRUE); ?>><?php print $value; ?></option>
                            <?php else : ?>
                                <option value="<?php print $value; ?>" <?php echo set_select('province', $value); ?>><?php print $value; ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                        <p class="formHint">Please choose your province the list.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('city') == '' ? $details->row()->owl_city : set_value('city'); ?>" />
                    </div>

                    <div class="ctrlHolder">
                        <label for="zip">Postal Code</label>
                        <input type="text" name="zip" id="zip" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('zip') == '' ? $details->row()->owl_post_code : set_value('zip'); ?>" />
                    </div>

                    <div class="ctrlHolder">
                        <label for="tel">Phone Number (Optional)</label>
                        <input type="text" name="tel" id="tel" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('tel') != '' ? set_value('tel') : $details->row()->owl_tel != '0' ? $details->row()->owl_tel : NULL ; ?>" />
                    </div>

                    <div class="ctrlHolder">
                        <label for="site">Website (Optional)</label>
                        <input type="text" name="site" id="site" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('site') == '' ? $details->row()->owl_site : set_value('site'); ?>" />
                        <p class="formHint">Your organization's website.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="email">Administrator Email</label>
                        <input type="text" name="email" id="email" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('email') == '' ? $details->row()->owl_email : set_value('email'); ?>" />
                        <p class="formHint">This must be a valid email. Used to verify new owl members and this owl registraton.</p>
                    </div>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="reset">Clear</button>
                    <button class="button" type="submit">Update</button>
                </div>

            </form>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
