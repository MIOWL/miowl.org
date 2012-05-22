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

$cat_array = NULL;

// get our root categories
if (($roots = $this->cat_model->get_roots()))
{
    foreach ($roots->result() as $root)
    {
        $cat_array[$root->name] = array();

        // child this roots children
        if (($kids = $this->cat_model->get_children($root->id)))
        {
            foreach ($kids->result() as $child)
            {
                $cat_array[$root->name][$child->name] = array();

                // get our childs children
                if (($kids_kids = $this->cat_model->get_children($child->id)))
                {
                    foreach ($kids_kids->result() as $childs_childs)
                    {
                        $cat_array[$root->name][$child->name][$childs_childs->name] = array();
                    }
                }
            }
        }
    }
}

print ul($cat_array, $attributes);

?>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
