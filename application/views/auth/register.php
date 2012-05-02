<?php $this->load->view('template/header'); ?>

    <h1>
        <center>
            Registration Page!
        </center>
    </h1>

	<div id="body">
        <!-- register -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">
                <div class="ctrlHolder">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('firstname'); ?>" />
                    <p class="formHint">Your first name. (i.e. Joe)</p>
                </div>

                <div class="ctrlHolder">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('lastname'); ?>" />
                    <p class="formHint">Your second name. (i.e. Bloggs)</p>
                </div>

                <div class="ctrlHolder">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('username'); ?>" />
                    <p class="formHint">Pick a username. (Used to login.)</p>
                </div>

                <div class="ctrlHolder">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" size="35" class="textInput medium" autocompelete="OFF" />
                    <p class="formHint">Choose your password.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="password_again">Password again</label>
                    <input type="password" name="password_again" id="password_again" size="35" class="textInput medium" autocompelete="OFF" />
                    <p class="formHint">Retype the above password.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('email'); ?>" />
                    <p class="formHint">This must be a valid email, for verification.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="owl">Owl</label>
                    <select name="owl" id="owl" class="textInput medium" autocompelete="OFF" />
                        <option value="default" <?php echo set_select('owl', 'default', TRUE); ?>>Select</option>
                        <option value="new" <?php echo set_select('owl', 'new'); ?>>New Owl</option>
                        <?php if($owls) : foreach ($owls as $value => $owl) : ?>
                            <option value="<?php print $value; ?>" <?php echo set_select('owl', $value); ?>><?php print $owl; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                    <p class="formHint">Please choose your Owl from the list. If you choose an existing Owl, the owner of this Owl will need to approve you. If you choose "New Owl" you will be prompted to create this owl after account validation.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="spamcheck">The URI of this website.</label>
                    <input type="text" name="spamcheck" id="spamcheck" size="35" class="textInput medium" autocompelete="OFF" />
                    <p class="formHint">type &ldquo;miowl.org&rdquo; into this box.</p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="reset">Clear</button>
                <button class="button" type="submit">Register</button>
            </div>

        </form>
	</div>

<?php $this->load->view('template/footer'); ?>
