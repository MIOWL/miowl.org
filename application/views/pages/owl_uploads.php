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
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Filename</th>
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
                    <tr id="r-<?php print $row->id; ?>" class="<?php if( time() >= $row->revision_date ) print 'review'; ?>">
                        <td><?php print cat_breadcrumb_ul($row->upload_category); ?></td>
                        <td><?php print $row->file_name; ?></td>
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
                            <a href="<?php print $row->id; ?>" title="Delete this file!" target="_BLANK" id="remove_<?php print $row->id; ?>" class="remove"><img src="/images/icons/recycle_bin.png" title="Delete this file!" alt="remove" width="25px" height="25px" /></a>
                        </td>
                    </tr>
<?php if( time() >= $row->revision_date ) : ?>
                <div class="reviewTip">
                    <div class="arrow_box">
                        <span class="content">
                            css arrow please!
                        </span>
                    </div>
                </div>
<?php endif;
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
        <div class="clear">&nbsp;</div>
	</div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {
            function reviewHighlight() {
                $('.review').effect("highlight", {}, 3000);
            }

            setInterval(reviewHighlight, 500);
            reviewHighlight();
        });
    </script>
    <!-- --------------- -->

    <!-- Page CSS -->
    <style type="text/css">

        .reviewTip {
            width: 0px;
            position: relative;
            top: 12px;
            left: 25px;
        }

        .arrow_box .content {
          /*width: 50px;
          height: 50px;*/
          display: block;
          color: #DDF8C6;
          font-size: 12px;
          text-align: center;
          vertical-align: middle;
          font-weight: bold;
          text-shadow: 0 1px 1px rgba(0, 0, 0, 0.4);
          font-family: 'Dosis',sans-serif;
        }

        .arrow_box {
          display: block;
          top: 40px;
          left: 500px;
            position: relative;
            background: #88b7d5;
            border: 0px solid #c2e1f5;
          width: 150px;
          /*height; 188px;*/
        }
        .arrow_box:after, .arrow_box:before {
            right: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .arrow_box:after {
            border-right-color: #88b7d5;
            border-width: 7px;
            top: 50%;
            margin-top: -7px;
        }
        .arrow_box:before {
            top: 50%;
            margin-top: -7.5px;
        }

    </style>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
