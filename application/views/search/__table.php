<table>
	<thead>
		<tr>
    		<?php foreach ($array('Owl', 'Category', 'Filename', 'License', 'File Type', 'Download', 'Info') as $title) : ?>
				<th><?php print $title; ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($query->result() as $row) : ?>
			<tr>
				<td>
					<a href="<?php print site_url('browse/owl/' . $row->owl_id); ?>"><?php print $row->owl_name; ?></a>
				</td>
				<td>
					<?php print $row()->cat_name; ?>
				</td>
				<td>
					<?php print $row->file_name; ?>
				</td>
				<td>
					<a href="<?php print $row->lic_url; ?>"><?php print $row->lic_name; ?></a>
				</td>
				<td>
					<?php print $row->file_type; ?>
				</td>
				<td>
					<a href="<?php print site_url('browse/owl/' . $row->up_id); ?>" title="Downlaod this file!" target="_BLANK" class="icon_font">F</a>
				</td>
				<td>
					<a href="<?php print site_url('browse/owl/' . $row->up_id); ?>" title="More info for this file!" class="icon_font">,</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
