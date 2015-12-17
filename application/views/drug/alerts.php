<h2><?=$drug['d_name']?></h2>

<a href="<?=base_url()?>drug/view_drug/<?=$drug['d_id']?>">Product Info</a> |
<a href="<?=base_url()?>drug/inventory_in/<?=$drug['d_id']?>">Inventory In</a> |
<a href="<?=base_url()?>drug/inventory_out/<?=$drug['d_id']?>">Inventory Out</a> |
<a href="<?=base_url()?>drug/inventory_audit/<?=$drug['d_id']?>">Inventory Audit</a> |
<?//if ($drug["d_lotTracking"]) { ?>
<a href="<?=base_url()?>drug/lots/<?=$drug['d_id']?>">Inventory Lot Tracking</a> |
<?// } ?>
<b>Alert History</b> |
<a href="<?=base_url()?>drug/add_alert/<?=$drug['d_id']?>">Alert Settings</a> |
<a href="<?=base_url()?>category/add_drug_category/<?= $drug['d_id'] ?>">Add Category</a>
<br/><br/>
<table class="table table-striped">
	<thead class="dashboard-headings">
	<tr>
		<td>Type</td>
		<td>ReOrderQty</td>
		<td>Settlement Date</td>
	</tr>
	</thead>
	<tbody>
	<?foreach ($alerts_history as $alert) { ?>
		<tr>
			<td><?= $alert['alertType'] ?></td>
			<td><?= $alert['reOrderQty'] ?></td>
			<td><?= date("m/d/Y", $alert['alert_end']) ?></td>
		</tr>
	<? } ?>
	</tbody>
</table>