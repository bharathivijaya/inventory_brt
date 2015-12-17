<style>table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after { 
    content: " \25B4\25BE" 
}</style><script type="text/javascript" src="<?php echo base_url();?>assets/js/sortable.js"></script>
<h2><?=$drug['d_name']?></h2>

<a href="<?=base_url()?>drug/view_drug/<?=$drug['d_id']?>">Product Info</a> |
<a href="<?=base_url()?>drug/inventory_in/<?=$drug['d_id']?>">Inventory In</a> |
<b>Inventory OUT</b> |
<a href="<?=base_url()?>drug/inventory_audit/<?=$drug['d_id']?>">Inventory Audit</a> |
<a href="<?=base_url()?>drug/alerts/<?=$drug['d_id']?>">Alert History</a> |
<?//if ($drug["d_lotTracking"]) { ?>
<a href="<?=base_url()?>drug/lots/<?=$drug['d_id']?>">Inventory Lot Tracking</a> |
<?// } ?>
<a href="<?=base_url()?>drug/add_alert/<?=$drug['d_id']?>">Alert Settings</a> <!--|
<a href="<?=base_url()?>category/add_drug_category/<?= $drug['d_id'] ?>">Add Category</a>-->

<br/><br/>
<table  >
<tr ><td><form name="searchform" id="searchform" method="post" action=""><input type="text" name="searchfield" id="searchfield" placeholder="Enter Rx/Transaction # or Lot #"></td><td><input type="submit" value="Search" class="btn btn-xs btn-primary"  name="submit"></form></td></tr>
	<br>
</table>
<table  class="table table-striped sortable">
	<thead class="dashboard-headings">
	<tr>
		<th>Date Entered <!--<form name="datesortform" id="datesortform" method="post" action="">
		   <select name="dateview" id="dateview" onchange="this.form.submit()"><? if(isset($_POST['dateview'] ) && $_POST['dateview']!="") {?>
		   <option value="<?php echo $_POST['dateview'];?>"><?php echo $_POST['dateview'];?></option>
		   <? } ?>
		   <option value="" disabled>Select</option>
		    <option value="desc">desc</option>
		   <option value="asc">asc</option>
		 
		   </select>--></th>
		<td>RX/Transaction #</td>
		<td>Quantity Out</td>
		<td>Lot Number</td>
		<td>Expiration Date</td>
		<td>Quantity on Hand</td>
		<td>Actions</td>
	</tr>
	</thead>
	<tbody>
	<?foreach ($inventory_out as $entry) { ?>
		<tr>
			<td><?= date("m/d/Y", $entry['e_date']) ?></td>
			<td><?= $entry['e_rx'] ?></td>
			<td><?= $entry['e_out'] ?></td>
			<td><?= $entry['e_lot'] ?></td>
			<td><? if (!empty($entry['e_lot'])) echo date("m/d/Y", $entry['expirationDate']) ?></td>
			<td><?= $entry['e_new'] ?></td>
				<td><a href="<?php echo base_url();?>edit_transaction/transaction_details/<?php echo $entry['e_id']; ?>"><input type="button"   value="View/Edit Transaction" class="btn btn-xs btn-primary" ></a></td>
		</tr>
	<? } ?>
	</tbody>
</table>
