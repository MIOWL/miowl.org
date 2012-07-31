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
                        <th>ID</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registration Date</th>
                        <th>Admin</th>
                        <th>Editor</th>
                    </tr>
                </thead>
                <tbody>

<?php
    if($members) :
        foreach($members->result() as $user_row) :
            $row = $this->user_model->get_user_by_id($user_row->user);
?>
                    <tr id="r-<?php print $row->id; ?>">
                        <td><?php print $row->id; ?></td>
                        <td><?php print $row->id == $admin_id ? '<span class="icon_font">Q</span> ' : ''; ?><?php print $row->user_name; ?></td>
                        <td><?php print $row->user_first_name; ?></td>
                        <td><?php print $row->user_last_name; ?></td>
                        <td><?php print date("H:i:s d/m/Y", $row->user_registration_date); ?></td>
                        <td>
                            <center>
                            <?php if($row->user_admin === 'true') : ?>
                                <a href="demote:admin:<?php print $row->id; ?>" style="color:#63b52e !important;" class="userAction icon_font">.</a>
                            <?php else : ?>
                                <a href="promote:admin:<?php print $row->id; ?>" style="color:#FF0000 !important;" class="userAction icon_font">'</a>
                            <?php endif; ?>
                            </center>
                        </td>
                        <td>
                            <center>
                            <?php if($row->user_admin === 'true' || $row->user_editor === 'true') : ?>
                                <a href="demote:editor:<?php print $row->id; ?>" style="color:#63b52e !important;" class="userAction icon_font">.</a>
                            <?php else : ?>
                                <a href="promote:editor:<?php print $row->id; ?>" style="color:#FF0000 !important;" class="userAction icon_font">'</a>
                            <?php endif; ?>
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
            $('.userAction').click(function(e) {
                // prevent the default action, e.g., following a link
                e.preventDefault();

                // get the data from the form
                var data = $(this).attr('href').split(':');

                // what is the action?
                var action = data[0];

                // get the usergroup from the href
                var group = data[1];

                // get the User ID
                var uid = data[2];

                // get the calling element
                var element = $(this);

                // do the dialog function
                userDialog(action, group, uid, element);
            });

            function userDialog(action, group, uid, element) {
                // setup our vars
                var toFrom = 'from',
                    href = 'promote:' + group + ':' + uid,
                    style = 'color:#FF0000 !important',
                    str = "'";

                // are we going from someting or to something
                if (action == 'promote') {
                    toFrom = 'to';
                    href = 'demote:' + group + ':' + uid;
                    style = 'color:#63b52e !important';
                    str = ".";
                }

                // remove the previous dialog box if there is one
                $( "#dialog" ).remove();

                $('<div id="dialog"></div>').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This will ' + action + ' the user ' + toFrom + ' "<strong>' + group.toUpperCase() + '</strong>"?').dialog({
                    title: camesString(action) + ' the user?',
                    autoOpen: true,
                    resizable: false,
                    // height:151,
                    modal: true,
                    buttons: {
                        "Confirm": function() {
                            // close the dialog box
                            $(this).dialog("close");

                            // build the uri
                            var uri = '/owl/members';
                            uri += '/' + action;
                            uri += '/' + group;
                            uri += '-' + uid;

                            // get the JSON data from the request
                            $.getJSON(uri, function(data) {
                                if (data.success == 'true') {
                                    // update the view to reflect this change
                                    element.attr('href', href).attr('style', style).text(str);
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
            }

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
