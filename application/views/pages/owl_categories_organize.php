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

            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>in use?</th>
                        <th>edit</th>
                        <th>remove</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($categories) :
    foreach($categories->result() as $row) :
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print cat_breadcrumb_ul($row->id); ?><?php /*print $row->name;*/ ?></td>
                        <td>
                            <?php if ( $this->cat_model->in_use($row->id) ) : ?>
                                <span style="color:#63b52e !important;" class="icon_font">.</span>
                            <?php else : ?>
                                <span style="color:#FF0000 !important;" class="icon_font">'</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a style="color:#63b52e !important;" href="<?php print $row->id; ?>"><img src="/images/icons/edit.gif" title="edit this category" alt="edit" width="16px" height="16px" /></a>
                        </td>
                        <td>
                            <a style="color:#FF0000 !important;" href="<?php print $row->id; ?>"><img src="/images/icons/recycle_bin.png" title="edit this category" alt="edit" width="20px" height="20px" /></a>
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
