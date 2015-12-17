<h2><?if (empty($cat)){?>New Category<?} else {echo 'Edit '.@$cat['c_name'];}?></h2>
<!--
<div class="row">
    <h3>Category info</h3>
</div>
-->
<form action="" method="post" class="middle" id="catForm">
    <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="c_name" value="<?=@$cat['c_name']?>" class="form-control" required="">
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" name="c_descr" value="<?=@$cat['c_descr']?>" class="form-control">
    </div>

	<div class="form-group">
		<label>Parent Category</label>
		<select name="c_mainCatId" class="form-control">
			<option value="0">Select Parent Category</option>
			<?if ($catlist) foreach ($catlist as $cats) { ?>
			<option value="<?= $cats["c_id"] ?>" <? if (@isset($cat) && $cats["c_id"] == $cat["c_mainCatId"]) echo "selected"; ?>><?= $cats["c_name"] ?></option>
			<? } ?>
		</select>
	</div>

    <div class="form-group">
        <label>Category Status</label>
        <select name="c_status" class="form-control" required>
            <option value="" <?if (isset($cat)) { ?> selected <? } ?>>Select Status</option>
            <option value="Active" <?if (@$cat['c_status'] == 'Active') { ?> selected <? } ?>>Active</option>
            <option value="Inactive" <?if (@$cat['c_status'] == 'Inactive') { ?> selected <? } ?>>Inactive</option>
        </select>
    </div>

	<!--<div class="form-group">
		<label>Sub Categories</label>
		<table class="table table-striped" id="myTable">
			<thead class="dashboard-headings">
			<tr>
				<td>Name</td>
				<td>Description</td>
				<? if (!isset($cat)) { ?><td>Remove</td><? } ?>
			</tr>
			</thead>
			<tbody id="new_subcat">
				<?if (@$catlist) foreach ($catlist as $cats) { ?>
					<tr id="cat_id_<?= $cats["c_id"] ?>">
						<td>
							<input type="hidden" name="cc_id[]" value="<?= $cats["c_id"] ?>" />
							<input type="text" name="cc_name[]" style="width: 100%;" value="<?= $cats["c_name"] ?>"/>
						</td>
						<td><input type="text" name="cc_descr[]" style="width: 100%;" value="<?= $cats["c_descr"] ?>"/></td>
						<? if (!isset($cat)) { ?><td><a href="javascript://void()" onclick="removeSubcat(<?= $cats["c_id"] ?>);">remove</a></td><? } ?>
					</tr>
				<? } ?>
			</tbody>
		</table>
	</div>-->

	<input type="submit" value="Save" class="btn btn-primary">

    <!--<div class="form-group">
		<? if (!isset($cat)) { ?>
			<button class="btn btn-primary" type="button" onclick="addNewSubcat();">Add new subcat</button>
		<? } ?>
        <input type="submit" value="Save" class="btn btn-primary">
    </div>-->
    <!--<button type="button" class="btn btn-danger" onclick="window.location = '<?=base_url()?>admin/admins'">Cancel</button>-->
</form>

<? if (false) { ?>
<form action="/category/save_subcats/<?= $cat['c_id'] ?>" method="post" class="middle">
	<h3>Sub Categories</h3>
	<table class="table table-striped" id="myTable">
		<thead class="dashboard-headings">
			<tr>
				<td>Name</td>
				<td>Description</td>
				<td>Remove</td>
			</tr>
		</thead>
		<tbody id="new_subcat">
		<?foreach ($catlist as $cats) { ?>
			<tr id="cat_id_<?= $cats["c_id"] ?>">
				<td>
					<input type="hidden" name="c_id[]" value="<?= $cats["c_id"] ?>" />
					<input type="text" name="c_name[]" style="width: 100%;" value="<?= $cats["c_name"] ?>"/>
				</td>
				<td><input type="text" name="c_descr[]" style="width: 100%;" value="<?= $cats["c_descr"] ?>"/></td>
				<td><a href="javascript://void()" onclick="removeSubcat(<?= $cats["c_id"] ?>);">remove</a></td>
			</tr>
		<? } ?>
		</tbody>
	</table>
	<button class="btn btn-primary" type="button" onclick="addNewSubcat();">Add new subcat</button>
	<button class="btn btn-success" type="submit">Save</button>
</form>
<? } ?>

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
	}

	function removeSubcat(id)
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
