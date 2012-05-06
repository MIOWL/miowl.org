<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Members
		</center>
	</h1>

    <div id="body">
        <div id="owl_nav" class="column left quarter">
            <?php $this->load->view('pages/owl_nav'); ?>
        </div>
        <div id="owl_body" class="column right threequarter">
            <table cellspacing="0" cellpadding="4" border="1" width="100%">
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
                        <td><?php print $this->session->userdata('admin') ? '<span class="icon_font">Q</span> ' : ''; ?><?php print $row->user_name; ?></td>
                        <td><?php print $row->user_first_name; ?></td>
                        <td><?php print $row->user_last_name; ?></td>
                        <td><?php print date("H:i:s d/m/Y", $row->user_registration_date); ?></td>
                        <td>
                            <center>
                            <?php if($this->session->userdata('admin')) : ?>
                                <span style="color:#63b52e !important;" class="icon_font">.</span>
                            <?php else : ?>
                                <span style="color:#FF0000 !important;" class="icon_font">'</span>
                            <?php endif; ?>
                            </center>
                        </td>
                        <td>
                            <center>
                            <?php if($this->session->userdata('admin') || $this->session->userdata('editor')) : ?>
                                <span style="color:#63b52e !important;" class="icon_font">.</span>
                            <?php else : ?>
                                <span style="color:#FF0000 !important;" class="icon_font">'</span>
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

<?php $this->load->view('template/footer'); ?>
