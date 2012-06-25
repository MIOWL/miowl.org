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
        $is_in_use = $this->cat_model->in_use($row->id);
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print cat_breadcrumb_ul($row->id); ?><?php /*print $row->name;*/ ?></td>
                        <td>
                            <?php if ( $is_in_use ) : ?>
                                <span style="color:#63b52e !important;" class="icon_font">.</span>
                            <?php else : ?>
                                <span style="color:#FF0000 !important;" class="icon_font">'</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a style="color:#63b52e !important;" href="<?php print $row->id; ?>"><img src="/images/icons/edit.gif" title="edit this category" alt="edit" width="16px" height="16px" /></a>
                        </td>
                        <td>
                            <?php if ($is_in_use) : ?>
                                <span style="color:#FF0000 !important; opacity: 0.25 !important;"><img src="/images/icons/recycle_bin.png" title="cannot remove this category" alt="cannot remove" width="25px" height="25px" /></span>
                            <?php else : ?>
                                <a style="color:#FF0000 !important;" href="<?php print $row->id; ?>" class="delete"><img src="/images/icons/recycle_bin.png" title="remove this category" alt="remove" width="25px" height="25px" /></a>
                            <?php endif; ?>
                        </td>
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
        <div class="clear">&nbsp;</div>
    </div>

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {
            $('.delete').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault()

                // get the data from the form
                var id = $(this).attr('href');

                // setup and load the dialog box
                $('<div></div>')
                .html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This will delete the category')
                .dialog({
                    title: 'delete the category?',
                    autoOpen: true,
                    resizable: false,
                    modal: true,
                    buttons: {
                        "Confirm": function() {
                            // close the dialog box
                            $( this ).dialog( "close" );

                            // build the uri
                            var uri = '/owl/categories/remove/' + id;

                            // get the JSON data from the request
                            $.getJSON(uri, function(data) {
                                if( data.success == 'true' ) {
                                    // update the view to reflect this change
                                    $('#r-' + id).hide();
                                }
                                else {
                                    alert('Sorry, an error has occured. Please report this to the site admin.');
                                }
                            });
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            });
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
