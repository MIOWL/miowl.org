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

                    <pre><?php print_r($searchOptions); ?></pre>

                    <?php foreach ($searchOptions as $name => $description) : ?>
                        <div class="ctrlHolder">
                            <label for="<?php print $name; ?>">$description</label>
                            <div class="<?php print $name; ?>Image"></div>
                            <input type="checkbox" name="<?php print $name; ?>" id="<?php print $name; ?>" class="<?php print $name; ?>" autocompelete="OFF" style="display: none" />
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
