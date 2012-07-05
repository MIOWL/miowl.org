<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Upload a new file
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
                        <label for="name">Name <span class="right">(required)</span></label>
                        <input type="text" name="filename" id="filename" size="35" class="textInput large" value="<?php print set_value('name'); ?>" placeholder="BSD" />
                        <p class="formHint">Enter the License name</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="description">Description <span class="right">(optional)</span></label>
                        <textarea name="description" id="description" size="35" class="textInput large" rows="5" cols="50" placeholder="The BSD 3 Clause License"><?php print trim(set_value('description')); ?></textarea>
                        <p class="formHint">Enter a description for the License.</p>
                    </div>

                    <div class="ctrlHolder">
                        <label for="license">License File <span class="right">(required)</span></label>
                        <div name="license" id="license-tabs">
                            <ul>
                                <li><a href="#tabs-url">External URL to License File</a></li>
                                <li><a href="#tabs-upload">Upload a License for a local copy</a></li>
                            </ul>
                            <div id="lic-url">
                                <p>http://www.opensource.org/licenses/BSD-3-Clause</p>
                            </div>
                            <div id="lic-upload">
                                <input type="file" name="userfile" id="userfile" size="35" class="textInput large" />
                                <p>Choose the file you want to upload. Must be <strong><?php print $allow_types; ?></strong></p>
                            </div>
                        </div>
                        <p class="formHint">Enter license URL or choose the license file to upload.</p>
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
            $( "#license-tabs" ).tabs({
                cookie: {
                    // store cookie for a day, without, it would be a session cookie
                    expires: 1
                }
            });
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
