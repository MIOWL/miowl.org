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
foreach ($categories->result() as $row) {
    if($row->parent_id === "0") {
        // Root Category
        $categories_list[$row->name] = array();
    }
    else {
        // Sub Category
        $categories_list[$this->miowl_model->get_category($row->parent_id)->name][$row->id] = $row->name;
    }
}

print ul($categories_list, $attributes);

print '<br><pre>' . print_r($categories_list, TRUE) . '</pre>';
print '<br><pre>' . print_r($categories->result_array(), TRUE) . '</pre>';

?>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
