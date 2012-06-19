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
        foreach($members->result() as $row) :
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
                                <a href="demote:admin" style="color:#63b52e !important;" class="userAction icon_font">.</a>
                            <?php else : ?>
                                <a href="promote:admin" style="color:#FF0000 !important;" class="userAction icon_font">'</a>
                            <?php endif; ?>
                            </center>
                        </td>
                        <td>
                            <center>
                            <?php if($row->user_admin === 'true' || $row->user_editor === 'true') : ?>
                                <a href="demote:editor" style="color:#63b52e !important;" class="userAction icon_font">.</a>
                            <?php else : ?>
                                <a href="promote:editor" style="color:#FF0000 !important;" class="userAction icon_font">'</a>
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
                e.preventDefault()

                // get the data from the form
                var data = $(this).attr('href').split(':');

                // what is the action?
                var action = data[0];

                // get the usergroup from the href
                var group = data[1];

                // get the calling element
                var element = $(this);
                alert(element);

                // do the dialog function
                userDialog(action, group, element);
            });

            function userDialog(action, group, element) {
                // are we going from someting or to something
                if(action == 'promote') {
                    var toFrom = 'to';
                } else {
                    var toFrom = 'from';
                }

                $('<div></div>')
                .html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This will ' + action + ' the user ' + toFrom + ' "<strong>' + group.toUpperCase() + '</strong>"?')
                .dialog({
                    title: camesString(action) + ' the user?',
                    autoOpen: true,
                    resizable: false,
                    // height:151,
                    modal: true,
                    buttons: {
                        "Confirm": function() {
                            // close the dialog box
                            $( this ).dialog( "close" );

                            // get the JSON data from the request
                            $.getJSON('search/get_results/type/' + str, function(data) {
                                var input_list = '';
                                $(data.names).each(function(i, name){
                                    input_list += '<input type="checkbox" name="province[]" class="province_list" value="' + name + '" onclick="province_list()" />&nbsp;&nbsp;&nbsp;&nbsp;' + name + '<br />';
                                });
                                input_list += '<span class="save button" onclick="checkAll(\'.province_list\')" > Check All </span><span class="delete button" onclick="uncheckAll(\'.province_list\')" > Uncheck All </span>';
                                $('#province_list').html(input_list);
                            });

                            // alert the user for now
                            alert('user upgraded to ' + group);
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            };

            function camesString(str) {
                str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
                return str
            }
        });
    </script>
    <!-- --------------- -->

<?php $this->load->view('template/footer'); ?>
