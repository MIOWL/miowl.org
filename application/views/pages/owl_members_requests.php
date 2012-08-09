<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			OWL Member Requests
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
                        <th>ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registration Date</th>
                        <th>Approve</th>
                        <th>Deny</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($members) :
    foreach($members->result() as $user_row) :
            $row = $this->user_model->get_user_by_id($user_row->user)->row();
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print $row->id; ?></td>
                        <td><?php print $row->user_name; ?></td>
                        <td><?php print $row->user_first_name; ?></td>
                        <td><?php print $row->user_last_name; ?></td>
                        <td><?php print date("H:i:s d/m/Y", $row->user_registration_date); ?></td>
                        <td>
                            <center>
                                <a style="color:#63b52e !important;" class="icon_font approve" href="<?php print $row->id; ?>">.</a>
                            </center>
                        </td>
                        <td>
                            <center>
                                <a style="color:#FF0000 !important;" class="icon_font deny" href="<?php print $row->id; ?>">'</a>
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

    <!-- Page Javascript -->
    <script type="text/javascript">
        $(function() {
            $('.approve').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault();

                // remove the previous dialog box if there is one
                $( "#dialog" ).remove();

                // get the data from the form
                var id = $(this).attr('href');

                $('<div id="dialog"></div>').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This will approve the user into your owl!').dialog({
                    title: 'Approve this user?',
                    autoOpen: true,
                    resizable: false,
                    // height:151,
                    modal: true,
                    buttons: {
                        "Confirm": function() {
                            // close the dialog box
                            $(this).dialog("close");

                            $.ajax({
                                type: 'GET',
                                url: '/owl/members/accept/' + id,
                                dataType: 'text',
                                success: function(response) {
                                    if (response == "1") {
                                        $('#r-' + id).slideUp('slow', function() {
                                            $('#r-' + id).empty();
                                        });
                                    }
                                }
                            });
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            })

            $('.deny').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault();

                // remove the previous dialog box if there is one
                $( "#dialog" ).remove();

                // get the data from the form
                var id = $(this).attr('href');

                $('<div id="dialog"></div>').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This will deny the user into your owl!').dialog({
                    title: 'Deny this user?',
                    autoOpen: true,
                    resizable: false,
                    // height:151,
                    modal: true,
                    buttons: {
                        "Confirm": function() {
                            // close the dialog box
                            $(this).dialog("close");

                            $.ajax({
                                type: 'GET',
                                url: '/owl/members/deny/' + id,
                                dataType: 'text',
                                success: function(response) {
                                    if (response == "1") {
                                        $('#r-' + id).slideUp('slow', function() {
                                            $('#r-' + id).empty();
                                        });
                                    }
                                }
                            });
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            })

            function camesString(str) {
                str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
                return str;
            }
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
