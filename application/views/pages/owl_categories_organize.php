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

            <div id="categories_list">
                <h2>Categories</h2>
                <?php print ul(gen_categories(), array('id' => 'categories')) ?>
            </div>

            <?php
                    $this->load->library('table');
                    $tmpl = array (
                        'table_open'          => '<table>',

                        'heading_row_start'   => '<tr>',
                        'heading_row_end'     => '</tr>',
                        'heading_cell_start'  => '<th>',
                        'heading_cell_end'    => '</th>',

                        'row_start'           => '<tr>',
                        'row_end'             => '</tr>',
                        'cell_start'          => '<td>',
                        'cell_end'            => '</td>',

                        'row_alt_start'       => '<tr>',
                        'row_alt_end'         => '</tr>',
                        'cell_alt_start'      => '<td>',
                        'cell_alt_end'        => '</td>',

                        'table_close'         => '</table>'
                    );
                    $this->table->set_template($tmpl);
                    $this->table->set_heading('name', 'edit', 'remove');
                    $this->table->set_empty("N/A");

                    foreach($categories->result() as $row)
                    {
                        $edit = $remove = 'todo';
                        $this->table->add_row   (
                            $row->name,
                            $edit,
                            $remove
                        );
                    }

                    $output = $this->table->generate();

                    print $output;
            ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registration Date</th>
                        <th>Approve</th>
                        <th>Deny</th>
                    </tr>
                </thead>
                <tbody>

<?php /*
    if($members) :
    foreach($members->result() as $row) :
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print $row->id; ?></td>
                        <td><?php print $row->user_name; ?></td>
                        <td><?php print $row->user_first_name; ?></td>
                        <td><?php print $row->user_last_name; ?></td>
                        <td><?php print date("H:i:s d/m/Y", $row->user_registration_date); ?></td>
                        <td>
                            <center>
                                <a style="color:#63b52e !important;" class="icon_font approve" href="<?php print $row->id; ?>">.</a>
                            </center>
                        </td>
                        <td>
                            <center>
                                <a style="color:#FF0000 !important;" class="icon_font deny" href="<?php print $row->id; ?>">'</a>
                            </center>
                        </td>
                    </tr>
<?php
    endforeach;
    endif;
*/ ?>

                </tbody>
            </table>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
