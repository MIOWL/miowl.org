<?php $this->load->view('template/header'); ?>

    <h1>Forgot Password!</h1>

    <div id="body">
        <!-- settings -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">
                <div class="ctrlHolder">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" size="35" class="textInput medium" />
                    <p class="formHint">Your current password for security.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" size="35" class="textInput medium" />
                    <p class="formHint">Change your username.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" size="35" class="textInput medium" />
                    <p class="formHint">This must be a valid email, for verification.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="timezone">Timezone</label>
                    <input type="text" name="timezone" id="timezone" size="35" class="textInput medium" />
                    <p class="formHint">Choose your timezone, used throughout the site.</p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="reset">Clear</button>
                <button class="button" type="submit">Register</button>
            </div>

        </form>

        <button class="button" style="width: 788px; float: right;">REMOVE ACCOUNT</button>
    </div>

<?php $this->load->view('template/footer'); ?>
