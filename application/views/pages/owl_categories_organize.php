<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			OWL Categories Organization Page
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
                            <?php if (is_editor()) : ?>
                                <a style="color:#63b52e !important;" href="<?php print $row->id.':'.$row->parent_id.':'.$row->name; ?>" class="catedit">
                            <?php else : ?>
                                <span style="color:#63b52e !important; opacity: 0.25 !important;">
                            <?php endif; ?>
                                    <img src="/images/icons/edit.gif" title="edit this category" alt="edit" width="16px" height="16px" />
                            <?php
                                print is_editor() ? '</a>' : '</span>';
                            ?>
                        </td>
                        <td>
                            <?php if ($is_in_use) : ?>
                                <span style="color:#FF0000 !important; opacity: 0.25 !important;"><img src="/images/icons/recycle_bin.png" title="cannot remove this category" alt="cannot remove" width="25px" height="25px" /></span>
                            <?php elseif (!is_editor()) : ?>
                                <span style="color:#FF0000 !important; opacity: 0.25 !important;"><img src="/images/icons/recycle_bin.png" title="cannot remove this category" alt="cannot remove" width="25px" height="25px" /></span>
                            <?php else : ?>
                                <a style="color:#FF0000 !important;" href="<?php print $row->id.':'.$row->parent_id.':'.$row->name; ?>" class="del">
                                    <img src="/images/icons/recycle_bin.png" title="remove this category" alt="remove" width="25px" height="25px" />
                                </a>
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
                                    alert('Sorry, you don’t have the authority to change this status.');
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

                // remove the previous dialog box if there is one
                $( "#dialog" ).remove();

                // get the data from the form
                var data = $(this).attr('href').split(':'),
                    cat_id = data[0],
                    cat_pid = data[1],
                    cat_name = data[2],
                    old_uri = $(this).attr('href');

                // get the owl list
                $.get('/owl/categories/select_list/' + cat_pid, function(response) {
                    var select_list = response;

                    // create and load the dialog form
                    $('<div id="dialog"></div>')
                        .html(
                            '<p class="validateTips"> \
                                All form fields are required. \
                            </p> \
                            <fieldset> \
                                <span class="left">Category Name</span>\
                                <input type="text" id="dialog_name" class="text ui-widget-content ui-corner-all right" style="width: 185px;" value="' + cat_name + '" />\
                                <br />\
                                <span class="left">Sub Category of</span>\
                                <select name="subcat" id="dialog_subcat" class="select ui-widget-content ui-corner-all right">\
                                ' + select_list + '\
                                </select>\
                            </fieldset>'
                        )

                        .dialog({
                            title: 'Edit the Category',
                            autoOpen: true,
                            resizable: false,
                            width: 350,
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
                                        id: cat_id,
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
                                            var new_uri = cat_id + ':' + response.subcat + ':' + response.namez;
                                            $('.del', $('#r-' + cat_id)).attr('href', new_uri);
                                            $('.catedit', $('#r-' + cat_id)).attr('href', new_uri);
                                        }
                                        else {
                                            alert('Sorry, you don’t have the authority to change this status.');
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
