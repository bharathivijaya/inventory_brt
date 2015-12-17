<h2><?if (empty($drug)){echo 'New';} else {echo 'Edit';}?> Master Drug</h2>

<form action="" method="post" class="narrow " id="drugform">
	<? if (!empty($drug)) {?>
		<input type="hidden" name="id" value="<?=@$drug['id']?>" id="id">
	<?}?>
	<input type="hidden" name="add_new" value="0" id="success_or_new">
	<div class="form-group">
		<label>Name</label>
		<input type="text" name="drugName" value="<?=@$drug['drugName']?>" class="form-control uppercase">
	</div>

	<div class="form-group">
		<label>NDC Code</label>
		<input type="text" name="ndc" value="<?=@$drug['ndc']?>" class="form-control" id="ndc" data-mask="99999-9999-99">
	</div>

	<div class="form-group">
		<label>Description</label>
		<input type="text" name="description" value="<?=@$drug['description']?>" class="form-control uppercase">
	</div>
	<div class="form-group">
		<label>Package Size</label>
		<input type="text" name="packageSize" value="<?=@$drug['packageSize']?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Manufacture</label>
		<input type="text" name="manufacture" value="<?=@$drug['manufacture']?>" class="form-control uppercase" required>
	</div>
	<div class="form-group">
		<label>Schedule</label>
		<select name="schedule" class="form-control">
			<option value="" <?if (empty($drug)){?> selected <?}?>>Select Schedule</option>
			<option value="C1" <?if (@$drug['schedule'] == 'C1'){echo 'selected';}?>>C1</option>
			<option value="C2" <?if (@$drug['schedule'] == 'C2'){echo 'selected';}?>>C2</option>
			<option value="C3" <?if (@$drug['schedule'] == 'C3'){echo 'selected';}?>>C3</option>
			<option value="C4" <?if (@$drug['schedule'] == 'C4'){echo 'selected';}?>>C4</option>
			<option value="C5" <?if (@$drug['schedule'] == 'C5'){echo 'selected';}?>>C5</option>
		</select>
	</div>
	<div class="form-group">
		<label>Barcode</label>
		<input type="text" name="barcode" value="<?=@$drug['barcode']?>" class="form-control uppercase">
	</div>
	
	<div class="form-group">
		<label>Status</label>		
		<?php	
				$drop_extra = ' class="form-control uppercase"';
          		$status_array = array('0'=>"inactive",'1'=>"active");
				echo form_dropdown ( 'status', $status_array, set_value ( 'status',(!empty($drug)? $drug['status'] : 0)  ),$drop_extra);         
		    ?>
	</div>

	<input type="button"  value="Clear" class="btn btn-danger" id="reset">
	<input type="submit" value="Save" class="btn btn-primary" id="save_success">
	<input type="submit"  value="Save & add New" class="btn btn-success" id="save_new">
</form>

<script>
	$('#ndc').keyup(function() {
		$('#drugform').bootstrapValidator('revalidateField', 'd_code');
	})

	$("#reset").click(function() {
		$(this).closest('form').find("input[type=text], textarea, select").val("");
	});

	function applyValidator(){
		$('#drugform').bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			excluded: ':disabled',
			fields: {
				drugName: {
					message: 'drugName can not be empty',
					validators: {
						notEmpty: {
							message: 'drugName is required and cannot be empty'
						}
					}
				},
				ndc: {
					message: 'NDC is not valid',
					validators: {
						notEmpty: {
							message: 'NDC is required and cannot be empty'
						},
						regexp: {
							regexp: /^[0-9-]+$/,
							message: 'NDC should consist of 11 numerical characters'
						}
					}
				},
				packageSize: {
					message: 'packageSize is not valid',
					validators: {
						notEmpty: {
							message: 'packageSize is required and cannot be empty'
						},
						regexp: {
							regexp: /^[0-9]+$/,
							message: 'packageSize can only consist of numerical characters'
						}
					}
				},
				schedule: {
					message: 'Schedule is not valid',
					validators: {
						notEmpty: {
							message: 'Schedule is required and cannot be empty'
						}
					}
				}
			}
		});
	}

	$(document).ready(function() {
		applyValidator();
		$('#save_new').mousedown(function(){
			$('#success_or_new').val(1);
		});
		$('#save_success').mousedown(function(){
			$('#success_or_new').val(0);
		});

	});
</script>