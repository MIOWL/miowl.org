<?php $this->load->view('template/header'); ?>

	<h1>Forgot Password!</h1>

	<div id="body">
        <!-- forgot password -->
        <form action="" class="uniForm" method="post">

            <?php $this->load->view('messages/message_inline'); ?>

            <fieldset class="inlineLabels">
                <div class="ctrlHolder">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" size="35" class="textInput medium" />
                    <p class="formHint">You can also use your email address if you have forgotten your username!</p>
                </div>
            </fieldset>

            <div class="buttonHolder">
                <button class="button" type="reset">Clear</button>
                <button class="button" type="submit">Request</button>
            </div>

        </form>
	</div>

<?php $this->load->view('template/footer'); ?>
