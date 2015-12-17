<h2>Category List</h2>

<table class="table table-striped" id="myTable">
    <thead>
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Description</td>
			<td>Status</td>
			<td>Parent Category</td>
			<td></td>
		</tr>
    </thead>
    <tbody>
		<?foreach ($cats as $one) {?>
		<tr>
			<td><?= $one['c_localId'] ?></td>
			<td><a href="<?=base_url()?>category/view_category/<?=$one['c_id']?>"><?=$one['c_name']?></a></td>
			<td><?= $one['c_descr'] ?></td>
			<td><?= $one['c_status'] ?></td>
			<td><?= $one['parent_cat_name'] ?$one['parent_cat_name'] :"-" ?></td>
			<td><a href="<?= base_url() ?>category/add_category/<?=$one['c_id']?>">Edit</a></td>
		</tr>
		<?}?>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#myTable').DataTable({"aoColumnDefs": [
        ]});
        //$('#myTable_filter').find('input').addClass('form-control');
        $('#myTable_filter').after('<div id="after_filter"><a href="<?=base_url()?>category/add_category" class="btn btn-warning" style="line-height: 0.9">New category</a></div>');
    });
</script>