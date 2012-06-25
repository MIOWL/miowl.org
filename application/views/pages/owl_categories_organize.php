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

            <!--
            <div id="categories_list">
                <h2>Categories</h2>
                <?php print ul(gen_categories(), array('id' => 'categories')) ?>
            </div>
            -->

            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>edit</th>
                        <th>remove</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($members) :
    foreach($categories->result() as $row) :
        $edit = $remove = 'todo';
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print $row->name; ?></td>
                        <td>
                            <center>
                                <a style="color:#63b52e !important;" class="icon_font" href="<?php print $row->id; ?>">.</a>
                            </center>
                        </td>
                        <td>
                            <center>
                                <a style="color:#FF0000 !important;" class="icon_font" href="<?php print $row->id; ?>">'</a>
                            </center>
                        </td>
                    </tr>
<?php
    endforeach;
    endif;
?>

                </tbody>
            </table>

        </div>
        <div class="clear">&nbsp;</div>
    </div>

<?php $this->load->view('template/footer'); ?>
