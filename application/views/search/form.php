<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">
        <div id="search_nav" class="column left quarter">
            <?php $this->load->view('search/_nav'); ?>
        </div>
        <div id="search_body" class="column right threequarter">

            <!-- Search Form -->
            <form action="" class="uniForm" method="post">

                <?php $this->load->view('messages/message_inline'); ?>

                <fieldset class="inlineLabels">

                    <div class="ctrlHolder">
                        <label for="keyword">Keyword</label>
                        <input type="text" name="keyword" id="keyword" size="35" class="textInput medium" autocompelete="OFF" value="<?php print set_value('keyword'); ?>" />
                    </div>

                    <?php foreach ($search_vars as $name => $description) : ?>
                        <div class="ctrlHolder">
                            <label for="<?php print $name; ?>"><?php print $description; ?></label>
                            <div class="<?php print $name; ?>Image"></div>
                            <div class="<?php print $name; ?>" style="display: none;" >
                                <input type="checkbox" name="<?php print $name; ?>1" id="<?php print $name; ?>1" class="<?php print $name; ?>1" autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $description; ?>
                                <br />
                                <input type="checkbox" name="<?php print $name; ?>2" id="<?php print $name; ?>2" class="<?php print $name; ?>2" autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $description; ?>
                                <br />
                                <input type="checkbox" name="<?php print $name; ?>3" id="<?php print $name; ?>3" class="<?php print $name; ?>3" autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $description; ?>
                                <br />
                                <input type="checkbox" name="<?php print $name; ?>4" id="<?php print $name; ?>4" class="<?php print $name; ?>4" autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $description; ?>
                                <br />
                                <input type="checkbox" name="<?php print $name; ?>5" id="<?php print $name; ?>5" class="<?php print $name; ?>5" autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $description; ?>
                                <br />
                                <input type="checkbox" name="<?php print $name; ?>6" id="<?php print $name; ?>6" class="<?php print $name; ?>6" autocompelete="OFF" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<?php print $description; ?>
                                <br />
                            </div>
                        </div>
                    <?php endforeach; ?>

                </fieldset>

                <div class="buttonHolder">
                    <button class="button" type="reset">Clear</button>
                    <button class="button" type="submit">Search</button>
                </div>

            </form>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
