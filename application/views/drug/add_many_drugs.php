<form action="/drug/save_many_drugs" id="drugForm" method="post"><div class="row" id="table3">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>NDC</th>
				<th>Description</th>
				<th>Package Size</th>
				<th>Manufacturer</th>
				<th>Starting Inventory in Units</th>
				<th>Schedule</th>
				<th>Barcode</th>
				<th>Status</th>
				<th>Category</th>
			</tr>
		</thead>
		<tbody>
		<?foreach ($drugs as $drug) { ?>
			<tr>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" name="d_name[]" required="" value="<?= $drug["drugName"] ?>"/>
					</div>
				</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control d_code" data-mask="99999-9999-99" name="d_code[]" value="<?= $drug["ndc"] ?>"/>
					</div>
				</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" name="d_descr[]" value="<?= $drug["description"] ?>"/>
					</div>
				</td>
				<td style="width: 50px;" >
					<div class="form-group">
						<input type="text" class="form-control" name="d_size[]" value="<?= $drug["packageSize"] ?>"/>
					</div>
				</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" name="d_manufacturer[]" value="<?= $drug["manufacture"] ?>"/>
					</div>
				</td>
				<td style="width: 50px;">
					<div class="form-group" >
						<input type="text" class="form-control" name="d_start[]" value="0"/>
					</div>
				</td>
				<td>
					<div class="form-group">
						<select class="form-control" name="d_schedule[]">
							<? $sch = array("C1", "C2", "C3", "C4", "C5", "Legend", "OTC"); ?>
							<? for ($i = 0; $i < count($sch); $i++)
							{
							    echo '<option value="'.$sch[$i].'" '.(($drug["schedule"] == $sch[$i]) ?"selected" :"").'>'.$sch[$i].'</option>';
							}
							?>
						</select>
					</div>
				</td>
				<td style="width: 100px;">
					<div class="form-group">
						<input type="text" class="form-control" name="d_barcode[]" value="<?= $drug["barcode"] ?>"/>
					</div>
				</td>
				<td>
					<div class="form-group">
						<select class="form-control" name="d_status[]">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</td>
				<td>
					<div class="form-group">
						<select class="form-control" name="d_catId[]">
                            <option value="">No Category</option>
							<?foreach ($cats as $cat) { ?>
								<option value="<?= $cat["c_id"] ?>"><?= $cat["c_name"] ?></option>
							<? } ?>
						</select>
					</div>
				</td>
			</tr>
		<? } ?>
		</tbody>
	</table>
	<button type="submit" class="btn btn-success">Save</button>
	</div>
</form>

<script>
	$(document).ready(function() {
		applyValidator();
	});

	$('.d_code').keyup(function() {
		$('#drugForm').bootstrapValidator('revalidateField', 'd_code[]');
	});

	function applyValidator()
	{
		$('#drugForm').bootstrapValidator({
			framework: 'bootstrap',
			err: {
				container: 'tooltip'
			},
			row: {
				selector: 'td'
			},
			icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				'd_name[]': {
					message: 'Name can not be empty',
					validators: {
						notEmpty: {
							message: 'Name is required and cannot be empty'
						}
					}
				},
				'd_code[]': {
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
				'd_size[]': {
					message: 'Size is not valid',
					validators: {
						notEmpty: {
							message: 'Size is required and cannot be empty'
						},
						regexp: {
							regexp: /^[0-9]+$/,
							message: 'Size can only consist of numerical characters'
						}
					}
				},
				'd_start[]': {
					message: 'Starting Inventory is not valid',
					validators: {
						notEmpty: {
							message: 'Starting Inventory is required and cannot be empty'
						},
						regexp: {
							regexp: /^[0-9]+$/,
							message: 'Size can only consist of numerical characters'
						}
					}
				}
			}
		});
	}
</script>