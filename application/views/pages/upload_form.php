<?php $this->load->view('template/header'); ?>

	<h1>
		<center>
			Upload a new file
		</center>
	</h1>

	<div id="body">

		<?php echo $error;?>

		<?php echo form_open_multipart('upload/do_upload');?>

			<input type="file" name="userfile" size="20" />

			<br /><br />

			<input type="submit" value="upload" />

		</form>

	</div>

<?php $this->load->view('template/footer'); ?>
