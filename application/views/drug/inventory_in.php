<style>table.sortable th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after { 
    content: " \25B4\25BE" 
}</style><script type="text/javascript" src="<?php echo base_url();?>assets/js/sortable.js"></script>
<table><tr><td><h2><?=$drug['d_name']?></h2></td><td style="padding-left:30px;padding-top:25px;"><font size="2">Quantity On Hand: <?=$drug['d_onHand']?></font></td></tr></table>

<a href="<?=base_url()?>drug/view_drug/<?=$drug['d_id']?>">Product Info</a> |
<b>Inventory IN</b> |
<a href="<?=base_url()?>drug/inventory_out/<?=$drug['d_id']?>">Inventory Out</a> |
<a href="<?=base_url()?>drug/inventory_audit/<?=$drug['d_id']?>">Inventory Audit</a> |
<?//if ($drug["d_lotTracking"]) { ?>
<a href="<?=base_url()?>drug/lots/<?=$drug['d_id']?>">Inventory Lot Tracking</a> |
<?// } ?>
<a href="<?=base_url()?>drug/alerts/<?=$drug['d_id']?>">Alert History</a> |
<a href="<?=base_url()?>drug/add_alert/<?=$drug['d_id']?>">Alert Settings</a> <!--|
<a href="<?=base_url()?>category/add_drug_category/<?= $drug['d_id'] ?>">Add Category</a>-->
<br/><br/>
<b>Starting Inventory in Units: </b><?= $drug['d_start'] ?>
<br/><br/>
<table  >
<tr ><td><form name="searchform" id="searchform" method="post" action=""><input type="text" name="searchfield" id="searchfield" placeholder="Enter Invoice # or Lot #"></td><td><input type="submit" value="Search" class="btn btn-xs btn-primary"  name="submit"></form></td></tr>
	<br>
</table>
<table class="table table-striped sortable">
	<thead class="dashboard-headings">
		<tr>
			<th>Date Entered</th>
			<td>Date Edited</td>
			<td>Vendor</td>
			<td>RX/Trans/Invoice #</td>
			<td>Quantity IN</td>
			<td></td>
			<td>Lot Number (Lot Qty)</td>
			<td>Expiration Date</td>
			<td>Cost/Pk</td>
			<td>Cost/Unit</td>
				<td>Ext. Cost</td>
			<td>Quantity Remaining</td>
			<td>Actions</td>
		</tr>
	</thead>
	<tbody>
	<? setlocale(LC_MONETARY, 'en_US.UTF-8');$checkrx="";foreach ($inventory_in as $entry) { ?>
	 <?php if($checkrx!=$entry->e_rx.$entry->e_invoice ) {?>
		<tr>
			<td><?= date("m/d/Y", $entry->e_date) ?></td>
			<td><?php if($entry->e_last_edit_date==0) echo ''; else echo date("m/d/Y",$entry->e_last_edit_date); ?></td>
			<td><?= $entry->v_name ?></td>
			<td><?= $entry->e_invoice ?><?= $entry->e_rx ?></td>
			<td><?= $entry->e_new - $entry->e_old ?></td>
			<td></td>
		  <td><?php echo str_replace(',','<br>',$entry->total_lots)?></td>
        <td><?php echo str_replace(',','<br>',$entry->e_expiration); ?></td>
			<td><?= money_format('%.2n',$entry->e_costPack) ?></td>
			<td><?=  money_format('%.2n',round($entry->e_costPack / $drug['d_size'], 2)) ?></td>
			<td><?=  money_format('%.2n',round($entry->e_costPack / $drug['d_size'], 2)*($entry->e_new-$entry->e_old)) ?></td>
		
			<td><?= $entry->total_new_qty ?></td>
										<td><a href="<?php echo base_url();?>edit_transaction/edit_entry_in/<?php echo str_replace(',','-',$entry->total_entry_ids); ?>"><input type="button"   value="View/Edit Transaction" class="btn btn-xs btn-primary" ></a></td>
		</tr>
 <?php } $checkrx=$entry->e_rx.$entry->e_invoice;
       }?>
	</tbody>
</table>
