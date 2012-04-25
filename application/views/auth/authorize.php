<?php $this->load->view('template/header'); ?>

    <h1>
        <center>
            User Account Authorize!
        </center>
    </h1>

    <div id="body">
        <!-- authorize -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">

                <div class="ctrlHolder">
                    <label for="auth_code">Auth Code</label>
                    <input type="text" name="auth_code" id="auth_code" size="medium" class="textInput" value="<?php print ($code ? $code : '') ?>" />
                    <p class="formHint">Authorization code found in you're email.</p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="submit">Authorize Account</button>
            </div>

        </form>
    </div>

<?php $this->load->view('template/footer'); ?>
