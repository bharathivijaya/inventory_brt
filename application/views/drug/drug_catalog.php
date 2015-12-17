<form action="/drug/add_many_drugs" method="post">
	<input type="hidden" name="drug_list" id="drug_list"/>
    <a href="<?=base_url()?>drug/upload" class="btn btn-info">Bulk upload</a>
    <a href="<?=base_url()?>drug/add_drug" class="btn btn-info">Create New Drug</a>

    <button id="copy_to_my_catalog" class="btn btn-primary" style="float:right" disabled>Copy to My Catalog</button>
</form>
<br/><br/>
<table class="table table-striped" id="myTable">
	<thead>
	<tr>
		<th>Name</th>
		<th>NDC</th>
		<th>Description</th>
		<th>Package Size</th>

		<th>Manufacturer</th>
		<th>Schedule</th>
		<th>Barcode</th>
		<th>Select</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>

		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		var table = $('#myTable').dataTable({
			"ajax": '<?php echo base_url();?>drug/getMasterFileData/user/',
			"processing": true,
			"serverSide": true
		});

		table.on('draw.dt', function()
		{
			updateCheckboxes();
		});
	});

	/*function setAllCheckbox()
	{
		$("input[data-info=drug]").each(function(index)
		{
			var id = $(this).attr("data-id") * 1;

			if ($("#all_checkbox").prop("checked")) checkbox_list[id] = true;
			else delete checkbox_list[id];
		});
	}*/

	function updateButtons()
	{
		if (Object.keys(checkbox_list).length <= 0) $("#copy_to_my_catalog").attr("disabled", true);
		else $("#copy_to_my_catalog").removeAttr("disabled");
	}

	function updateCheckboxes()
	{
		$("input[data-info=drug]").each(function(index)
		{
			var id = $(this).attr("data-id") * 1;

			if (checkbox_list[id]) $(this).attr("checked", "true");
		});

		updateButtons();
	}

	function setCheckBox(id)
	{
		if ($("#drug_" + id).prop("checked")) checkbox_list[id] = true;
		else delete checkbox_list[id];

		var chlist = [];
		for (var cid in checkbox_list) chlist.push(cid);
		$("#drug_list").val(chlist.join(","));

		updateButtons();
	}

	var checkbox_list = {};
</script>