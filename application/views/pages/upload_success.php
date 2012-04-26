<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Your file was successfully uploaded!
		</center>
	</h1>

	<div id="body">

		<ul>
            <li>upload_user: <?php print $this->session->userdata('username'); ?></li>
            <li>owl: <?php print $this->session->userdata('owl'); ?></li>
            <li>file_name: <?php print is_null($this->input->post('filename')) ? $upload_data['file_name'] : $this->input->post('filename'); ?></li>
            <li>full_path: <?php print $upload_data['full_path']; ?></li>
            <li>upload_catagory: <?php print $this->input->post('catagory'); ?></li>
            <li>file_type: <?php print $upload_data['file_type']; ?></li>
            <li>client_name: <?php print $upload_data['client_name']; ?></li>
            <li>file_size: <?php print $upload_data['file_size']; ?></li>
            <li>file_ext: <?php print $upload_data['file_ext']; ?></li>
            <li>description: <?php print str_replace(array("\r\n","\r","\n"), '\n',trim($this->input->post('description'))); ?></li>
        </ul>

        <br>
        <hr>
        <br>

		<ul>
			<?php foreach ($upload_data as $item => $value):?>
				<li><?php echo $item;?>: <?php echo $value;?></li>
			<?php endforeach; ?>
		</ul>

		<p>
			<?php echo anchor('upload', 'Upload Another File!'); ?>
		</p>

	</div>

<?php $this->load->view('template/footer'); ?>
