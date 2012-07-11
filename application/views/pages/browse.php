<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			<?php if ((isset($browse_by_owl) && $browse_by_owl) || (isset($browse_by_cat) && $browse_by_cat)) : ?>
                <a href="javascript:history.go(-1)" title="Back to the default browse page"><< back</a> |
            <?php endif; ?>
            <?php print $page_title; ?>
		</center>
	</h1>

	<div id="body">

		<?php /*print $table;*/ ?>
            <table>
                <thead>
                    <tr> <!-- 'Owl', 'Category', 'Filename', 'License', 'File Type', 'Download', 'Info' -->
                        <th>Owl</th>
                        <th>Category</th>
                        <th>Filename</th>
                        <th>License</th>
                        <th>File Type</th>
                        <th>Download</th>
                        <th>Info</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($data) :
        foreach($data->result() as $row) :
            $lic = $this->miowl_model->get_license($row->upload_license);
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><a href="<?php print site_url('browse/owl/' . $row->owl); ?>"><?php print $this->owl_model->get_owl_by_id($row->owl)->row()->owl_name; ?></a></td>
                        <td><?php print cat_breadcrumb_ul($row->upload_category); ?></td>
                        <td><?php print $row->file_name; ?></td>
                        <td><a href="<?php print $lic->row()->url; ?>" target="_BLANK"><?php print $lic->row()->name; ?></a></td>
                        <td><?php print $row->file_type; ?></td>
                        <td><a href="<?php print site_url('download/' . $row->id); ?>" title="Downlaod this file!" target="_BLANK" class="icon_font">F</a></td>
                        <td><a href="<?php print site_url('browse/info/' . $row->id); ?>" title="More info for this file!" class="icon_font">,</a></td>
                    </tr>
<?php
        endforeach;
    endif;
?>

                </tbody>
            </table>

        <!-- pagination -->
        <div class="pagination">
            <center><?php print $this->pagination->create_links(); ?></center>
        </div>

	</div>

<?php $this->load->view('template/footer'); ?>
