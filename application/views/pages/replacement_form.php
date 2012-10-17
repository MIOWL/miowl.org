<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Upload a replacement file
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <!-- upload -->
            <?php echo form_open_multipart('', array('class' => 'uniForm'));?>

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">

                    <div class="ctrlHolder">
                        <label for="userfile">File <span class="right">(required)</span></label>
                        <input type="file" name="userfile" id="userfile" size="35" class="textInput large" />
                        <p class="formHint">Choose the file you want to upload. Must be <strong><?php print $allow_types; ?></strong></p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="reason">Reason for replacement <span class="right">(required)</span></label>
                        <textarea name="reason" id="reason" size="35" class="textInput large" rows="5" cols="50" maxlength="255"><?php print trim(set_value('reason')); ?></textarea>
                        <div id="reason-chars" style="margin-left: 34%; text-align: right; padding-right: 10px;">Loading...</div>
                        <p class="formHint">Enter a reason for the file change. Maximum character count is 255.</p>
                    </div>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="submit">Upload</button>
                </div>

            </form>

        </div>
        <div class="clear">&nbsp;</div>
	</div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {
            // jQuery Limit counter
            $("#reason").limiter($("#reason-chars"));
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
