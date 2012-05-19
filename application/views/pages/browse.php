<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			File Browser
		</center>
	</h1>

	<div id="body">

		<?php print $table; ?>

		<?php
			$this->load->library('pagination');

			$config['base_url'] = $base_url;
			$config['total_rows'] = $total_rows;
			$config['per_page'] = $per_page;

			$this->pagination->initialize($config);

			print $this->pagination->create_links();
		?>

	</div>

<?php $this->load->view('template/footer'); ?>
