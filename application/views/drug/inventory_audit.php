<style>table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after { 
    content: " \25B4\25BE" 
}</style><script type="text/javascript" src="<?php echo base_url();?>assets/js/sortable.js"></script>
<h2><?=$drug['d_name']?></h2>

<a href="<?=base_url()?>drug/view_drug/<?=$drug['d_id']?>">Product Info</a> |
<a href="<?=base_url()?>drug/inventory_in/<?=$drug['d_id']?>">Inventory In</a> |
<a href="<?=base_url()?>drug/inventory_out/<?=$drug['d_id']?>">Inventory Out</a> |
<b>Inventory Audit</b> |
<?//if ($drug["d_lotTracking"]) { ?>
<a href="<?=base_url()?>drug/lots/<?=$drug['d_id']?>">Inventory Lot Tracking</a> |
<?// } ?>
<a href="<?=base_url()?>drug/alerts/<?=$drug['d_id']?>">Alert History</a> |
<a href="<?=base_url()?>drug/add_alert/<?=$drug['d_id']?>">Alert Settings</a><!--|
<a href="<?=base_url()?>category/add_drug_category/<?= $drug['d_id'] ?>">Add Category</a>-->
<br/><br/>
<table  >
<tr ><td><form name="searchform" id="searchform" method="post" action=""><input type="text" name="searchfield" id="searchfield" placeholder="Enter Rx/Transaction # or Lot #"></td><td><input type="submit" value="Search" class="btn btn-xs btn-primary"  name="submit"></form></td></tr>
	<br>
</table>
<table class="table table-striped sortable">
	<thead class="dashboard-headings">
	<tr>
		<th>Date Entered</th>
		<td>Expected Quantity on Hand</td>
		<td>Actual Quantity on Hand</td>
		<td>Variance</td>
		<td>User Name</td>
		<td>Actions</td>
	</tr>
	</thead>
	<tbody>
	<?foreach ($inventory_audit as $entry) { ?>
		<tr>
			<td><?= date("m/d/Y", $entry['e_date']) ?></td>
			<td><?= $entry['e_old'] ?></td>
			<td><?= $entry['e_new'] ?></td>
			<td><?= $entry['e_new'] - $entry['e_old'] ?></td>
			<td><?=$entry['username']?></td>
						<td>	<a href="<?php echo base_url();?>edit_transaction/transaction_details/<?php echo $entry['e_id']; ?>"><input type="button"   value="View/Edit Transaction" class="btn btn-xs btn-primary" ></a></td>
		</tr>
	<? } ?>
	</tbody>
</table>