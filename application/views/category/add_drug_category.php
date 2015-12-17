<h2><?=$drug['d_name']?></h2>

<a href="<?=base_url()?>drug/view_drug/<?=$drug['d_id']?>">Product Info</a> |
<a href="<?=base_url()?>drug/inventory_in/<?=$drug['d_id']?>">Inventory In</a> |
<a href="<?=base_url()?>drug/inventory_out/<?=$drug['d_id']?>">Inventory Out</a> |
<a href="<?=base_url()?>drug/inventory_audit/<?=$drug['d_id']?>">Inventory Audit</a> |
<?//if ($drug["d_lotTracking"]) { ?>
<a href="<?=base_url()?>drug/lots/<?=$drug['d_id']?>">Inventory Lot Tracking</a> |
<?// } ?>
<a href="<?=base_url()?>drug/alerts/<?=$drug['d_id']?>">Alert History</a> |
<a href="<?=base_url()?>drug/add_alert/<?=$drug['d_id']?>">Alert Settings</a> |
<b>Add Category</b>
<br/><br/>
<form action="" method="post" class="middle" id="catForm">
	<div class="form-group">
		<label>Category Name - <a href="javascript://void()" onclick="copyDrugName();">Copy Drug Name</a></label>
		<input type="text" id="c_name" name="c_name" value="<?= @$cat['c_name'] ?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Description</label>
		<input type="text" name="c_descr" value="<?= @$cat['c_descr'] ?>" class="form-control">
	</div>
	<div class="form-group">
		<label>Parent Category</label>
		<select name="c_mainCatId" class="form-control">
			<option value="0">Select Parent Category</option>
			<?if ($catlist) foreach ($catlist as $cats) { ?>
				<option value="<?= $cats["c_id"] ?>"><?= $cats["c_name"] ?></option>
			<? } ?>
		</select>
	</div>
	<div class="form-group">
		<label>Category Status</label>
		<select name="c_status" class="form-control" required>
			<option value="" <? if (isset($cat)) { ?> selected <? } ?>>Select Status</option>
			<option value="Active" <? if (@$cat['c_status'] == 'Active') { ?> selected <? } ?>>Active</option>
			<option value="Inactive" <? if (@$cat['c_status'] == 'Inactive') { ?> selected <? } ?>>Inactive</option>
		</select>
	</div>

	<!-- <div class="form-group">
		<label>Sub Categories</label>
		<table class="table table-striped" id="myTable">
			<thead class="dashboard-headings">
			<tr>
				<td>Name</td>
				<td>Description</td>
				<td>Remove</td>
			</tr>
			</thead>
			<tbody id="new_subcat">

			</tbody>
		</table>
	</div>-->

	<input type="hidden" name="c_drugId" value="<?= @$d_id ?>">
	<input type="submit" value="Save" class="btn btn-primary">

	<!-- <div class="form-group">
		<button class="btn btn-primary" type="button" onclick="addNewSubcat();">Add new subcat</button>
		<input type="submit" value="Save" class="btn btn-primary">
	</div> -->
</form>

<script>
	/*var lid = 10000000;

	function addNewSubcat()
	{
		lid++;
		$("#new_subcat").append('<tr id="cat_id_' + lid + '">' +
		'<td><input type="hidden" name="cc_id[]"/><input type="text" name="cc_name[]" style="width: 100%;" value="" /></td>' +
		'<td><input type="text" name="cc_descr[]" style="width: 100%;" value=""/></td>' +
		'<td><a href="javascript://void()" onclick="removeSubcat(' + lid + ');">remove</a></td>' +
		'</tr>');
	}*/

	function copyDrugName()
	{
		$("#c_name").val("<?= $drug["d_name"] ?>");
	}

	/*function removeSubcat(id)
	{
		jQuery.ajax({
			type: "POST",
			url: '/category/remove_subcat',
			data: {
				"c_id": id
			},
			cache: false,
			success: function(response){
				$("#cat_id_" + id).remove();
			},
			error: function(response) {

			}
		});
		$("#cat_id_" + id).remove();
	}*/
</script>