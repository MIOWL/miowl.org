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

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="reset">Clear</button>
                <button class="button" type="submit">Create</button>
            </div>

        </form>
	</div>

<?php $this->load->view('template/footer'); ?>
