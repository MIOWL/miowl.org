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

foreach ($root_categories->result() as $cat)
{
    print "- {$cat->id} {$cat->name} <br />";
    
    if (($child = $this->miowl_model->get_owl_categories($this->session->userdata('owl'), TRUE, $cat->id)))
    {
        print "<pre>" .  print_r($child->result(), TRUE) . "</pre>";
        die();
        
        // foreach($child->result() as $child1)
        // {
        //     print "&nbsp;&nbsp;&nbsp;&nbsp; -- {$child1->id} {$child1->name} <br />";

        //     if (($child2 = $this->miowl_model->get_owl_categories($this->session->userdata('owl'), TRUE, $child1->id)))
        //     {
        //         foreach($child2->result() as $child3)
        //         {
        //             print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --- {$child3->id} {$child3->name} <br />";
        //         }
        //     }
        // }
    }

    print "<br />";
}

//print ul($categories_list, $attributes);

?>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
