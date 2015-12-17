<!-- Original Transaction -->
<div  class="row" id="history">
<div id="show_hide" data-toggle="collapse" data-target="#history_row">
  <h3> Transaction Details -  Original Entry</h3>
</div>
<div class="row in" id="history_row">
  <table class="table table-striped table-hover entry-table" style="border:1px solid #f9f9f9;margin-top:0px;margin-bottom:0px;">
    <thead style="font-weight: bold">
      <tr>
        <td>Date/Time Entered</td>
        <td>Transaction Type</td>
        <td>RX/Trans/Invoice #</td>
        <td>Total Quantity <?= $original_transaction[0]->e_type == 'new' ? 'IN' : 'OUT' ?></td>
        <td>Username</td>
      </tr>
    </thead>
    <tbody>
      
      <tr>
        <td><?= date('m-d-Y H:m:s', $original_transaction[0]->e_date);?>
        </td>
        <td><?= $original_transaction[0]->e_type == 'new' ?'IN' : $original_transaction[0]->e_type ?></td>
        <td><?= $original_transaction[0]->e_rx.$original_transaction[0]->e_invoice;?></td>
        <td><?= $original_transaction[0]->e_type == 'new' ? $original_transaction[0]->total_new_qty - $original_transaction[0]->total_old_qty : $original_transaction[0]->e_out_total;?></td>
        <td><?=$original_transaction[0]->username;?></td>
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
<div  class="row" id="history" style="max-height:400px;overflow:auto;" >
<h3> Related Transactions - Edited Entries</h3>
  <table class="table  table-hover dt-responsive"  style="width:100%;border:0px solid #FFFFFF;margin-top:0px;margin-bottom:0px;" cellspacing="0" id="transTable">

      <?php $totalqtycal=0;
	  
	  $tran_group_id =''; $i=0;foreach ($transaction_history as $entry) { ?>
	  
	     <?php if( $tran_group_id != $entry->e_transaction_group_id) {$i++;?>   <?php if($i%2==0) { ?><table class="table"  style="width:100%;border:1px solid orange;margin-top:0px;margin-bottom:0px;background-color:#e8e8ff;" cellspacing="0" > <?php } else {?><table class="table"  style="width:100%;border:1px solid orange;margin-top:0px;margin-bottom:0px;background-color:#EEEEEE;" cellspacing="0" ><?php } ?>
		 <thead style="font-weight: bold">
		 <tr style="border-top:3px solid red;"> <td colspan=12></td></tr>
      <tr>
        <td colspan=2>Date/Time Entered</td>
        <td colspan=2>Transaction Type</td>
        <td colspan=2>RX/Trans/Invoice #</td>
        <td colspan=3>Total Quantity In<!--<?= $original_transaction[0]->e_type == 'new' ? 'In' : 'Out (Edit)' ?>--></td>
        <td colspan=3>Username</td>
      </tr>
    </thead> <tbody>  <tr>
        <td colspan=2><?= date('m-d-Y H:m:s', $entry->e_last_edit_date);?>
        </td>
        <td colspan=2> <?php if($entry->e_type == 'edit') 
			{ 
			echo $entry->e_out == 0 ? "IN (".strtoupper($entry->e_type).")" : "OUT (".strtoupper($entry->e_type).")";  
			} 
			else 
			{ 
			echo $entry->e_type =='new' ? 'in' : $entry->e_type; 
			} ?></td>
        <td colspan=2><?= $entry->e_rx.$entry->e_invoice;?></td>
        <td colspan=3><?= $entry->e_type == 'new' ? $entry->total_new_qty - $entry->total_old_qty : $qtyarr[$i];?></td>
        <td colspan=3><?=$entry->username;?></td>
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
        <td>Drug Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
      
        <td>Lot #</td>
        <td>Exp Date</td>
		  <td>Quantity In</td>
        <td>Date Edited</td>
      <!--<td>Status</td>-->
        <td>Notes</td>
      </tr></thead><?php } ?><tbody>
      <tr class="units">
      
        <td><?php echo $entry->d_code; ?></td>
        <td><?php echo $entry->d_name; ?></td>
        <td><?php echo $entry->d_descr; ?></td>
        <td><?php  if ($entry->d_size == 0) {
                echo 0;
            } else {
                //echo ($entry->e_costPack/$entry->d_size);
				echo ($drugs->d_size);
            } ?></td>           
        <td><?php echo $entry->d_manufacturer; ?></td>
   <td><?php echo $entry->e_lot; ?></td>
        <td><?php  if ($entry->e_expiration == 0) {
                echo 0;
            } else {
                echo date('m-d-Y', $entry->e_expiration); 
            } ?></td>
      
        <td><?php echo $entry->e_out; ?></td>
       
    
         <td><?php  if ($entry->e_last_edit_date == 0) {
                echo 0;
            } else {
                echo date('m-d-Y', $entry->e_last_edit_date);
            } ?>
        </td>              
<!--  <td><?php if($entry->e_status==0) echo "InActive";
  if($entry->e_status==1) echo "Active";
  if($entry->e_status==2) echo "Edited";
    if($entry->e_status==3) echo "Deleted";
  ?>-->
        <td> <?php echo $entry->e_note; ?></td>      
        </tr>
      <?php $tran_group_id = $entry->e_transaction_group_id;  }?>
    </tbody>
	</table>
  </table>
</div>
<?php }?>



<!--<?php if(isset($transaction_history)) { ?>
<div  class="row" id="history" style="max-height:400px;overflow:auto;" >
<h3> Related Transactions</h3>
  <table class="table  table-hover dt-responsive"  style="width:100%;border:10px solid #f9f9f9;margin-top:0px;margin-bottom:0px;" cellspacing="0" id="transTable">

      <?php $tran_group_id =''; foreach ($transaction_history as $entry) { ?>
	     
	         <tbody>  <tr>
        <td colspan=2><?= date('m-d-Y H:m:s', $entry->e_last_edit_date);?>
        </td>
        <td colspan=2> <?= $entry->e_type == 'new' ?'in' : $entry->e_type ?></td>
        <td colspan=2><?= $entry->e_rx.$entry->e_invoice;?></td>
        <td colspan=3><?= $entry->e_type == 'new' ? $entry->total_new_qty - $entry->total_old_qty : $entry->e_out;?></td>
        <td colspan=3><?=$entry->username;?></td>
      </tr>
	
	  </tbody>
      <?php echo $tran_group_id != $entry->e_transaction_group_id ? '<tr style="border-top:1px solid #14a3ec;"> </tr>' : '' ?>   
	       <thead style="font-weight: bold">
  <tr>
        
        <td>NDC</td>
        <td>Drug Name</td>
        <td>Drug Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
      
    
      
        <td>Lot #</td>
        <td>Exp Date</td>
		  <td>Quantity Out</td>
        <td>Date Edited</td>
      <td>Status</td>
        <td>Notes</td>
      </tr></thead><tbody>
      <tr class="units">
      
        <td><?php echo $entry->d_code; ?></td>
        <td><?php echo $entry->d_name; ?></td>
        <td><?php echo $entry->d_descr; ?></td>
        <td><?php  if ($entry->d_size == 0) {
                echo 0;
            } else {
                echo ($entry->e_costPack/$entry->d_size);
            } ?></td>           
        <td><?php echo $entry->d_manufacturer; ?></td>
   <td><?php echo $entry->e_lot; ?></td>
        <td><?php  if ($entry->e_expiration == 0) {
                echo 0;
            } else {
                echo date('m-d-Y', $entry->e_expiration); 
            } ?></td>
      
        <td><?php echo $entry->e_out; ?></td>
       
    
         <td><?php  if ($entry->e_last_edit_date == 0) {
                echo 0;
            } else {
                echo date('m-d-Y', $entry->e_last_edit_date);
            } ?>
        </td>              
  <td><?php if($entry->e_status==1) echo "New";
  if($entry->e_status==2) echo "Edit";
  if($entry->e_status==3) echo "Reversed on ".date('m-d-Y H:s',$entry->e_deleteddate);
  ?>
        <td> <?php echo $entry->e_note; ?></td>      
        </tr>
		 <tr style="border-top:1px solid red;"><td colspan=12></td> </tr>
      <?php $tran_group_id = $entry->e_transaction_group_id; }?>
    </tbody>
  </table>
</div>
<?php }?>-->


