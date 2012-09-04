<?php
/* <pre><?php print_r($results->result()); ?></pre> */
if($results) :
    foreach($results->result() as $row) :
?>
    <tr id="r-<?php print $row->up_id; ?>">
        <td><a href="<?php print site_url('browse/owl/' . $row->owl_id); ?>"><?php print $row->owl_name; ?></a></td>
        <td><?php print cat_breadcrumb_ul_a($row->cat_id); ?></td>
        <td><?php print $row->file_name; ?></td>
        <td>
            <a href="<?php print trim($row->lic_url); ?>" target="_BLANK"><?php print $row->lic_name; ?></a>
        </td>
        <td><?php print $row->file_type; ?></td>
        <td>
            <a href="<?php print site_url('download/' . $row->up_id); ?>" title="Downlaod this file!" target="_BLANK" class="icon_font">F</a>
        </td>
        <td>
            <a href="<?php print site_url('browse/info/' . $row->up_id); ?>" title="More info for this file!" class="icon_font">,</a>
        </td>
    </tr>
<?php
    endforeach;
endif;
?>
