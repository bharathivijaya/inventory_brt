<!-- Original Transaction -->
<div id="detaildiv" style="display:none;">
<?php echo "<table width=\"100%\"><tr><td>*** THIS TRANSACTION HAS BEEN DELETED ***</td></tr>";
echo "<tr><td align=\"right\">Report Created On:".date('m-d-Y H:m', time())."</td></tr>";
echo "<tr><td align=\"right\">Deleted By:".$original_transaction[0]->username."</td></tr>";
//echo "<br>";
//echo "Deleted on:".$original_transaction[0]->e_datedeleted;
echo "</tr></table>";
?>
</div>
<div   id="history">
<div id="show_hide" data-toggle="collapse" data-target="#history_row">
  <h3> Transaction Details -  Original Entry</h3>
</div>
<div class="row in" id="history_row">
  <table class="table table-striped  entry-table" style="border:1px solid #f9f9f9;margin-top:0px;margin-bottom:0px;">
    <thead style="font-weight: bold">
      <tr>
        <td>Date/Time Entered</td>
        <td>Transaction Type</td>
        <td>RX/Trans/Invoice #</td>
        <td>Total Quantity <?= $original_transaction[0]->e_type == 'new' ? 'IN' : 'OUT' ?></td>
        <td>Username</td>
		  <td>Deleted By</td>
		  <td>Deleted On</td>
      </tr>
    </thead>
    <tbody>
      
      <tr>
        <td><?= date('m-d-Y H:m:s', $original_transaction[0]->e_date);?>
        </td>
        <td>Deleted <?= $original_transaction[0]->e_type == 'new' ?'IN' : strtoupper($original_transaction[0]->e_type )?></td>
        <td><?= $original_transaction[0]->e_rx.$original_transaction[0]->e_invoice;?></td>
        <td><?= $original_transaction[0]->e_type == 'new' ? $original_transaction[0]->total_new_qty - $original_transaction[0]->total_old_qty : $original_transaction[0]->e_out_total;?></td>
        <td><?=$original_transaction[0]->username;?></td>
		<td><?=$original_transaction[0]->username;?></td>
		<td><?=date('m-d-Y H:m:s', $original_transaction[0]->e_deleteddate);?></td>
      </tr>      
    </tbody>
  </table>
  <table class="table table-striped table-hover entry-table" style="border:1px solid #f9f9f9;margin-top:0px;margin-bottom:0px;">
    <thead style="font-weight: bold">
      <tr>
        <td>NDC</td>
        <td>Drug Name</td>
        <td>Drug Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
        <td>Lot #</td>
        <td>Expiration Date</td>
        <td>Quantity <?= $original_transaction[0]->e_type == 'new' ? 'IN' : 'Out' ?></td>
        <?= $original_transaction[0]->e_type == 'new' ? '<td>Cost/Pack</td>' : '' ?>
        <td>Notes</td>
      </tr>
    </thead>
    
  <tbody>
    <?php $count = 0; foreach ($all_drugs as $drugs) { ?>
    <tr>
      <td><?=$drugs->d_code?>
      </td>
      <td><?=$drugs->d_name?></td>
      <td><?=$drugs->d_descr?></td>
      <td><?=$drugs->d_size?></td>
      <td><?=$drugs->d_manufacturer?></td>
      <td><?=$drugs->e_lot?></td>
      <td><?=$drugs->e_expiration == 0 ? '' : date('m-d-Y', $drugs->e_expiration);?></td>
      <td><?=$drugs->e_out == 0 ? $drugs->e_new - $drugs->e_old : $drugs->e_out ?></td>
      <?= $original_transaction[0]->e_type == 'new' ? '<td>'. $drugs->e_costPack .'</td>' : '' ?>

      <td><?=$drugs->e_note?></td>
      </tr>
    <?php $count++; } ?>
    </tbody>

  </table>
  </div>
  <?php
  $noofgroups=0;$chkid='';$grpids[]="";$k=1;
  foreach ($transaction_history as $entry) { 

	  if($entry->e_transaction_group_id !=$chkid) { $grpids[$k]=$entry->e_transaction_group_id;$totalqty =0;$noofgroups=$noofgroups+1;$k++;}
	  $chkid=$entry->e_transaction_group_id;
	 
}