<div class="form-group" style="margin-top:10px;">
    <input  type="submit" value="Edit Transaction" onclick="showEdit();" class="btn btn-primary"/> 
    <input  type="submit" value="Reverse Transaction" onclick="confirmDialog('<?php echo $transaction_id; ?>');" class="btn btn-primary"/>      
    <input  type="submit" value="Back" onclick="backButton();" class="btn btn-primary">
  </div>


<div class="hidden row" id="table1">
<h3> Product Details</h3>
  <table class="table table-bordered entry-table">
    <thead>
      <tr>
        <td>NDC</td>
        <td>Drug Name</td>
        <td>Drug Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
        <td>Schedule</td>
        <td>Quantity on hand</td>
      </tr>
    </thead>
    <tbody>
       <tr>
        <td><?=$drug['d_code']?> </td>
        <td><?=$drug['d_name']?></td>
        <td><?=$drug['d_descr']?></td>
        <td><?=$drug['d_size']?></td>
        <td><?=$drug['d_manufacturer']?></td>
        <td><?=$drug['d_schedule']?></td>
        <td id="qtyOnHand"><?=$drug['d_onHand']?></td>
        </tr>
    </tbody>
  </table>
  <?php if($original_transaction[0]->e_ndc_type == 0) { ?>
  <input style="margin-bottom: 10px;" type="button" id="button1" onclick="show_table(2)" value="Single NDC" class="btn btn-info">
  <?php } else { ?>
  <input style="margin-bottom: 10px;" type="button" id="button2" onclick="show_table(3)" value="Multiple NDC" class="btn btn-success">
  <?php } ?>
</div>
<!--row-->
<div class="row hidden" id="table2">
  <form action="<?=base_url()?>edit_transaction/edit_entry/<?php echo $transaction_id; ?>" method="post" class="save-form" id="form1">
    <input type="hidden" name="add_new" value="0" id="success_or_new1">
    <input type="hidden" value="<?=$drug['d_id']?>" id="e_drugId" name="e_drugId">
    <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">
    <input type="hidden" value="<?=$parent_id ?>" name="e_parent_id">
    <input type="hidden" value="<?=$selected_transaction[0]->total_lots; ?>" name="e_total_lots">
    <input type="hidden" value="<?=$selected_transaction[0]->total_entry_ids; ?>" name="e_total_entry_ids">
    <input type="hidden" value="out_mul" name="e_type">
    <input type="hidden" id="e_total" name="e_total">
    <input type="hidden" id="e_operator" name="e_operator" value="-">
    <input id="input1" type="hidden" name="e_new">
    <table class=" table table-bordered entry-table" id="table-table2">
      <thead>
        <tr>
          <td>Date</td>
          <td>RX/Transaction #</td>
          <td>Quantity OUT</td>
          <td>New Quantity OUT</td>
          <td>New QOH</td>
          <td>Variance</td>
          <td>Notes</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><div class="form-group">
              <input type="text" name="e_date" class="form-control  datetimeST" id="date1" value="<?php echo date('m-d-Y', $selected_transaction[0]->e_date) ?>" required>
            </div></td>
          <td><div class="form-group">
              <input type="text" name="e_rx" autocomplete="off" onkeyup="checkRX_Transaction(this.value);" class="form-control uppercase" value="<?php echo $selected_transaction[0]->e_rx; ?>" required>
              
            </div></td>
          <td id="last_out_qty"> <?php echo $selected_transaction[0]->e_out_total; ?></td>
          <td><div class="form-group">
              <input id="qty_out" type="text" autocomplete="off" name="e_out" class="form-control" value="0"  required >
              <input id="original_qty_out" type="hidden" name="e_original_qty_out" class="form-control" value="<?php echo $selected_transaction[0]->e_out_total; ?>" >
              
            </div></td>
          <td id="new_qty"></td>
          <td class="variance_in_out_qty"></td>
          <td><div class="form-group">
              <input type="text" name="e_note" class="form-control note uppercase">
            </div></td>
        </tr>
      </tbody>
    </table>
    <?php if($drug['d_lotTracking']) { ?>
    <div style="width: 50%;padding-bottom:20px;">
      <table id="lots_table" class="table table-bordered">
        <thead>
          <tr>
            <td>Lot Number</td>
            <td>Expiration Date</td>
            <td>Lot QOH</td>
            <td>Lot Qty Out</td>
            <td>New Lot Qty Out</td>
            <td>New Lot QQH</td>
            <td>Variance</td>
            <td>Remove</td>
          </tr>
        </thead>
        <tbody id="add_lots">
                
        </tbody>
      </table>
      <div class="row"> 
       <div class="col-md-4"> <span id="lots_total_count" style="text-align: right; padding: 5px;margin-bottom:20px;"><b>Lot Total: 0</b></span></div>
       <div class="col-md-4"><span id="lots_remain_count" style="text-align: right; padding: 5px;"><b>Total Remaining: 0</b></span></div>
       <div class="col-md-4"><input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots();" style="float: right; padding: 10px;"></div>
        </div>
    </div>
    <?php }?>
    <b id="expires_warning" style='display: none; color: #FF0000;'>Warning! This drug is about to or has already expired</b> <b id="notactive_warning" style='display: none; color: #FF0000;'>Warning! This lot is not active</b> <b id="erx_warning" style='display: none; color: #FF0000;'>Warning! There is the same RX/Transaction number in the system</b> <br/>
    <input style="margin-bottom: 10px;" type="submit" value="Confirm" class="btn btn-primary" id="confirm_1">
    <button style="margin-bottom: 10px;" type="submit" class="btn btn-success" name="add_another_out" id="another_1">Confirm & Add Another</button>
  </form>
