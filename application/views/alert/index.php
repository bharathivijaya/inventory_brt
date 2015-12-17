<h2>Alert Manager</h2>
<h3>Alerts</h3>
<?php if ($this->session->flashdata('success') == TRUE){ ?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
<?php }; ?>

<table class="table table-striped" id="myTable">
	<thead class="dashboard-headings">
	<tr>
		<td>Alert Type</td>
		<td>Status</td>
		<td>Product Name</td>
		<td>Product NDC</td>

		<td>Audit Frequency</td>
		<td>Audit Start Date</td>
		<td>Audit Time</td>

		<td>Audit End Date</td>
		<td>Qty on Hand</td>
		<td>Re-order Qty</td>

		<td>Alert Actions</td>
	</tr>
	</thead>
	<tbody>
	<? /*foreach ($alerts as $alert) {?>
		<tr>
			<td><?= $alert['alertType'] ?></td>
			<td><? $arr = ["Inactive", "Active"]; echo $arr[$alert['alertStatus']]; ?></td>
			<td><?
				if (@$alert["drugsData"]) foreach ($alert["drugsData"] as $drug)
				{
					echo $drug["d_name"]."<br />";
				}
				?></td>
			<td><?
				if (@$alert["drugsData"]) foreach ($alert["drugsData"] as $drug)
				{
					echo $drug["d_code"]."<br />";
				}
				?></td>

			<td><? if ($alert['alertType'] == "Audit") echo $alert['auditFrequency']." days"; else echo "-"; ?></td>
			<td><? if ($alert['alertType'] == "Audit") echo date("m/d/Y", $alert['auditStartDate']); else echo "-"; ?></td>
			<td><? if ($alert['alertType'] == "Audit") echo $alert['auditTime']; else echo "-"; ?></td>
			<td><? if ($alert['alertType'] == "Audit" && $alert["auditEndDate"] > 0)
					echo date("m/d/Y", $alert['auditEndDate']); else echo "-"; ?></td>
			<td>
				<?
				if (@$alert["drugsData"]) foreach ($alert["drugsData"] as $drug)
				{
					echo $drug["d_onHand"]."<br />";
				}
				?>
			</td>
			<td><? if ($alert['alertType'] == "Inventory") echo $alert['reOrderQty']; else echo "-"; ?></td>
			<td><a href="/alert/edit/<?= @$alert["id"] ?>">View / Edit</a>&nbsp; <a href="/alert/delete/<?php echo @$alert["id"]; ?>" onClick="return confirm('Are you sure you want to delete this record?')">Delete</a></td>
		</tr>
	<?} */?>
	<?php foreach ($alert_list as $alert) {
		$drug_details = $this->alertm->get_my_drug_details_from_id($alert->drug_id);
		
		$drug_name = '';
		$drug_code = '';
		$drug_on_hand = '';
		foreach ($drug_details as $drug) {
			$drug_name = $drug->d_name;
			$drug_code = $drug->d_code;
			$drug_on_hand = $drug->d_onHand;
		}
		?>
			<tr>
			<td><?php echo $alert->alertType; ?></td>
			<td><?php echo ($alert->alertStatus == '1'? 'Active':'Inactive');?></td>
			<td><?php echo $drug_name;?></td>
			<td><?php echo $drug_code;?></td>
	
			<td><?php echo ($alert->alertType == "Audit"?  $alert->auditFrequency:'-');?></td>
			<td><?php echo ($alert->alertType == "Audit"?  date("m/d/Y", $alert->auditStartDate):'-');?></td>
			<td><?php echo ($alert->alertType == "Audit"?  $alert->auditTime:'-');?></td>
	
			<td><?php echo (($alert->alertType == "Audit" && $alert->auditEndDate > 0 )?  date("m/d/Y", $alert->auditEndDate):'-');?></td>
			<td><?php echo $drug_on_hand;?></td>
			<td><?php echo ($alert->alertType == "Inventory"?  $alert->reOrderQty:'-');?></td>
	
			<td><a href="/alert/edit/<?php echo $alert->id; ?>">View / Edit</a>&nbsp; <a href="/alert/delete/<?php echo  $alert->id; ?>/<?php echo $alert->drug_id;?>" onClick="return confirm('Are you sure you want to delete this record?')">Delete</a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>


<script>
	$(document).ready(function(){
		$('#myTable').DataTable({"aoColumnDefs": [
			{ "sWidth": "100px", "aTargets": [1] },
			{ "sWidth": "100px", "aTargets": [2] }
		]});
        $('#myTable_filter').after('<div id="after_filter"><a href="<?=base_url()?>alert/add" class="btn btn-warning" style="line-height: 0.9">New Alert</a></div>');
	});
</script>