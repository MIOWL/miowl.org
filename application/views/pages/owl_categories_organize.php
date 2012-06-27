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
                            <a style="color:#63b52e !important;" href="<?php print $row->id.':'.$row->parent_id.':'.$row->name; ?>" class="catedit"><img src="/images/icons/edit.gif" title="edit this category" alt="edit" width="16px" height="16px" /></a>
                        </td>
                        <td>
                            <?php if ($is_in_use) : ?>
                                <span style="color:#FF0000 !important; opacity: 0.25 !important;"><img src="/images/icons/recycle_bin.png" title="cannot remove this category" alt="cannot remove" width="25px" height="25px" /></span>
                            <?php else : ?>
                                <a style="color:#FF0000 !important;" href="<?php print $row->id.':'.$row->parent_id.':'.$row->name; ?>" class="del"><img src="/images/icons/recycle_bin.png" title="remove this category" alt="remove" width="25px" height="25px" /></a>
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
            $('.del').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault();

                // get the data from the form
                var data = $(this).attr('href').split(':'),
                    cat_id = data[0],
                    cat_pid = data[1],
                    cat_name = data[2];

                // setup and load the dialog box
                $('<div></div>').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This will delete the category <strong>' + cat_name + '</strong>').dialog({
                    title: 'delete this category?',
                    autoOpen: true,
                    resizable: false,
                    modal: true,
                    buttons: {
                        "Confirm": function() {
                            // close the dialog box
                            $(this).dialog("close");

                            // build the uri
                            var uri = '/owl/categories/remove/' + cat_id;

                            // get the JSON data from the request
                            $.getJSON(uri, function(data) {
                                if (data.success == 'true') {
                                    // update the view to reflect this change
                                    $('#r-' + cat_id).fadeOut('slow', function() {
                                        $('#r-' + cat_id).empty();
                                    });
                                }
                                else {
                                    alert('Sorry, an error has occured. Please report this to the site admin.');
                                }
                            });
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });
        });

        $(function() {
            $('.catedit').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault();

                // get the data from the form
                var data = $(this).attr('href').split(':'),
                    cat_id = data[0],
                    cat_pid = data[1],
                    cat_name = data[2];

                $.get('/owl/categories/select_list/' + cat_pid, function(response) {
                    var select_list = response;

                    // create and load the dialog form
                    $('<div></div>').html('<p class="validateTips">All form fields are required.</p><form><fieldset><label for="name">Category Name</label><input type="text" name="name" id="dialog_name" class="text ui-widget-content ui-corner-all" value="' + cat_name + '" /><label for="subcat">Sub Category</label><select name="subcat" id="dialog_subcat" class="select ui-widget-content ui-corner-all">' + select_list + 'M/select></fieldset></form>').dialog({
                        title: 'Edit the Category',
                        autoOpen: true,
                        resizable: false,
                        width: 300,
                        modal: true,
                        buttons: {
                            "Edit": function() {
                                var name = $("#dialog_name"),
                                    subcat = $("#dialog_subcat"),
                                    allFields = $([]).add(name).add(subcat);

                                allFields.removeClass("ui-state-error");

                                // build the uri
                                var uri = '/owl/members';

                                // get the JSON data from the request
                                $.post('/owl/categories/edit/', {
                                    name: name.val(),
                                    subcat: subcat.val()
                                },
                                function(response) {
                                    // was the edit a success?
                                    if (response.success) {
                                        // get the new breadcrumb
                                        $.get('/owl/categories/breadcrumb/' + cat_id, function(data) {
                                            // var breadcrumb = response;
                                            $('td:first', $('#r-' + cat_id)).html(data);
                                        }, "html");

                                        // update the href to reflect this change
                                        $(this).attr('href', cat_id + ':' + response.subcat + ':' + response.name);
                                    }
                                    else {
                                        alert('Sorry, an error has occured. Please report this to the site admin.');
                                    }
                                }, "json");

                                // close the dialog box
                                $(this).dialog("close");
                            },
                            Cancel: function() {
                                $(this).dialog("close");
                            }
                        },
                        close: function() {
                            var name = $("#dialog_name"),
                                subcat = $("#dialog_subcat"),
                                allFields = $([]).add(name).add(subcat);

                            allFields.val("").removeClass("ui-state-error");
                        }
                    });
                },
                "html");
            });
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