</div>
<!--row hidden table2-->
<form action="<?=base_url()?>logbook/edit_entry/<?php echo $transaction_id; ?>" method="post" id="form2" class="save-form">
  <div class="row hidden" id="table3">
    <input type="hidden" value="multi_out" name="e_type">
    <input type="hidden" value="<?=$parent_id ?>" name="e_parent_id">
    <input type="hidden" value="<?=$selected_transaction[0]->total_lots; ?>" name="e_total_lots">
    <input type="hidden" value="<?=$selected_transaction[0]->total_entry_ids; ?>" name="e_total_entry_ids">
    <input type="hidden" value="0" name="add_new" id="success_or_new2">
    <table class=" table table-bordered entry-table" id="table-table3">
      <thead>
        <tr>
          <td>Date</td>
          <td>RX/Transaction #</td>
          <td>Quantity OUT</td>
          <td>New Quantity OUT</td>
          <td>Variance</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><div class="form-group">
              <input type="text" name="e_date" id="date2" class="form-control  datetimeST" value="<?php if($selected_transaction[0]->e_date == 0) echo date('m-d-Y'); else echo date('m-d-Y', $selected_transaction[0]->e_date) ?>" required>
            </div></td>
          <td><div class="form-group">
              <input type="text" autocomplete="off" name="e_rx" onkeyup="checkRX_Transaction(this.value);" value="<?php echo $selected_transaction[0]->e_rx; ?>" class="form-control uppercase" required>
            </div></td>
            <td id="last_out_qty"> <?php echo $selected_transaction[0]->e_out_total; ?></td>
          <td><div class="form-group">
              <input id="qty_out2"  autocomplete="off" name="e_out" type="text" class="form-control" required >
            </div></td>
            <td class="variance_in_out_qty"></td>
        </tr>
      </tbody>
    </table>
    <b id="erx_warning2" style='display: none; color: #FF0000;'>Warning! There is the same RX/Transaction number in the system</b> <br/>
    <input style="margin-bottom: 10px;" type="button" onclick="show_table(4)" value="Confirm" class="btn btn-primary">
  </div>
  <!--row hidden table2-->
  <div class="row hidden" id="table4">
    <div class="col-md-12">
      <table class=" table table-bordered entry-table" id="table-table4">
        
        
        <thead>
          <tr>
            <td>NDC</td>
            <td>Name</td>
            <td>Quantity on Hand</td>
            <td>Quantity Out</td>
            <td>Lots</td>
            <td>Variance</td>
            <td>Notes</td>
          </tr>
        </thead>
        <tbody>
          <tr id="<?=$drug['d_id']?>">
            <td class="ndc"><?=$drug['d_code']?>
              <input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId[]">
              <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old[]">
              <input type="hidden" value="<?=$drug['d_onHand']?>" class="input1" name="e_new[]">
            </td>
            <td><?=$drug['d_name']?></td>
            <td class="hand"><?=$drug['d_onHand']?></td>
            <td><div class="form-group">
                <input id="e_out_1" type="text" name="e_out[]" value="<?php echo $selected_transaction[0]->e_out_total; ?>" 
                class="out form-control" required>
                <input id="e_original_out_1" type="hidden" name="e_original_out[]" value="<?php echo $selected_transaction[0]->e_out_total; ?>" 
                class="original_qty_out_m_ndc form-control">
              </div></td>
            <td><?if ($drug["d_lotTracking"]) { ?>
              <table id="lots_table_1" class="table table-bordered">
                <thead>
                  <tr>
                    <td>Lot Number</td>
                    <td>Expiration Date</td>
                    <td>Lot QOH</td>
                    <td>Lot Qty Out</td>
                    <td>New Lot Qty Out</td>
                    <td>New Lot QQH</td>
                    <td>Variance</td>
                    <td>Remove</td>
                  </tr>
                </thead>
                <tbody id="add_lots_1">
                </tbody>
              </table>
              <div>
                <input type="button" class="btn btn-success" value="Add Lot" onclick="addNewLotsMulti('', '', '', '', '#add_lots_1',<?= @$drug['d_id'] ?>,1);" style="float:right;">
                <div id="lots_total_count_1" style="display: inline-block; text-align: right; width: 100%;  padding: 5px;"><b>Lot Total: 0</b></div>
                <div id="lots_remain_count_1" style="display: inline-block; text-align: right; width: 100%; padding: 5px;"><b>Total Remaining: 0</b></div>
              </div>
              <?}?>
            </td>
            <td class="variance"></td>
            <td><div class="form-group">
                <input type="text" name="e_note[]" class="note form-control uppercase">
              </div></td>
          </tr>
        </tbody>
      </table>
      <input type="button" id="button" onclick="openModal()" value="Add another NDC" class="btn btn-primary">
      <button type="submit" class="btn btn-success" name="add_another_out" id="another2">Confirm & Add Another</button>
    </div>
    <!--col-md-8-->
    <div class="col-md-4">
      <table class="table table-bordered entry-table" id="table-total">
        <tr>
          <td> Quantity OUT </td>
          <td id="qty_all"></td>
        </tr>
        <tr id="total<?=$drug['d_id']?>">
          <td><?=$drug['d_code']?>
          </td>
          <td class="qty_one"></td>
        </tr>
        <tr>
          <td> Total Remaining </td>
          <td id="total"></td>
        </tr>
      </table>
    </div>
    <!--col-md-4-->
  </div>
  <!--row-->
