<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php print $page_title; ?>
		</center>
	</h1>

    <div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">
            <table cellspacing="0" cellpadding="4" border="1" width="100%" class="txt_center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Timestamp (GMT)</th>
                        <th>Filename</th>
                        <th>Category</th>
                        <th>License</th>
                        <th>File Type</th>
                        <th>Download</th>
                        <th>Info</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($uploads) :
        foreach($uploads->result() as $row) :
            $lic = $this->miowl_model->get_license($row->upload_license);
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print $row->id; ?></td>
                        <td><?php print date("H:i:s d/m/Y", $row->upload_time); ?></td>
                        <td><?php print $row->file_name; ?></td>
                        <td><?php print $this->miowl_model->get_category($row->upload_category)->row()->name; ?></td>
                        <td>
                            <a href="<?php print $lic->row()->url; ?>" target="_BLANK">
                                <?php print $lic->row()->name; ?>
                            </a>
                        </td>
                        <td><?php print $row->file_type; ?></td>
                        <td>
                            <a href="<?php print site_url('download/' . $row->id); ?>" title="Downlaod this file!" target="_BLANK" class="icon_font">F</a>
                        </td>
                        <td>
                            <a href="<?php print site_url('browse/info/' . $row->id); ?>" title="More info for this file!" target="_BLANK" class="icon_font">,</a>
                        </td>
                        <td>
                            <a href="<?php print $row->id; ?>" title="Delete this file!" target="_BLANK" id="remove_<?php print $row->id; ?>" class="icon_font remove">'</a>
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