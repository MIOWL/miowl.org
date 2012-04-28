<?php $this->load->view('template/header'); ?>

    <div<?php print $this->input->post('new_owl') ? ' style="display:none;"' : NULL ?>>
        <h1>
            <center>
                Choose existing Owl!
            </center>
        </h1>

    	<div id="body">
            <!-- choose existing owl -->
            <form action="owl" class="uniForm" method="post">
                <?php
                    if($this->input->post('existing_owl'))
                        $this->load->view('messages/message_inline');
                ?>
                <input type="hidden" name="existing_owl" id="existing_owl" value="existing_owl" />
                <fieldset class="inlineLabels">
                    <div class="ctrlHolder">
                        <label for="owl">Owl</label>
                        <select name="owl" id="owl" class="textInput medium" autocompelete="OFF" />
                            <option value="default">Select</option>
                            <?php if($owls) : foreach ($owls as $value => $owl) : ?>
                                <option value="<?php print $value; ?>"><?php print $owl; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                        <p class="formHint">Please choose your Owl from the list. Or register a new owl below...</p>
                    </div>
                </fieldset>
                <div class="buttonHolder">
                    <button class="button" type="submit" id="owl_choice">Choose</button>
                </div>
            </form>
        </div>
    </div>


    <h1>
        <center>
            Register New Owl!
        </center>
    </h1>

    <div id="body">
        <!-- register new owl -->
        <form action="owl" class="uniForm" method="post">

            <?php
                if($this->input->post('new_owl'))
                    $this->load->view('messages/message_inline');
            ?>

            <input type="hidden" name="new_owl" id="new_owl" value="new_owl" />

            <fieldset class="inlineLabels">
                <div class="ctrlHolder">
                    <label for="name">Organization Name</label>
                    <input type="text" name="name" id="name" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('name'); ?>" />
                    <p class="formHint">Your organization name, aka owl name.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="acronym">Organization Acronym</label>
                    <input type="text" name="acronym" id="acronym" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('acronym'); ?>" />
                    <p class="formHint">Short acronym for your owl.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="type">Owl Type</label>
                    <select name="type" id="type" class="textInput medium" autocompelete="OFF" />
                        <option value="default" <?php echo set_select('type', 'default', TRUE); ?>>Select</option>
                        <option value="clinic" <?php echo set_select('type', 'clinic'); ?>>Clinic</option>
                        <option value="hospital" <?php echo set_select('type', 'hospital'); ?>>Hospital</option>
                    </select>
                    <p class="formHint">Please choose your Owl type from the list.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="address">Address</label>
                    <input type="address" name="address" id="address" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('address'); ?>" />
                    <p class="formHint">Your Organizations 1st line of address.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="province">Province</label>
                    <select name="province" id="province" class="textInput medium" autocompelete="OFF" />
                        <option value="default" <?php echo set_select('province', 'select', TRUE); ?>>Select</option>
                        <?php foreach ($province as $value) : ?>
                            <option value="<?php print $value; ?>" <?php echo set_select('province', $value); ?>><?php print $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="formHint">Please choose your province the list.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('city'); ?>" />
                </div>

                <div class="ctrlHolder">
                    <label for="zip">Postal Code</label>
                    <input type="text" name="zip" id="zip" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('zip'); ?>" />
                </div>

                <div class="ctrlHolder">
                    <label for="tel">Phone Number</label>
                    <input type="text" name="tel" id="tel" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('tel'); ?>" />
                </div>

                <div class="ctrlHolder">
                    <label for="site">Website</label>
                    <input type="text" name="site" id="site" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('site'); ?>" />
                    <p class="formHint">Your organization's website.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="email">Administrator Email</label>
                    <input type="text" name="email" id="email" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('email'); ?>" />
                    <p class="formHint">
                        This must be a valid email. Used to verify new owl members.
                        <br>
                        Leave blank to use the email you registered with.
                    </p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="reset">Clear</button>
                <button class="button" type="submit">Create</button>
            </div>

        </form>
	</div>

<?php $this->load->view('template/footer'); ?>
