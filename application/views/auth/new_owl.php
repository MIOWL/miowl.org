<?php $this->load->view('template/header'); ?>

    <h1>
        <center>
            Choose existing Owl!
        </center>
    </h1>

	<div id="body">
        <!-- choose existing owl -->
        <form action="" class="uniForm" method="post">
            <fieldset class="inlineLabels">
                <div class="ctrlHolder">
                    <label for="owl">Owl</label>
                    <select name="owl" id="owl" class="textInput medium" autocompelete="OFF" />
                        <option value="new">New Owl</option>
                        <?php if($owls) : foreach ($owls as $value => $owl) : ?>
                            <option value="<?php print $value; ?>"><?php print $owl; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <p class="formHint">Please choose your Owl from the list. Or register a new owl below...</p>
                </div>
            </fieldset>
            <div class="buttonHolder">
                <button class="button" type="submit">Choose</button>
            </div>
        </form>
    </div>


    <h1>
        <center>
            Register New Owl!
        </center>
    </h1>

    <div id="body">
        <!-- register new owl -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

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
                        <option>Select</option>
                        <option value="clinic">Clinic</option>
                        <option value="hospital">Hospital</option>
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
                        <option>Select</option>
                        <option value="Alberta">Alberta</option>
                        <option value="British Columbia">British Columbia</option>
                        <option value="Manitoba">Manitoba</option>
                        <option value="New Brunswick">New Brunswick</option>
                        <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                        <option value="Northwest Territories">Northwest Territories</option>
                        <option value="Nova Scotia">Nova Scotia</option>
                        <option value="Nunavut">Nunavut</option>
                        <option value="Ontario">Ontario</option>
                        <option value="Prince Edward Island">Prince Edward Island</option>
                        <option value="Quebec">Quebec</option>
                        <option value="Saskatchewan">Saskatchewan</option>
                        <option value="Yukon">Yukon</option>
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
                    <input type="text" name="test" id="tel" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('tel'); ?>" />
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
