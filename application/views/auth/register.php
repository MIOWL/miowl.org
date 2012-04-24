<?php $this->load->view('template/header'); ?>

	<h1>Registration Page!</h1>

	<div id="body">
        <!-- register -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">
                <div class="ctrlHolder">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" size="35" class="textInput medium" autocompelete="OFF" />
                    <p class="formHint">Pick a username.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" size="35" class="textInput medium" autocompelete="OFF" />
                </div>

                <div class="ctrlHolder">
                    <label for="password_again">Password again</label>
                    <input type="password" name="password_again" id="password_again" size="35" class="textInput medium" autocompelete="OFF" />
                    <p class="formHint">Retype the above password.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" size="35" class="textInput medium" autocompelete="OFF" />
                    <p class="formHint">This must be a valid email, for verification.</p>
                </div>

                <div class="ctrlHolder">
                    <label for="spamcheck">The URI of this website.</label>
                    <input type="text" name="spamcheck" id="spamcheck" size="35" class="textInput medium" autocompelete="OFF" />
                    <p class="formHint">type &ldquo;???&rdquo; into this box.</p>
                </div>

            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="reset">Clear</button>
                <button class="button" type="submit">Register</button>
            </div>

        </form>
	</div>

<?php $this->load->view('template/footer'); ?>
