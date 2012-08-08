<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			OWL Member Invite
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <form action="" class="uniForm" method="post">

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">
                    <div class="ctrlHolder">
                        <label for="name">Invitee Name <span class="right">(required)</span></label>
                        <input type="text" name="name" id="name" size="35" class="textInput large" autocompelete="OFF" value="<?php print set_value('name'); ?>" />
                        <p class="formHint">This is the name of the person you are wanting to invite.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="email">Invitee Email <span class="right">(required)</span></label>
                        <input type="text" name="email" id="email" size="35" class="textInput large" autocompelete="OFF" value="<?php print set_value('email'); ?>" />
                        <p class="formHint">This is the email address of the person you are wanting to invite.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="msg">Message <span class="right">(optional)</span></label>
                        <textarea name="msg" id="msg" size="35" class="textInput large" rows="5" cols="50"><?php print trim(set_value('msg')); ?></textarea>
                        <p class="formHint">Just a quick message to be attached to the invite email.</p>
                    </div>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="reset">Clear</button>
                    <button class="button" type="submit">Send</button>
                </div>

            </form>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