for($n=1;$n<sizeof($grpids);$n++) {

$totalqty=0;
foreach ($transaction_history as $entry) {
	if($entry->e_transaction_group_id == $grpids[$n])
		$totalqty =$totalqty+ $entry->e_out;
}
$qtyarr[$n]=$totalqty;
}

  ?>
  <?php if(isset($transaction_history)) { ?>
<div  class="row" id="history" style="" >
<h3> Related Transactions - Edited Entries</h3>
  <table class="table  table-hover dt-responsive"  style="width:100%;border:0px solid #FFFFFF;margin-top:0px;margin-bottom:0px;" cellspacing="0" id="transTable">

      <?php $totalqtycal=0;
	  
	  $tran_group_id =''; $i=0;foreach ($transaction_history as $entry) { ?>
	  
	     <?php if( $tran_group_id != $entry->e_transaction_group_id) {$i++;?>   <?php if($i%2==1) { ?><table class="table"  style="width:100%;border:1px solid orange;margin-top:5px;margin-bottom:5px;background-color:#e8e8ff;" cellspacing="0" > <?php } else {?><table class="table"  style="width:100%;border:1px solid orange;margin-top:5px;margin-bottom:5px;background-color:#EEEEEE;" cellspacing="0" ><?php } ?>
		 <thead style="font-weight: bold">
		 <tr style="border-top:3px solid red;"> <td colspan=12></td></tr>
      <tr >
        <td colspan=2>Date/Time Entered</td>
        <td colspan=2>Transaction Type</td>
        <td colspan=2>RX/Trans/Invoice #</td>
        <td colspan=3>Total Quantity <?= $original_transaction[0]->e_type == 'new' ? 'In' : 'Out (Edit)' ?></td>
        <td colspan=2>Username</td><td>Date Deleted</td>
		 <!--<td colspan=1>Edit Status</td>-->
      </tr>
    </thead> <tbody>  <tr >
        <td colspan=2><?= date('m-d-Y H:m:s', $entry->e_last_edit_date);?>
        </td>
        <td colspan=2> <?php if($entry->e_type == 'edit') 
			{
		  echo "DELETED ";
			echo $entry->e_out == 0 ? "IN (".strtoupper($entry->e_type).")" : "OUT (".strtoupper($entry->e_type).")";  
			} 
			else 
			{ 
				echo "DELETED ";
			echo $entry->e_type =='new' ? 'in' : $entry->e_type; 
			} ?></td>
        <td colspan=2><?= $entry->e_rx.$entry->e_invoice;?></td>
        <td colspan=3><?= $entry->e_type == 'new' ? $entry->total_new_qty - $entry->total_old_qty : $qtyarr[$i];?></td>
        <td colspan=2><?=$entry->username;?></td><td><?=date('m-d-Y H:m:s', $entry->e_deleteddate);?>
		<!--<td colspan=3><?=$entry->e_status;?></td>-->
      </tr>
	
	  </tbody>
	  <?php } ?> 
	 


      <?php   if( $tran_group_id != $entry->e_transaction_group_id) echo  "<tr style=\"border-top:1px solid #14a3ec;\"> <td colspan=12></td></tr>";
	  else echo ""; ?> 
	  <?php if( $tran_group_id != $entry->e_transaction_group_id){?>
	       <thead style="font-weight: bold">
  <tr>
        
        <td>NDC</td>
        <td>Drug Name</td>
        <td colspan=3>Drug Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
      
        <td>Lot #</td>
        <td colspan=2>Expiration Date</td>
		  <td>Quantity Out</td>
        <!--<td>Date Edited</td>-->
      <!--<td>Status</td>-->
        <td>Notes</td>
      </tr></thead><?php } ?><tbody>
      <tr >
      
        <td><?php echo $entry->d_code; ?></td>
        <td><?php echo $entry->d_name; ?></td>
        <td colspan=3><?php echo $entry->d_descr; ?></td>
        <td><?php  if ($entry->d_size == 0) {
                echo 0;
            } else {
                //echo ($entry->e_costPack/$entry->d_size);
				echo ($drugs->d_size);
            } ?></td>           
        <td><?php echo $entry->d_manufacturer; ?></td>
   <td><?php echo $entry->e_lot; ?></td>
        <td colspan=2><?php  if ($entry->e_expiration == 0) {
                echo 0;
            } else {
                echo date('m-d-Y', $entry->e_expiration); 
            } ?></td>
      
        <td><?php echo $entry->e_out; ?></td>
       

        <td> <?php echo $entry->e_note; ?></td>      
        </tr>
      <?php $tran_group_id = $entry->e_transaction_group_id;  }?>
    </tbody>
	</table>
  </table>
</div>
<?php }?>

</div>


<div class="form-group" style="margin-top:10px;">
   <!-- <input  type="submit" value="Edit Transaction" onclick="showEdit();" class="btn btn-primary"/> -->
   <!-- <input  type="submit" value="Reverse Transaction" onclick="confirmDialog('<?php echo $transaction_id; ?>');" class="btn btn-primary"/>      -->
    <table><tr><?php if(isset($_POST['fromdashboard']) && $_POST['fromdashboard']==1) { ?><td><input  type="submit" value="Back" onclick="backButton(1);" class="btn btn-primary"></td>
	<?php } else { ?><td><input  type="submit" value="Back" onclick="backButton(0);" class="btn btn-primary"></td><?php } ?>
	<form>
<td><input type="button" onclick="printDiv1('history')" value="Print" class="btn btn-primary" />
</td>
</form></tr></table>

  </div>

<script>
	  function printDiv1(divName) {
		  var detaildivcontent = document.getElementById('detaildiv').innerHTML;
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML =  detaildivcontent + printContents ;

     window.print();

     document.body.innerHTML = originalContents;
	
}
	function confirmDialog(transactionId) {
		
		var result = confirm("Are you sure you want to delete this record?");
		if (result == true)
		window.location = "<?=base_url()?>edit_transaction/reverse_transaction/"+ transactionId;
		else
		return false;	
		}
	
		function backButton(dbval) {
			if(dbval==0)
		window.location = "<?=base_url()?>report/index";
		else
			window.location="<?=base_url()?>logbook/dashboard";
		}
	
	
</script>