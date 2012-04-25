<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Your file was successfully uploaded!
		</center>
	</h1>

	<div id="body">

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
