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
            <th>Created</th>
            <th>Modified</th>
            <th>Status</th>
			<th>Action</th>
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
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>

<div class="modal fade" id="delConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Remove this drug?</h4>
			</div>
			<div class="modal-body" >
				Are you sure you want to delete this drug?
			</div>
			<div class="modal-footer">
				<input type="hidden" id="delId">
				<button type="button" class="btn btn-danger" id="del" data-dismiss="modal">Remove</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#myTable').dataTable({
			"ajax": '<?php echo base_url();?>drug/getMasterFileData/admin/',
			"processing": true,
			"serverSide": true,
			"cache": false,
			"dom": '<"toolbar">frtip'

		});

		$('#myTable_filter').after('<div id="after_filter"><a href="<?=base_url()?>drug/add_master_drug" class="btn btn-warning" style="line-height: 0.9">New drug</a> &nbsp;<a href="<?php echo base_url()?>admin/bulk_upload" class="btn btn-warning" style="line-height: 0.9">Bulk Upload</a>&nbsp;<a href="<?php echo base_url()?>admin/download_csv" class="btn btn-warning" style="line-height: 0.9">Download CSV</a></div>');

		$('#del').click(function(event){
			var id = $('#delId').val();
			window.location = "/drug/removeMasterDrugFileByID/" + id;
		});
	});

	function openModal(id){
		$('#delId').val(id);
		$('#delConfirm').modal();
	}
</script>