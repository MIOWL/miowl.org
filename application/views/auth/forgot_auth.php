<?php $this->load->view('template/header'); ?>

    <h1>
        <center>
            Forgot Password Authorize!
        </center>
    </h1>

    <div id="body">
        <!-- forgot authorization -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">

                <div class="ctrlHolder">
                    <label for="auth_code">Auth Code</label>
                    <input type="text" name="auth_code" id="auth_code" size="medium" class="textInput" value="<?php print ($code ? $code : '') ?>" autocompelete="OFF" />
                    <p class="formHint">Authorization code found in you're email.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" size="medium" class="textInput" autocompelete="OFF" />
                </div>

                <div class="ctrlHolder">
                    <label for="new_password_again">Confirm Password</label>
                    <input type="password" name="new_password_again" id="new_password_again" size="medium" class="textInput" autocompelete="OFF" />
                    <p class="formHint">Retype the above password.</p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="submit">Authorize Request</button>
            </div>

        </form>
    </div>

<?php $this->load->view('template/footer'); ?>
