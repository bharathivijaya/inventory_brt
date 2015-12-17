<h2>Bulk Uploading Drugs</h2>
<?php if ($this->session->flashdata('success') == TRUE){ ?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php }; ?>
<?php
	$this->form_validation->set_error_delimiters ( '<div class="alert alert-danger" role="alert">', '</div>' );
	echo validation_errors ();
?>
<form method="post" action="<?php echo base_url() ?>admin/bulk_upload" enctype="multipart/form-data">
	<input type="file" name="csv_file"> <br> <br> <input type="submit"
		name="submit" value="UPLOAD" class="btn btn-primary">
</form>