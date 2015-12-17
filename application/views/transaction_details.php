<div  class="row" id="history">
<h2>Transaction Details</h2>
<div class="row" id="table1" style="border:1px solid #357ebd">
  <table class="table table-striped table-hover entry-table" style="border:10px solid #f9f9f9">
    <thead style="font-weight: bold">
      <tr>
        <td>Date/Time Entered</td>
        <td>Transaction Type</td>
        <td>RX/Trans/Invoice #</td>
        <td>Total Quantity <?= $transaction_details[0]['e_type'] == 'new' ? 'In' : 'Out' ?></td>
        <td>Username</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transaction_details as $details) { ?>
      <tr>
        <td><?= date('m-d-Y H:m:s', $details['e_date']);?>
        </td>
        <td><?=$details['e_type'] == 'new' ?'in' : $details['e_type'] ?></td>
        <td><?=$details['e_rx'].$details['e_invoice'];?></td>
        <td><?= $details['e_type'] == 'new' ? $details['total_new_qty'] - $details['total_old_qty'] : $details['e_out_total'];?></td>
        <td><?=$details['username'];?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <table class=" table  table-striped table-hover entry-table">
    <thead style="font-weight: bold">
      <tr>
        <td>NDC</td>
        <td>Drug Name</td>
        <td>Drug Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
        <td>Lot #</td>
        <td>Expiration Date</td>
        <td>Quantity <?= $transaction_details[0]['e_type'] == 'new' ? 'In' : 'Out' ?></td>
        <?= $transaction_details[0]['e_type'] == 'new' ? '<td>Cost/Pack</td>' : '' ?>
        <td>Notes</td>
      </tr>
    </thead>
    
  
    <?php $count = 0; foreach ($drug_details as $drug) { ?>
    <tbody>
    <tr>
      <td><?=$drug->d_code?>
      </td>
      <td><?=$drug->d_name?></td>
      <td><?=$drug->d_descr?></td>
      <td><?=$drug->d_size?></td>
      <td><?=$drug->d_manufacturer?></td>
      <td><?=$drug->e_lot?></td>
      <td><?= $drug->e_expiration == 0 ? '' : date('m-d-Y', $drug->e_expiration);?></td>
      <td><?=$drug->e_out == 0 ? $drug->e_new - $drug->e_old : $drug->e_out ?></td>
      <?= $transaction_details[0]['e_type'] == 'new' ? '<td>'. $drug->e_costPack .'</td>' : '' ?>
      <td><?=$drug->e_note?></td>
      </tr>
      
    </tbody>
    <?php $count++; } ?>
    </tbody>
  </table>
  </div>
  
  <div class="form-group" style="margin-top:10px;">
    <input id="button0" type="submit" value="Reverse Transaction" onclick="confirmDialog('<?php echo $transaction_id; ?>');" class="btn btn-primary"/>      
   <?php if(isset($_POST['rep']) && $_POST['rep']==1) {?> <input  type="submit" value="Back" onclick="backButton(1);" class="btn btn-primary">
   <?php } else {?><input  type="submit" value="Back" onclick="backButton(0);" class="btn btn-primary">
   <?php } ?>
  </div>

<script>
	  
		function confirmDialog(transactionId) {
		
		var result = confirm("Are you sure you want to delete this record?");
		if (result == true)
		window.location = "<?=base_url()?>edit_transaction/reverse_transaction/"+ transactionId;
		else
		return false;	
		}
	
		function backButton(repval) {
			
			if(repval==0)
		window.location = "<?=base_url()?>edit_transaction/index";	
			else
				window.location="<?=base_url()?>report/index";
		}
	
	
</script>
