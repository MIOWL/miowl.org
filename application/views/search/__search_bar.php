<form action="<?php print site_url('search'); ?>" method="post" id="search_bar" class="right" style="position:relative;top:-40px;display:block">
	<input type="text" name="keyword" class="textInput medium" value="<?php print isset($keyword) ? $keyword : 'Search...'; ?>" onfocus="if (this.value == 'Search...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search...';}">
	<input type="button" class="button" value="GO">
</form>