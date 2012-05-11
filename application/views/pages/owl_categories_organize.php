<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Categories Organization Page
		</center>
	</h1>

	<div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">

            <div id="default_categories">
                <h2>Default Categories</h2>
                <span class="h2_note">NOTE: these cannot be modified in any way...</span>
                <?php
                    $categories_list = array();
                    $attributes = array(
                                        'id'    => 'default_categories_list'
                                        );
                    foreach ($categories->result() as $row) {
                        if ($row->owl_id === "0") {
                            if($row->parent_id === "0") {
                                // Root Category
                                $categories_list[$row->id] = $row->name;
                            }
                            else {
                                // Sub Category
                                $categories_list[$row->parent_id][$row->id] = $row->name;
                            }
                        }
                    }
                    print ul($categories_list, $attributes);
                ?>
            </div>

            <br><hr><br>

            <div id="custom_categories">
                <h2>Custom Categories</h2>
                <?php
                    $categories_list = array();
                    $attributes = array(
                                        'id'    => 'custom_categories_list'
                                        );
                    foreach ($categories->result() as $row) {
                        if ($row->owl_id != "0") {
                            if($row->parent_id === "0") {
                                // Root Category
                                $categories_list[$row->id] = $row->name;
                            }
                            else {
                                // Sub Category
                                $categories_list[$row->parent_id][$row->id] = $row->name;
                            }
                        }
                    }
                    print ul($categories_list, $attributes);
                ?>
            </div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