</form>
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Enter another NDC</h4>
      </div>
      <div class="modal-body" >
        <form id="modalForm">
          <input type="text" name="ndc" class="form-control" data-mask="99999-9999-99">
          <input type="button" onclick="getDrugs();" style="margin-top:10px;" class="btn btn-primary" value="Search">
          <div id="selectDiv" class="hidden">
            <select id="modalSelect" class="form-control" name="d_id">
            </select>
          </div>
          <div id="noResults" class="hidden">
            <p>There are no results under these conditions.</p>
            <p><a href="<?=base_url()?>drug/add_drug" target="_blank" class="btn btn-primary">Add drug</a></p>
          </div>
          <div id="drugInactive" class="hidden">
            <p>This Drug is Inactive</p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="delId">
        <button type="button" class="btn btn-danger" id="modal-go-button" data-dismiss="modal" disabled>Go!</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>

	var LOTS = <?= json_encode($lots_data) ?>;
	var LID = 0;
	
	var GLOBAL_DRUG_ID = 1;
	var NEED_CHECK_SUM = false;
	var DRUG_AND_LOTS = {};
	var LOT_TRACKING = false;
	var FIRST_LOT_ADDED = false;
	var FIRST_OPEN_ADDLOTEXPDATE = false;
	var NDC_TYPE    		= 0;
	var LAST_TOTAL_QTY_OUT    	= <?php echo $selected_transaction[0]->e_out_total; ?>;
	
	<? if($drug["d_lotTracking"]) { ?>
	LOT_TRACKING = true;
	<? } ?>
	
	<?php if($original_transaction[0]->e_ndc_type != 0) { ?>
		NDC_TYPE    = 1;
	<?php } ?>
	
	function checkRX_Transaction(code)
	{
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url('logbook/checkLotRXCode'); ?>",
			data: {
				"e_code": code
			},
			cache: false,
			success: function(response){
				if (response == "true")
				{
					$("#erx_warning").css("display", "block");
					$("#erx_warning2").css("display", "block");
				} else {
					$("#erx_warning").css("display", "none");
					$("#erx_warning2").css("display", "none");
				}
			},
			error: function(response) {

			}
		});
	}

	function removeLotsFromTableSimple(row_id)
	{
		$("#lotrow_" + tableId + "_" + row_id).remove();
		recountLots();

	}

	function removeLotsFromTable(tableId, row_id)
	{
		$("#lotrow_" + tableId + "_" + row_id).remove();
		recountLotsMultiple('.audit_qohs_' + tableId, tableId);
		recountAllPossibleLotsCount();
	}

	function setNotesIfLotExpires(lotName)
	{
		var now = Date.now() / 1000 | 0;
		$(".note").removeAttr("required");

		for (var i = 0; i < LOTS.length; i++)
			if (LOTS[i].lotName = lotName && LOTS[i].expirationDate < now)
				$(".note").attr("required", "");
	}

	function checkMaxQOH(field)
	{
		var lid = $(field).attr("lid") * 1;
		var maxval = $("#oldqoh_" + lid).html() * 1 + $("#lot_last_out_qty_" + lid).html() * 1;
		var myval = $(field).val() * 1;
		if (myval > maxval) $(field).val(maxval);
	}
	
	function loadlotsMultipleNDC()
	{		
		var to_field  		= arguments[0] || "";
		var drug_id  		= arguments[1] || "";
		var table_id  		= arguments[2] || "";
		<?
			$lot_list = array();
			if (@$lots) foreach ($lots as $lot)
			{
				$lot["expirationDate"] = date("m/d/Y", $lot["expirationDate"]);
				$lot_list[] = $lot;
			}
		?>
		var lots 	= <?= json_encode($lot_list) ?>;
		
		$('#qty_out2').trigger("keyup");
		$('.out').trigger("keyup");
		if (!table_id) table_id = 1;
		
		var drugId = '';
		if(drug_id)
		drugId 	= drug_id;
		else
		drugId 	= lots[0].drugId;
		 	
				 
			for (var j 	= 0; j < lots.length; j++) {
				if(drugId == lots[j].drugId && lots[j].lotName !='' ) { //if(entries[i].e_lot == lots[j].lotName && drugId == lots[j].drugId ) {
				addNewLotsMulti(lots[j].lotName, lots[j].expirationDate, lots[j].count,'',to_field,drugId,table_id); 
			}
		}	
	}
	

	function addNewLotsMulti()
	{
		
		LID += 1;
		var e_lot  		= arguments[0] || "";
		var e_date 		= arguments[1] || "";
		var e_qoh  		= arguments[2] || "";
		var e_old_qoh 	= arguments[3] || 0;
		var where 		= arguments[4] || "";
		var drug_id 	= arguments[5] || "";
		var table_id 	= 1;
		var tableId 	= arguments[6] || "";
		if(tableId) table_id = tableId;
		var to_field 	= "#add_lots_1";
		if(where) to_field = where;
		
		//here pickout the qty_out and lot_number from original transaction to autoselect the data in lots
		var entry 			= <?= json_encode($selected_transaction) ?>;
		var lot_name 		= e_lot;
		var lot_names_array = lot_name.split('-');
		var lot_number      = '';
		var qty_out      	= '';
		
		
		var QTY_OUT_PER_DRUG = 0 ;
		for (var i = 1; i < entry.length; i++) // at place 1 we have common total entry so skip it
		{
			if(entry[i].e_lot == lot_names_array[0])
			{
			  qty_out 		= entry[i].e_out;
			  lot_number 	= entry[i].e_lot;		  
			  			  
			}
			if(entry[i].e_drugId == drug_id)
			QTY_OUT_PER_DRUG = parseInt(QTY_OUT_PER_DRUG) + parseInt(entry[i].e_out) ;
		}
		
		var select_lot_ddl = lot_number !='' ? 'readonly' : '';
		
		
		$('#e_out_'+ table_id).val(QTY_OUT_PER_DRUG); 
		$('#e_original_out_'+ table_id).val(QTY_OUT_PER_DRUG); 
		var row2 = $('#total'+drug_id);
		row2.find('.qty_one').text(QTY_OUT_PER_DRUG);				
		var lot_string = '<tr id="lotrow_' + table_id + '_' + LID + '">' +
		'<td><select ' +  select_lot_ddl + ' class="form-control" id="lot_select_' + LID + '"><option>None</option></select>'+
		'<input type="hidden" lid="' + LID + '" drug-id="' + drug_id + '" id="elot_' + LID + '" name="out_lot_' + drug_id + '[]" class="e_lot" value="' + e_lot + '" required/><input type="hidden" id="e_lot_original_' + LID + '" name="original_lot_'+ drug_id + '[]"  value="' + lot_number + '" /></td>'+ 
		
		'<td><input type="text" id="edate_' + LID + '" name="out_expiration_' + drug_id + '[]" class="form-control datetimeST3" value="' + e_date + '" required/></td>' + 
		'<td><div class="lot_old_qqh" id="oldqoh_' + LID + '">' + e_qoh + '</div><input id="oldqoh_f_' + LID + '" name="out_oldqoh_' + drug_id + '[]" type="hidden" value="' + e_qoh + '"></td>' +
		 '<td id="lot_last_out_qty_' + LID + '" class="lot_last_out_qty">'+ qty_out +'</td>'+
		 '<td><input type="text" lid="' + LID + '" name="out_qoh_' + drug_id + '[]" onkeypress="checkMaxQOH(this);" onkeyup="checkMaxQOH(this); recountAllPossibleLotsCount();" class="lot_out audit_qohs_' + table_id + ' form-control" autocomplete="off" value="' + qty_out + '" required/></td>' +
		 '<td  class="new_lot_qqh"></td>'+
		 '<td  class="lot_variance"></td>'+
		  '<td><a href="javascript://void();" onclick="removeLotsFromTable(' + table_id + ', ' + LID + ');">remove</a></td>' + '</tr>';
		
		$(to_field).append(lot_string);
		initLotList(".e_lot");
		initDatePicker();
		DRUG_AND_LOTS[table_id] = '.audit_qohs_' + table_id;
		recountAllPossibleLotsCount();
		loadLotsForSelectByDrugID("#lot_select_" + LID, drug_id, LID,lot_number ,qty_out);
		NEED_CHECK_SUM = true;
		FIRST_LOT_ADDED = true;
		//$('.save-form').data('bootstrapValidator').validate();
	}
	
		
	function initDefaultLots()
	{
		<?
			$lot_list = array();
			if (@$lots) foreach ($lots as $lot)
			{
				$lot["expirationDate"] = date("m/d/Y", $lot["expirationDate"]);
				$lot_list[] = $lot;
			}
		?>
		var lots = <?= json_encode($lot_list) ?>;

		for (var i = 0; i < lots.length; i++)
			addNewLots(lots[i].lotName, lots[i].expirationDate, lots[i].count);
	}

	

	function addNewLots()
	{
		
		<?php if (@$drug["d_lotTracking"]) { ?>
		if (!FIRST_OPEN_ADDLOTEXPDATE)
		{
			FIRST_OPEN_ADDLOTEXPDATE = true;
			initDefaultLots();
			return;
		}
		<? } ?>
		
		LID += 1;
		var e_lot = arguments[0] || "";
		var e_date = arguments[1] || "";
		
		var e_qoh = arguments[2] || "";
		var e_old_qoh = arguments[3] || 0;
		var where = arguments[4] || "";
		var table_id = arguments[5] || "";
		var to_field = "#add_lots";
		if (where) to_field = where;
		
		
		//here pickout the qty_out and lot_number from original transaction to autoselect the data in lots
		var entry 			= <?= json_encode($selected_transaction) ?>;
		var lot_name 		= e_lot;
		var lot_names_array = lot_name.split('-');
		var lot_number      = '';
		var qty_out      	= '';
		
		for (var i = 0; i < entry.length; i++) 
		{
			if(entry[i].e_lot == lot_names_array[0])
			{
			  qty_out 		= entry[i].e_out;
			  lot_number 	= entry[i].e_lot;
			}		
		}
		
		var select_lot_ddl = lot_number !='' ? 'readonly' : '';
		
		$(to_field).append('<tr id="lotrow_' + table_id + '_' + LID + '">' +
		'<td><select '+ select_lot_ddl +' class="form-control" id="lot_select_' + LID + '"><option>None</option></select><input type="hidden" lid="' + LID + '" drug-id="<?= @$drug["d_id"] ?>" id="elot_' + LID + '" name="audit_lot[]" value="' + e_lot + '" required/> <input type="hidden" id="e_lot_original_' + LID + '" name="original_lot[]"  value="' + lot_number + '" />   </td>'+ '<td><input type="text" id="edate_' + LID + '" name="audit_expiration[]" class="form-control" readonly value="' + e_date + '" required/></td>' +
		'<td><div class="lot_old_qqh"  id="oldqoh_' + LID + '">' + e_qoh + '</div><input id="oldqoh_f_' + LID + '" name="audit_oldqoh[]" type="hidden" value="' + e_qoh + '"></td>'  +  '<td id="lot_last_out_qty_' + LID + '" class="lot_last_out_qty">'+ qty_out +'</td>'+'<td><input type="text"  lid="' + LID + '" name="audit_qoh[]" onkeypress="checkMaxQOH(this);" onkeyup="checkMaxQOH(this); recountLots();" class="lot_out audit_qohs form-control" autocomplete="off" value="' + qty_out + '" required/></td>' + '<td  class="new_lot_qqh"></td>'+ '<td  class="lot_variance"></td>' + '<td><a href="javascript://void();" onclick="removeLotsFromTableSimple(' + LID + ');">remove</a></td>' + '</tr>');
		
		$('.lot_out').keyup(function(){
				var row = $(this).parent().parent();
				var out = row.find('.lot_out').val();
				row.find('.lot_variance').text(out - row.find('.lot_last_out_qty').text());
				row.find('.new_lot_qqh').text(row.find('.lot_old_qqh').text() - (out - row.find('.lot_last_out_qty').text()));
        });

		initLotList(".e_lot");
		initDatePicker();
		recountLots();
		FIRST_LOT_ADDED = true;
		loadLotsForSelectByDrugID("#lot_select_" + LID, <?= @$drug["d_id"] ?$drug["d_id"] :0 ?>, LID,lot_number ,qty_out);
	}

	function loadLotsForSelectByDrugID(field, drugId, numField,lotNumber ,qtyOut)
	{
		$.ajax({
			url: "<?php echo site_url('logbook/getJSON_lotsEditTransaction/with_date_and_count'); ?>",
			dataType: "json",
			data: {
				q: "",
				drugId: drugId
			},
			success: function(data) {			
				
				for (var i = 0; i < data.length; i++)
				{
					var lotdata = data[i].split("-");
					
					if(lotdata[0].trim() == lotNumber) //if lot number matched then set selected
					{
					$(field).append("<option disabled selected='selected' value='" + data[i] + "'>" + data[i] + "</option>");
					}
					else if(lotNumber =='')
					{
					$(field).append("<option value='" + data[i] + "' >" + data[i] + "</option>");					
					}
					
				}

				$(field).change(function()
				{
					var data = $(this).val().split(" - ");

					$("#elot_" + numField).val(data[0]);
					$("#edate_" + numField).val(data[1]);
					$("#oldqoh_" + numField).html(data[2]);
					$("#oldqoh_f_" + numField).val(data[2]);					
				});
			}
		});
	}

	function checkLotExpires()
	{
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url('logbook/checkLotExpires'); ?>",
			data: {
				"e_drugId": $("#e_drugId").val(),
				"e_lot": $("#e_lot").val()
			},
			cache: false,
			success: function(response){
				if (response == "true") $("#expires_warning").css("display", "block");
				else $("#expires_warning").css("display", "none");
			},
			error: function(response) {

			}
		});
	}

	function recountAllPossibleLotsCount()
	{
		var ALL_OK = false;

		for (var id in DRUG_AND_LOTS) {
			ALL_OK = recountLotsMultiple(DRUG_AND_LOTS[id], id);
			if (!ALL_OK) break;
		}

		if (LOT_TRACKING && FIRST_LOT_ADDED) {
			if (ALL_OK) {
				$("#button").removeAttr("disabled");

				$("#another2").removeAttr("disabled");
			} else {
				if ($("#button").val() == "Confirm Entry") $("#button").attr("disabled", true);

				$("#another2").attr("disabled", true);
			}
		}

	}

	function recountLotsMultiple(field, tableId , value)
	{
		var TOTAL_QOH = 0;
		var TOTAL_UNITS = $("#e_out_" + tableId).val() * 1;

		$(field).each(function(i){
			TOTAL_QOH += +$(this).val();
		});

		var REMAIN = TOTAL_UNITS - TOTAL_QOH;
		
		$("#lots_total_count_" + tableId).html("<b>Lot Total: " + TOTAL_QOH + "</b>");
		$("#lots_remain_count_" + tableId).html("<b>Total Remaining: " + REMAIN + "</b>");

		return TOTAL_QOH == TOTAL_UNITS;
	}

	function recountLots()
	{
		var TOTAL_QOH = 0;
		var TOTAL_UNITS = $("#qty_out").val() * 1;

		$('.audit_qohs').each(function(i) {
			TOTAL_QOH += +$(this).val();
		});

		var REMAIN = TOTAL_UNITS - TOTAL_QOH;

		$("#lots_total_count").html("<b>Lot Total: " + TOTAL_QOH + "</b>");
		$("#lots_remain_count").html("<b>Total Remaining: " + REMAIN + "</b>");

		if (LOT_TRACKING && FIRST_LOT_ADDED) {
			if (TOTAL_QOH == TOTAL_UNITS) checkAndLockButtons(false, 1);
			else checkAndLockButtons(true, 1);
		}
	}

	function checkAndLockButtons(lock, type)
	{
		if (lock)
		{
			$("#confirm_" + type).attr("disabled", true);
			$("#another_" + type).attr("disabled", true);
			$("#add_new_lots_" + type).removeAttr("disabled");
		} else {
			$("#confirm_" + type).removeAttr("disabled");
			$("#another_" + type).removeAttr("disabled");
			$("#add_new_lots_" + type).attr("disabled", true);
		}
	}

	function checkActiveLot()
	{
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url('logbook/checkActiveLot');?>",
			data: {
				"e_drugId": $("#e_drugId").val(),
				"e_lot": $("#e_lot").val()
			},
			cache: false,
			success: function(response){
				$("#notactive_warning").css("display", "none");
				if (response == "notactive") $("#notactive_warning").css("display", "block");
			},
			error: function(response) {
			}
		});
	}

	$('#date1').change(function() {
		$('#form1').bootstrapValidator('revalidateField', 'e_date');
	});

	$('#date2').change(function() {
		$('#form2').bootstrapValidator('revalidateField', 'e_date');
	});

	
    function show_table(id) {
        $('#another2').hide();
        var table = $('#table'+id);
		<!-- trigger bootstrap validator to validate auto filled boxes-->
		$('.save-form').data('bootstrapValidator').validate();
		<!-- trigger keyup function for qty-->
		$('#qty_out').keyup();
		$('.out').keyup();
		
		
		//show transaction history table when table 1 get visible
		if(id == 1) {
		$('#history').removeClass('hidden');
		$('#original_transaction').removeClass('hidden');
		}
		
        table.removeClass('hidden');
        $('#button0').attr('disabled', true);
        if (id == 2){
            $('#button2').attr('disabled', true)
        }
        else if (id == 3){
            $('#button1').attr('disabled', true)
        }
        else if (id == 4){           
			var out_all = $('#qty_out2').val();
            $('#qty_all').text(out_all);
			loadlotsMultipleNDC(); // add lots 
			
		<?php
			$lot_list = array();
			if (@$multiple_ndc_drugs) foreach ($multiple_ndc_drugs as $lot)
			{
				$lot_list[] = $lot;
			}
		?>
		var multiple_ndc_drugs = <?= json_encode($lot_list) ?>;	
		
			
		for (var i = 0; i < multiple_ndc_drugs.length; i++)
		   if(i !=0) { // we have already processed 
		   
				var response = multiple_ndc_drugs[i];
				var childRow = $('#table-table4').append();
				var lotCell  = '';				
				GLOBAL_DRUG_ID += 1;

				if (response.d_lotTracking == 1) {
				lotCell = '<table id="lots_table_' + GLOBAL_DRUG_ID + '" class="table table-bordered"><thead><tr><td>Lot Number</td><td>Expiration Date</td><td>Lot QOH</td><td>Lot Qty Out</td><td>New Lot Qty Out</td><td>New Lot QQH</td><td>Variance</td><td>Remove</td></tr></thead><tbody id="add_lots_' + GLOBAL_DRUG_ID + '"></tbody></table>' + '<div><input type="button" class="btn btn-success" value="Add Lot" style="float: right" onclick="addNewLotsMulti(\'\',\'\', \'\', \'\', \'#add_lots_' + GLOBAL_DRUG_ID + '\', ' + response.d_id + ', ' + GLOBAL_DRUG_ID + ');"><div id="lots_total_count_' + GLOBAL_DRUG_ID + '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Lot Total: 0</b></div><div id="lots_remain_count_' + GLOBAL_DRUG_ID + '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Total Remaining: 0</b></div></div>';
				}
			var entries 	= <?= json_encode($selected_transaction) ?>;
			var out_qty     = 0;
			for(var k = 1 ; k < entries.length; k++)
			{
			  if(entries[k].e_drugId == response.d_id && entries[k].e_lot == '') {
			  out_qty  = entries[k].e_out; // set out qty for the drug for which lot is not enabled	
			  break;
			  }
			}

			childRow.append('<tr id="'+response.d_id+'">' +
			'<input type="hidden" value="'+response.d_id+'" name="e_drugId[]">' +
			'<input type="hidden" value="'+response.d_onHand+'" name="e_old[]">' +
			'<input class="input1" type="hidden" value="'+response.d_onHand+'" name="e_new[]">' +
			'<td class="ndc">'+response.d_code+'</td><td>'+response.d_name+'</td>' +
			'<td class="hand">'+response.d_onHand+'</td><td><div class="form-group">' +
			'<input id="e_out_' + GLOBAL_DRUG_ID + '" type="text" name="e_out[]" value="'+ out_qty +'" class="out form-control">'+ 
			'<input id="e_original_out_' + GLOBAL_DRUG_ID + '" type="hidden"  value="'+ out_qty +'" name="e_original_out[]"'+ 
			'class="original_qty_out_m_ndc form-control"></div></td>' +
			'<td>' + lotCell + '</td>' +
			'<td class="variance"></td>' +
			'<td><div class="form-group">' +
			'<input type="text" name="e_note[]" class="note form-control uppercase"></div></td></tr>');
			var childTotal = $('#total').parent().before('<tr id="total'+response.d_id+'"><td>'+response.d_code+'</td><td class="qty_one"></td></tr>');
			var row2 = $('#total'+response.d_id);
			row2.find('.qty_one').text(out_qty);
			  
			$('.out').unbind();
			$('.save-form').data('bootstrapValidator', null);	
			if (response.d_lotTracking == 1)			
			loadlotsMultipleNDC('#add_lots_' + GLOBAL_DRUG_ID,response.d_id,GLOBAL_DRUG_ID);
						
			applyValidator();
			$('.out').keyup(function(){
			var row = $(this).parent().parent().parent();
            var hand = row.find('.hand').text();
		    var out = row.find('.out').val();
			var original_out_qty 	= row.find('.original_qty_out_m_ndc').val();
            var newval = 0;
			if(Number(original_out_qty) > Number(out))
			newval 	= Number(hand) + Number(Number(original_out_qty) - Number(out));
			else 
			newval 	= Number(hand) - Number(Number(out) - Number(original_out_qty));
						
			var ndc = row.find('.ndc').text();
			row.find('.variance').text(newval);
			row.find('.input1').val(newval);
			
			
			if (newval<0){
				row.find('.note').prop('required', true);
			}
			else {
				row.find('.note').prop('required', false);
			}
			
			var id = row.attr('id');
			var row2 = $('#total'+id);
			row2.find('.qty_one').text(out);
			var sum = 0;
			$('.qty_one').each (function (i) {	
				sum+= +$(this).text();
			});
			
			var total = $('#qty_all').text() - sum;
			$('#total').text(total);

			if (total == 0){
				$('#button').attr('value', 'Confirm Entry');
				$('#button').attr('onclick', '');
				$('#button').attr('type', 'submit');
				$('#another2').show();
			} else {
				$('#button').attr('value', 'Add another NDC');
				$('#button').attr('onclick', 'openModal()');
				$('#button').attr('type', 'button');
				$('#another2').hide();
			}
			recountAllPossibleLotsCount();
        });
		
		
		$('.lot_out').keyup(function(){
				var row = $(this).parent().parent();
				var out = row.find('.lot_out').val();
				row.find('.lot_variance').text(out - row.find('.lot_last_out_qty').text());
				row.find('.new_lot_qqh').text(row.find('.lot_old_qqh').text() - (out - row.find('.lot_last_out_qty').text()));
        });
				// re init
				initLotList(".e_lot"); 
			}
        }
    }

	initLotList(".e_lot", 0);
	initLotList(".e_lot_simple", <? if (@isset($drug["d_id"])) echo @$drug["d_id"]; else echo 0; ?>);
	function initLotList(field, drugId)
	{
		$(field).autocomplete({
			source: function( request, response ) {
				var alt_drugId = this.element.attr('drug-id');
				if (alt_drugId) drugId = alt_drugId;
				$.ajax({
					url: "<?php echo site_url('logbook/getJSON_lots/with_date_and_count');?>",
					dataType: "json",
					data: {
						q: "",
						drugId: drugId
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 0,
			select: function( event, ui ) {
				var lid = $(event.target).attr('lid');
				setTimeout(function()
				{
					var ids = ui.item.label.split(" - ");
					$("#elot_" + lid).val(ids[0]);
					$("#edate_" + lid).val(ids[1]);
					$("#oldqoh_" + lid).html(ids[2]);
					$("#oldqoh_f_" + lid).val(ids[2]);
					checkLotExpires();
					checkActiveLot();
					setNotesIfLotExpires(ids[0]);
					$('.save-form').bootstrapValidator('revalidateField', 'e_lot');
					$('.save-form').bootstrapValidator('revalidateField', 'e_lot[]');
				}, 150);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	}

   function applyValidator(){
        $('.save-form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			excluded: ':disabled',
            fields: {
                'e_out[]': {
                    message: 'Qty Out is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Qty Out is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Qty Out can only consist of numerical characters'
                        },
						greaterThan: {
                        value: 1,
                        message: 'Qty Out value must be greater than 0'
						}
                    }
                },
                'e_out': {
                    message: 'Qty Out is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Qty Out is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Qty Out can only consist of numerical characters'
                        },
						greaterThan: {
                        value: 1,
                        message: 'Qty Out value must be greater than 0'
						}
                    }
                },
				'e_lot[]': {
					message: 'Lot is not valid',
					validators: {
						<?if (@$drug["d_lotTracking"]) { ?>
						notEmpty: {
							message: 'Lot is required and cannot be empty'
						},
						<? } ?>
						remote: {
							message: 'Lot not found or inactive',
							url: "<?php echo site_url('/logbook/isLotExistM');?>",
							type: 'POST'
						}
					}
				},
				'e_lot': {
					message: 'Lot is not valid',
					validators: {
						<?if (@$drug["d_lotTracking"]) { ?>
						notEmpty: {
							message: 'Lot is required and cannot be empty'
						},
						<? } ?>
						remote: {
							message: 'Lot not found or inactive',
							url: "<?php echo site_url('/logbook/isLotExist');?>",
							type: 'POST',
							delay: "180"
						}
					}
				},
                '#qty_out2': {
                    message: 'Qty Out is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Qty Out is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Qty Out can only consist of numerical characters'
                        },
						greaterThan: {
                        value: 1,
                        message: 'Qty Out value must be greater than 0'
						}
                    }
                }
            }
        });
    }

    $(document).ready(function() {

      	$('#another2').hide();
       	applyValidator();
        
		$('#qty_out2').keyup(function(){
            var out = $(this).val();
            $('#qty_all').text(out);
			var row 				= $(this).parent().parent().parent();
			row.find('.variance_in_out_qty').text(out - $('#last_out_qty').text());
			$('#total').text(out - $('#last_out_qty').text());
        });
		
		<!-- show search drug div on click on change drug-->
		$('#changeDrug').click(function(){
		   $('#search_drug').show();
		});
		
		<!-- hide search drug div on click cancel button-->
		$('#cancel_change_drug').click(function(){
		   $('#search_drug').hide();
		});		 
		
        $('#qty_out').keyup(function(){
            var row 				= $(this).parent().parent().parent();
            var onHand 				= $('#qtyOnHand').text();
            var out 				= $('#qty_out').val();
			var original_out_qty 	= $('#original_qty_out').val();
            var newVal  			= 0 ;
            if(original_out_qty > out)
			newVal 					= Number(onHand) + Number(original_out_qty - out) ;
			else 
			newVal 	= Number(onHand) - Number( out - original_out_qty) ;
			row.find('.variance_in_out_qty').text(out - $('#last_out_qty').text());
            $('#new_qty').text(newVal);
            $('#input1').val(newVal);
			$("#e_total").val($("#qty_out").val());
            if (newVal<0){
                row.find('.note').prop('required', true);
            }
            else {
                row.find('.note').prop('required', false);
            }
			recountLots();
        });
        $('.out').keyup(function(){
            var row = $(this).parent().parent().parent();
            var hand = row.find('.hand').text();
		    var out = row.find('.out').val();
			var original_out_qty 	= row.find('.original_qty_out_m_ndc').val();
            var newval = 0;
			if(Number(original_out_qty) > Number(out))
			newval 	= Number(hand) + Number(Number(original_out_qty) - Number(out));
			else 
			newval 	= Number(hand) - Number(Number(out) - Number(original_out_qty));
            var ndc = row.find('.ndc').text();
            row.find('.variance').text(newval);
            row.find('.input1').val(newval);
            if (newval<0){
                row.find('.note').prop('required', true);
            }
            else {
                row.find('.note').prop('required', false);
            }
            var id = row.attr('id');
            var row2 = $('#total'+id);
            row2.find('.qty_one').text(out);
            var sum = 0;
            $('.qty_one').each (function (i) {
				
                sum+= +$(this).text();
            });
			
            var total = $('#qty_all').text() - sum;
            $('#total').text(total);

			if (total == 0){
                $('#button').attr('value', 'Confirm Entry');
                $('#button').attr('onclick', '');
                $('#button').attr('type', 'submit');
               	$('#another2').show();
            } else {
                $('#button').attr('value', 'Add another NDC');
                $('#button').attr('onclick', 'openModal()');
                $('#button').attr('type', 'button');
                $('#another2').hide();
            }

			recountAllPossibleLotsCount();
        });
		
        $('#confirm1').mousedown(function(){
            $('#success_or_new1').val(0);
        });
        $('#another1').mousedown(function(){
            $('#success_or_new1').val(1);
        });
        $('#button').mousedown(function(){
            $('#success_or_new2').val(0);
        });
        $('#another2').mousedown(function(){
            $('#success_or_new2').val(1);
        });

		if (LOT_TRACKING) {
			if(NDC_TYPE == 0) // 0 means single NDC
			addNewLots();
			
		}
    });

    function openModal(){
        $('#Modal').modal();
    }
    function getDrugs(){
        jQuery.ajax({
            type: "POST",
            url: '<?=base_url()?>drug/get_drugs',
            data: jQuery('#modalForm').serialize(),
            cache: false,
            success: function(response){
                if (response.length>0) {
                    $('#selectDiv').removeClass('hidden');
                    $('#noResults').addClass('hidden');
                    $('#modalSelect').empty();
                    $.each(response, function(key, value) {
                        $('#modalSelect').append('<option value='+value.d_id+'>'+value.d_name+'</option>');
                        if (value.d_status == '0'){
                            $('#modal-go-button').prop('disabled', true);
                            $('#drugInactive').removeClass('hidden');
                        }
                        else {
                            $('#modal-go-button').prop('disabled', false);
                            $('#drugInactive').addClass('hidden');
                        }
                    });
                }
                else {
                    $('#noResults').removeClass('hidden');
                    $('#selectDiv').addClass('hidden');
                    $('#modal-go-button').prop('disabled', true);
                }
            },
            error: function(response) {              
            }
        });
    }

    $('#modal-go-button').click(function(event){
        jQuery.ajax({
            type: "POST",
            url: '<?=base_url()?>drug/get_drug',
            data: jQuery('#modalForm').serialize(),
            cache: false,
            success: function(response){
                console.log('success');
                console.log(response.d_lotTracking);
                var childRow = $('#table-table4').append();
                var lotCell = '';

				GLOBAL_DRUG_ID += 1;

                if (response.d_lotTracking == 1) {
                    lotCell = '<table id="lots_table_' + GLOBAL_DRUG_ID + '" class="table table-bordered"><thead><tr><td>Lot Number</td><td>Expiration Date</td><td>Lot QOH</td><td>Lot Qty Out</td><td>New Lot Qty Out</td><td>New Lot QQH</td><td>Variance</td><td>Remove</td></tr></thead><tbody id="add_lots_' + GLOBAL_DRUG_ID + '"></tbody></table>' + '<div><input type="button" class="btn btn-success" value="Add Lot" style="float: right" onclick="addNewLotsMulti(\'\', \'\',\'\', \'\', \'#add_lots_' + GLOBAL_DRUG_ID + '\', ' + response.d_id + ', ' + GLOBAL_DRUG_ID + ');"><div id="lots_total_count_' + GLOBAL_DRUG_ID + '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Lot Total: 0</b></div><div id="lots_remain_count_' + GLOBAL_DRUG_ID + '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Total Remaining: 0</b></div></div>';
                }

				childRow.append('<tr id="'+response.d_id+'">' +
				'<input type="hidden" value="'+response.d_id+'" name="e_drugId[]">' +
				'<input type="hidden" value="'+response.d_onHand+'" name="e_old[]">' +
				'<input class="input1" type="hidden" value="'+response.d_onHand+'" name="e_new[]">' +
				'<td class="ndc">'+response.d_code+'</td><td>'+response.d_name+'</td>' +
				'<td class="hand">'+response.d_onHand+'</td><td><div class="form-group">' +
				'<input id="e_out_' + GLOBAL_DRUG_ID + '" type="text" name="e_out[]" class="out form-control"></div></td>' +
				'<td>' + lotCell + '</td>' +
				'<td class="variance"></td>' +
				'<td><div class="form-group">' +
				'<input type="text" name="e_note[]" class="note form-control uppercase"></div></td></tr>');
				var childTotal = $('#total').parent().before('<tr id="total'+response.d_id+'"><td>'+response.d_code+'</td><td class="qty_one"></td></tr>');
				$('.lot_out').keyup(function(){
				var row = $(this).parent().parent();
				var out = row.find('.lot_out').val();
				row.find('.lot_variance').text(out - row.find('.lot_last_out_qty').text());
				row.find('.new_lot_qqh').text(row.find('.lot_old_qqh').text() - (out - row.find('.lot_last_out_qty').text()));
				
        		});
		
				$('.out').unbind();
				$('.save-form').data('bootstrapValidator', null);
				addNewLotsMulti('', '', '', '', '#add_lots_' + GLOBAL_DRUG_ID, response.d_id,GLOBAL_DRUG_ID );
				applyValidator();
				$('.out').keyup(function(){                 
				var row = $(this).parent().parent().parent();
				var hand = row.find('.hand').text();
				var out = row.find('.out').val();
				var newval = hand - out;
				var ndc = row.find('.ndc').text();
				row.find('.variance').text(newval);
				row.find('.input1').val(newval);
				if (newval<0){
				row.find('.note').prop('required', true);
				}
				else {
				row.find('.note').prop('required', false);
				}
				//console.log('out = '+out);
				var id = row.attr('id');
				var row2 = $('#total'+id);
				row2.find('.qty_one').text(out);
				var sum = 0;
				$('.qty_one').each (function (i) {
				sum+= +$(this).text();
				});
				var total = $('#qty_all').text() - sum;
				$('#total').text(total);
				if (total == 0){
				$('#button').attr('value', 'Confirm Entry');
				$('#button').attr('onclick', '');
				$('#button').attr('type', 'submit');
				}
				else {
				$('#button').attr('value', 'Add another NDC');
				$('#button').attr('onclick', 'openModal()');
				$('#button').attr('type', 'button');
				}
				
				recountAllPossibleLotsCount();
				});
				
				// re init
				initLotList(".e_lot");
				},
				error: function(response) {
				console.log('fail');
				//alert("Failed to save");  
				console.log(response);
				}
				});
			
    });

	function initDatePicker()
	{
		$('.datetimeST1').datetimepicker({
			pickDate: true,
			pickTime: false,
			format: 'MM/DD/YYYY'
		});
	}
	
    $('.datetimeST').datetimepicker({
        pickDate: true,
        pickTime: true,
        format: 'MM/DD/YYYY HH:mm',
        maxDate: new Date()
    });
</script>
<script>
	  
		function confirmDialog(transactionId) {
		
		var result = confirm("Are you sure you want to delete this record?");
		if (result == true)
		window.location = "<?=base_url()?>edit_transaction/reverse_transaction/"+ transactionId;
		else
		return false;	
		}
	
		function backButton() {
		window.location = "<?=base_url()?>logbook/dashboard";	
		}
	
		function showEdit() {
		$('#table1').removeClass('hidden');
		}
		
		$(function(){
		$('#history_row').on('hide.bs.collapse', function () {
		$('#show_hide').html('<span class="glyphicon glyphicon-plus section_head"> Transaction Details </span> ');
		})
		$('#history_row').on('show.bs.collapse', function () {
		$('#show_hide').html('<span class="glyphicon glyphicon-minus section_head"> Transaction Details </span>');
		})
})
	
</script>