<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Owl Members
		</center>
	</h1>

	<div id="body">
		<?php
		
        $this->load->library('table');
        $tmpl = array (
                            'table_open'          => '<table width="100%" cellspacing="0" cellpadding="4" border="1">',

                            'heading_row_start'   => '<tr>',
                            'heading_row_end'     => '</tr>',
                            'heading_cell_start'  => '<th>',
                            'heading_cell_end'    => '</th>',

                            'row_start'           => '<tr>',
                            'row_end'             => '</tr>',
                            'cell_start'          => '<td>',
                            'cell_end'            => '</td>',

                            'row_alt_start'       => '<tr>',
                            'row_alt_end'         => '</tr>',
                            'cell_alt_start'      => '<td>',
                            'cell_alt_end'        => '</td>',

                            'table_close'         => '</table>'
                      );
        $this->table->set_template($tmpl);
        $this->table->set_heading('ID', 'Username', 'First Name', 'Last Name', 'Registration Date', 'Admin?', 'Uploader?', 'Approve', 'Deny');
        $this->table->set_empty("N/A");

        if($members)
        {
            foreach($members->result() as $row)
            {
                $registration_date = date("H:i:s d/m/Y", $row->user_registration_date);
                $this->table->add_row(
                    $row->id,
                    $row->user_name,
                    $row->user_first_name,
                    $row->user_last_name,
                    $registration_date,
                    '<center><span class="icon_font">U</span></center>',
                    '<center><span class="icon_font">U</span></center>',
                    '<center><span style="color:#63b52e" class="icon_font">.</span></center>',
                    '<center><span style="color:#FF0000" class="icon_font">\'</span></center>'
                );
            }
        }

		print $this->table->generate();

		?>
	</div>

<?php $this->load->view('template/footer'); ?>
