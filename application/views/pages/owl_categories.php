<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Categories
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

<?php

$categories_list = array();
$attributes = array('id' => 'categories');
/*
// This is fucked!!!
foreach ($categories->result() as $row) {
    if($row->parent_id === "0") {
        // Root Category
        $categories_list[$row->name] = array();
    }
    else {
        // Sub Category
        $categories_list[$row->parent_id][$row->id] = $row->name;
    }
}
*/
foreach ($categories->result() as $row) {
    if($row->parent_id === "0") {
        // Root Category
        $categories_list[] = $row->name;
    }
}
#print ul($categories->result_array(), $attributes);
print ul($categories_list, $attributes);

?>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
