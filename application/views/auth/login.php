<?php $this->load->view('template/header'); ?>

    <h1>
        <center>
            Login Page!
        </center>
    </h1>

	<div id="body">
        <!-- login -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">

                <div class="ctrlHolder">
                    <label for="username">Username / Email</label>
                    <input type="text" name="username" id="username" size="35" class="textInput medium" value="<?php print set_value('username'); ?>" />
                    <p class="formHint">Don't have a username? <a href="<?php print site_url('user/register'); ?>">Sign up</a> today!</p>
                </div>

                <div class="ctrlHolder">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" size="35" class="textInput medium" />
                    <p class="formHint">Forgot your password? <a href="<?php print site_url('user/forgot'); ?>">Click here</a> to reset it.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="chkbox">Keep me logged in</label>
                    <input type="checkbox" name="chkbox" id="chkbox" />
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="reset">Clear</button>
                <button class="button" type="submit">Login</button>
            </div>

        </form>
    </div>

<?php $this->load->view('template/footer'); ?>
