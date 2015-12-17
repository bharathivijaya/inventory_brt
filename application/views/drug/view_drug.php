<h2><?=$drug['d_name']?></h2>

<b>Product Info</b> |
<a href="<?=base_url()?>drug/inventory_in/<?=$drug['d_id']?>">Inventory IN</a> |
<a href="<?=base_url()?>drug/inventory_out/<?=$drug['d_id']?>">Inventory Out</a> |
<a href="<?=base_url()?>drug/inventory_audit/<?=$drug['d_id']?>">Inventory Audit</a> |
<?//if ($drug["d_lotTracking"]) { ?>
<a href="<?=base_url()?>drug/lots/<?=$drug['d_id']?>">Inventory Lot Tracking</a> |
<?// } ?>
<a href="<?=base_url()?>drug/alerts/<?=$drug['d_id']?>">Alert History</a> |
<a href="<?=base_url()?>drug/add_alert/<?=$drug['d_id']?>">Alert Settings</a>
<!--<a href="<?/*=base_url()*/?>category/add_drug_category/<?/*= $drug['d_id'] */?>">Add Category</a>-->

<br/>
<br/>

<table class="table table-striped">
	<thead class="dashboard-headings">
		<tr>
			<td>Name</td>
			<td>NDC Code</td>
			<td>Description</td>
			<td>Package Size</td>
			<td>Manufacturer</td>
			<td>Schedule</td>
			<td>Barcode</td>
			<td>Status</td>
			<td>Category</td>
            <td></td>
		</tr>
    </thead>
    <tbody>
		<tr>
			<td><?= $drug['d_name'] ?></td>
			<td><?= $drug['d_code'] ?></td>
			<td><?= $drug['d_descr'] ?></td>
			<td><?= $drug['d_size'] ?></td>
			<td><?= $drug['d_manufacturer'] ?></td>
			<td><?= $drug['d_schedule'] ?></td>
			<td><?= $drug['d_barcode'] ?></td>
			<td><?if ($drug['d_status'] == 1) { echo 'Active'; } else { echo 'Inactive'; } ?></td>
			<td><?
				$drugCatsList = array();
				foreach ($drugCats as $drugInfo) array_push($drugCatsList, $drugInfo["c_name"]);
				echo implode(",", $drugCatsList);

				?></td>
            <td><a href="<?=base_url()?>drug/add_drug/<?= $drug['d_id'] ?>">Edit</a></td>
		</tr>
    </tbody>
</table>


