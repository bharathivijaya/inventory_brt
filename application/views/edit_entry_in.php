<!-- Original Transaction -->
<div  class="row" id="history">
<div id="show_hide" data-toggle="collapse" data-target="#history_row">
 <h3>Transaction Details</h3>
</div>
<div class="row in" id="history_row">
  <table class="table table-striped table-hover entry-table" style="border:10px solid #f9f9f9;margin-top:0px;margin-bottom:0px;">
    <thead style="font-weight: bold">
      <tr>
        <td>Date/Time Entered</td>
        <td>Transaction Type</td>
        <td>RX/Trans/Invoice #</td>
        <td>Total Quantity <?= $original_transaction[0]->e_type == 'new' ? 'In' : 'Out' ?></td>
        <td>Username</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= date('m-d-Y H:m:s', $original_transaction[0]->e_date);?>
        </td>
        <td><?=strtoupper($original_transaction[0]->e_type == 'new' ?'in' : $original_transaction[0]->e_type) ?></td>
        <td><?=$original_transaction[0]->e_rx.$original_transaction[0]->e_invoice;?></td>
        <td><?= $original_transaction[0]->e_type == 'new' ? $original_transaction[0]->total_new_qty - $original_transaction[0]->total_old_qty : $original_transaction[0]->e_out_total;?></td>
        <td><?=$original_transaction[0]->username;?></td>
      </tr>
    </tbody>
  </table>
  <table class="table table-striped table-hover entry-table" style="border:10px solid #f9f9f9;margin-top:0px;margin-bottom:0px;">
    <thead style="font-weight: bold">
      <tr>
        <td>NDC</td>
        <td>Drug Name</td>
        <td>Drug Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
        <td>Lot #</td>
        <td>Expiration Date</td>
        <td>Quantity <?= $original_transaction[0]->e_type == 'new' ? 'In' : 'Out' ?></td>
        <?= $original_transaction[0]->e_type == 'new' ? '<td>Cost/Pack</td>' : '' ?>
		<td>Cost/Unit</td>
        <!--<td>Notes</td>-->
      </tr>
	
    </thead>
    
  <tbody>
    <?php $count = 0; setlocale(LC_MONETARY, 'en_US.UTF-8');foreach ($all_drugs as $drugs) { ?>
    <tr>
      <td><?=$drugs->d_code?>      </td>
      <td><?=$drugs->d_name?></td>
      <td><?=$drugs->d_descr?></td>
      <td><?=$drugs->d_size?></td>
      <td><?=$drugs->d_manufacturer?></td>
      <td><?=$drugs->e_lot?></td>
      <td><?=$drugs->e_expiration == 0 ? '' : date('m-d-Y', $drugs->e_expiration);?></td>
      <td><?=$drugs->e_out == 0 ? $drugs->e_new - $drugs->e_old : $drugs->e_out ?></td>
      <?= $original_transaction[0]->e_type == 'new' ? '<td>'. money_format('%.2n', $drugs->e_costPack) .'</td>' : '' ?>
	  <?php $units=$drugs->e_out == 0 ? $drugs->e_new - $drugs->e_old : $drugs->e_out ; 
	  $unitval=($drugs->e_costPack)/$drugs->d_size;
	// $unitval=0;?>
     <td><?=money_format('%.2n', $unitval)?></td>
      </tr>
    <?php $count++; } ?>
	<tr><td colspan=10><b>Notes:</b><?=$drugs->e_note?></td></tr>
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
		$totalqty =$totalqty+ $entry->e_new-$entry->e_old;
}
$qtyarr[$n]=$totalqty;
//echo "totalqty:".$totalqty;
//echo "one more:".$selected_transaction[0]->total_lots;
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
        <td colspan=3><?= $entry->e_type == 'new' ? $entry->e_new : $qtyarr[$i]; ?></td>
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
        <!--<td>Notes</td>-->
		<td>Cost/Pack</td>
		<td>Cost/Unit</td>
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
      
        <td><?php echo $entry->e_new-$entry->e_old; ?></td>
       
    
         <td><?php  if ($entry->e_last_edit_date == 0) {
                echo 0;
            } else {
                echo date('m-d-Y', $entry->e_last_edit_date);
            } ?>
        </td>      
		<td><?=$entry->e_costPack?></td>
	  <?php $units=$drugs->e_out == 0 ? $drugs->e_new - $drugs->e_old : $drugs->e_out ; 
	  $unitval=($entry->e_costPack)/$drugs->d_size;
	// $unitval=0;?>
     <td><?=money_format('%.2n', $unitval)?></td>
<!--  <td><?php if($entry->e_status==0) echo "InActive";
  if($entry->e_status==1) echo "Active";
  if($entry->e_status==2) echo "Edited";
    if($entry->e_status==3) echo "Deleted";
  ?>-->
       <!-- <td> <?php echo $entry->e_note; ?></td>      -->
        </tr>
      <?php $tran_group_id = $entry->e_transaction_group_id;  }?>
    </tbody>
	</table>
  </table>
</div>
<?php }?>


<div class="form-group" style="margin-top:10px;">
  <table><tr>
    <td><input  type="submit" value="Edit Transaction" onclick="showEdit();" class="btn btn-primary"/> </td>
<td>    <input  type="submit" value="Reverse Transaction" onclick="confirmDialog('<?php echo $transaction_id; ?>');" class="btn btn-primary"/>      </td>    <?php if(isset($_POST['fromdashboard']) && $_POST['fromdashboard']==1) { ?><td><input  type="submit" value="Back" onclick="backButton(1);" class="btn btn-primary"></td>
	<?php } else { ?><td><input  type="submit" value="Back" onclick="backButton(0);" class="btn btn-primary"></td><?php } ?>
	<form>
<td><input type="button" onclick="printDiv1('history')" value="Print" class="btn btn-primary" /></td>
</tr>
</form></table>
  </div>

<div class="row hidden" id="table1">
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
        <td><?=$drug['d_code']; ?></td>
        <td><?=$drug['d_name'];?></td>
        <td><?=$drug['d_descr'];?></td>
        <td><?=$drug['d_size']?></td>
        <td><?=$drug['d_manufacturer']?></td>
        <td><?=$drug['d_schedule']?></td>
        <td id="qtyOnHand"><?=$drug['d_onHand']?></td>
       <!-- <td> <a id="changeDrug" href="#a">Change Drug</a> </td>-->
      </tr>
    </tbody>
  </table>
 
  <input style="margin-bottom: 10px;" type="button" id="button1" onclick="show_table(2)" value="Inventory In" class="btn btn-info">

</div>


    <div  class="row hidden" id="table2">
    <form action="<?=base_url()?>edit_transaction/edit_entry/<?php echo $transaction_id; ?>" onsubmit="return checkForm('#form2');" method="post" id="form2">
        <input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId">
        <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">
		<input type="hidden" value="<?=$parent_id ?>" name="e_parent_id">
       <input type="hidden" id="e_old_units_added" value="<?= $drug['d_size']* $selected_transaction[0]->e_numPacks;?>" name="e_old_units_added">
		<input type="hidden" value="new_mul" name="e_type">
        <input type="hidden" id="input1" name="e_new">
		<input type="hidden" value="<?=$selected_transaction[0]->total_lots; ?>" name="e_total_lots">
        <input type="hidden" id="e_total" name="e_total">
	 <input type="hidden" id="e_original_entry_id" name="e_original_entry_id" value="<?=$selected_transaction[0]->e_original_entry_id;?>">
	 <input type="hidden" id="e_id" name="e_id" value="<?=$selected_transaction[0]->e_id;?>">
        <input type="hidden" id="e_operator" name="e_operator" value="+">

        <input type="hidden" value="0" name="add_new" id="success_or_new1">

		<table class="table table-bordered entry-table ">
			<thead>
			<tr>
				<td>Date</td>
				<td>Invoice #</td>
				<td class="wide-td">Vendor</td>
				<td>Package Size</td>
				<td>Quantity on hand</td>
				<td class="narrow-td"># of packs</td>
				<td>Total Units</td>
				<td class="narrow-td">Acq Cost/Pack</td>
				<td>Acq Cost/Unit</td>
				<!--<td>Lot #</td>
				<td>Expiration</td>-->
				<td>New Quantity on Hand</td>
				<td>Notes</td>
			</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="form-group"><input type="text" name="e_date" class="form-control  datetimeST1 " 
                        value="<?php echo date('m-d-Y', $selected_transaction[0]->e_date) ?>" id="date2" required ></div>
					</td>
					<td>
						<div class="form-group"><input type="text" name="e_invoice" onkeyup="checkInvoice(this.value);" 
                        value="<?php echo $selected_transaction[0]->e_invoice; ?>" class="form-control uppercase" required ></div>
					</td>
					<td>
						<div class="form-group">
						<select name="e_vendorId" class="form-control">
							<? foreach ($vendors as $one) { ?>
                            <? if($one['v_id']== $selected_transaction[0]->e_vendorId) { ?>
							<option selected="selected" value="<?=$one['v_id']?>"><?=$one['v_name']?></option>
                            <? } else { ?>
                            <option  value="<?=$one['v_id']?>"><?=$one['v_name']?></option>
							<? } } ?>
						</select>
						</div>
					</td>
					<td id="size"><?= $drug['d_size'] ?></td>
					<td id="onHand"><?= $drug['d_onHand'] ?></td>
					<td>
						<div class="form-group"><input type="text" name="e_numPacks" class="form-control" 
                        value="<?php echo $selected_transaction[0]->e_numPacks; ?>" id="numPacks" required></div>
					</td>
					<td id="units"></td>
					<td>
						<div class="form-group"><input type="text" name="e_costPack" class="form-control" 
                        value="<?php echo $selected_transaction[0]->e_costPack ; ?>" id="costPack" required></div>
					</td>
					<td id="costUnit"></td>
					<td id="new_onHand"></td>
					<td>
						<div class="form-group"><input type="text" name="e_note" class="form-control uppercase"></div>
					</td>
				</tr>
        	</tbody>
    	</table>
        <div style="width: 75%">
            <table id="audit_lots_table" class="table table-bordered">
                <thead>
                    <tr>
					<td>Select Lot Number</td>
                        <td>Lot Number</td>
                        <td>Expiration Date</td>
                        <td>Lot QOH</td>
                        <td>Lot Qty In</td>
                        <td>New Lot Qty In</td>
                        <td>New Lot QOH</td>
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
		<b id="erx_warning2" style='display: none; color: #FF0000;'>Warning! There is the same RX/Transaction number in the system</b>
		<br/>
        <input style="margin-bottom: 10px;" type="submit" value="Confirm" class="btn btn-primary" id="confirm_1" >
		<button style="margin-bottom: 10px;" type="submit" class="btn btn-success" name="add_another_in" id="another_1">Confirm & Add Another</button>
		<!--<input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots();">-->
    </form>
    </div>

    <div class="row hidden" id="table3">
        <form action="<?=base_url()?>edit_transaction/edit_entry/<?php echo $transaction_id; ?>" onsubmit="return checkForm('#form3');" method="post" id="form3">
            <input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId">
            <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">
            <input type="hidden" value="return_mul" name="e_type">
            <input type="hidden" value="<?=$parent_id ?>" name="e_parent_id">
            <input type="hidden" value="<?=$selected_transaction[0]->total_lots; ?>" name="e_total_lots">
            <input id="input2" type="hidden" name="e_new" value="">
            <input type="hidden" name="e_operator" value="-">
            <input type="hidden" name="e_total" value="">
            <input type="hidden" value="0" name="add_new" id="success_or_new2">
            <table class="table table-bordered entry-table ">
                <thead>
                <tr>
                    <td>Date</td>
                    <td>RX/Transaction #</td>
                    <td>Package Size</td>
                    <td>Quantity on hand</td>
                    <td>Units Returned</td>
                    <td>New Quantity on Hand</td>
                    <!--<td>Lot #</td>
                    <td>Expiration Date</td>-->
                    <td>Notes</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="form-group"><input type="text" name="e_date" class="form-control  datetimeST1" id="date3"
                        value="<?php echo date('m-d-Y', $selected_transaction[0]->e_date) ?>"  required></div>
                    </td>
                    <td>
                        <div class="form-group"><input type="text" name="e_rx" onkeyup="checkRX_Transaction(this.value);" 
                        value="<?php echo $selected_transaction[0]->e_rx; ?>" class="form-control uppercase"  required></div>
                    </td>
                    <td id="size"><?= $drug['d_size'] ?></td>
                    <td id="onHand2"><?= $drug['d_onHand'] ?></td>
                    <td id="returned">
                        <div class="form-group"><input type="text" id="e_returned" name="e_returned" onkeyup="$('#form3 input[name=e_total]').val(this.value * 1)" class="form-control" required></div>
                    </td>
                    <td id="new_onHand2"></td>
                  
					<td>
						<div class="form-group"><input type="text" name="e_note" class="form-control uppercase" required></div>
					</td>
                </tr>
                </tbody>
            </table>
            <div style="width: 75%">
                <table id="return_lots_table" class="table table-bordered">
                    <thead>
                    <tr>
                        <td>Lot Number</td>
                        <td>Expiration Date</td>
                        <td>Lot QOH</td>
                        <td>Lot Qty In</td>
                        <td>New Lot Qty In</td>
                        <td>New Lot QOH</td>
                        <td>Variance</td>
                        <td>Remove</td>
                    </tr>
                    </thead>
                    <tbody id="add_return_lots">

                    </tbody>
                </table>
                <input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_2" onclick="addNewLots('', '', '', '', 'return');" style="float: right; padding: 10px;"><br><br>
                <div id="lots_return_total_count" style="text-align: right; padding: 5px;"><b>Lot Total: 0</b></div>
                <div id="lots_return_remain_count" style="text-align: right; padding: 5px;"><b>Total Remaining: </b></div>
            </div>
			<b id="erx_warning" style='display: none; color: #FF0000;'>Warning! There is the same RX/Transaction number in the system</b>
			<br/>
            <input type="submit" value="Confirm" class="btn btn-primary" id="confirm_2">
            <button type="submit" class="btn btn-success" name="add_another_in" id="another_2">Confirm & Add Another</button>
        </form>
    </div>

<script>
 function printDiv1(divName) {
		 // var detaildivcontent = document.getElementById('detaildiv').innerHTML;
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML =   printContents ;

     window.print();

     document.body.innerHTML = originalContents;
	
}
	var LID = 0;
	var FIRST_OPEN_ADDLOTEXPDATE = false;
	var LOTS = <?= json_encode($lots_data) ?>;
	var FIRST_LOT_ADDED = false;

    $('#date2').change(function() {
        $('#form2').bootstrapValidator('revalidateField', 'e_date');
        //applyValidator();
    });

    $('#date3').change(function() {
        $('#form3').bootstrapValidator('revalidateField', 'e_date');
        //applyValidator();
    });

    $('#date4').change(function() {
        $('#form2').bootstrapValidator('revalidateField', 'e_expiration');
        //applyValidator();
    });

	function recountLots()
	{
		var TOTAL_QOH = 0;
		var TOTAL_UNITS = $("#units").html() * 1;
		var TOTAL_RETURNED = $("#e_returned").val() * 1;

		//console.log(TOTAL_UNITS);

		$('.audit_qohs').each(function(i)
		{
			TOTAL_QOH += +$(this).val();
		});
        var REMAIN_NEW = TOTAL_UNITS - TOTAL_QOH;
        var REMAIN_RET = TOTAL_RETURNED - TOTAL_QOH;

		$("#lots_total_count").html("<b>Lot Total: " + TOTAL_QOH + "</b>");
        $("#lots_remain_count").html("<b>Total Remaining: " + REMAIN_NEW + "</b>");
		$("#lots_return_total_count").html("<b>Lot Total: " + TOTAL_QOH + "</b>");
        $("#lots_return_remain_count").html("<b>Total Remaining: " + REMAIN_RET + "</b>");

		if (TOTAL_QOH == TOTAL_UNITS) checkAndLockButtons(false, 1);
		else checkAndLockButtons(true, 1);

		if (TOTAL_QOH == TOTAL_RETURNED) checkAndLockButtons(false, 2);
		else checkAndLockButtons(true, 2);
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

	function checkRX_Transaction(code)
	{
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url('logbook/checkLotRXCode');?>",
			data: {
				"e_code": code
			},
			cache: false,
			success: function(response){
				if (response == "true")
				{
					$("#erx_warning").css("display", "block");
				} else {
					$("#erx_warning").css("display", "none");
				}
			},
			error: function(response) {

			}
		});
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
		
		for (var i = 0; i < lots.length; i++) {
			if(lots[i].lotName !='' )
			addNewLots(lots[i].lotName, lots[i].expirationDate, lots[i].count);
			}
	}
var LOTS2 = <?= json_encode($lots_data) ?>;

	function showdetails(lid){
	
		var lotcode=$('#lotnobrt_'+lid).val();
	
	if(lotcode=='newlot') { //alert("New Lot"); 
		$("#elot_warning_"+lid).css("display", "none");
		$("#elot_" + lid).val("");
					$("#edate_" + lid).val("");
					$("#oldqoh_" + lid).html("");
					$("#oldqoh_f_" + lid).val("");
			}
	else
	{
$("#elot_warning_"+lid).css("display", "none");	var ret=checkalready(lotcode,lid);
if(ret==1) { checkLotNumber(lotcode,lid);
for (var i = 0; i < LOTS2.length; i++) {
			if (LOTS2[i].lotName == $('#lotnobrt_'+lid).val()) {
				$("#elot_" + lid).val(LOTS2[i].lotName);
				var timestamp = moment.unix(LOTS2[i].expirationDate);
			//	$("#e_expiration").val(timestamp.format("MM/DD/YYYY"));
					$("#edate_" + lid).val(timestamp.format("MM/DD/YYYY"));
					$("#oldqoh_" + lid).html(LOTS2[i].count);
					//$("#oldqoh_brt_" + lid).val(LOTS2[i].count);
					$("#oldqoh_f_" + lid).html(LOTS2[i].count);
					
			}
		}
	}
	else
		{
		$("#elot_warning_"+lid).css("display", "none");
		$("#elot_" + lid).val("");
					$("#edate_" + lid).val("");
					$("#oldqoh_" + lid).html("");
					$("#oldqoh_f_" + lid).val("");
		return false;
		}
	}
	
	}
	function checkalready(code,lid)
	{
			for(var i=0;i<lid;i++)
		{ 
			if(i==lid) continue;
			if(i==2) continue;
			if($("#elot_"+i).val() == code)
			{
				alert("Not allowed");
			return 0;
			}
		}
		return 1;
	}
	function checkalready1(code,lid)
	{
	alert(code);
	alert(lid);
	alert("checkalready fn");
		for (var i = 0; i < LOTS2.length; i++) {
			if (LOTS2[i].lotName == $('#elot_'+lid).val()) {

				alert("Not Allowed");
				return 0;
			}
		}
		return 1;
	}
	function checkLotNumber(code,lid)
	{
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url('logbook/checkLotNumber');?>",
			data: {
				"e_code": code
			},
			cache: false,
			success: function(response){
					//alert(response);
				if (response == "true")
				{
					$("#elot_warning_"+lid).css("display", "block");
					

				} else {
					$("#elot_warning_"+lid).css("display", "none");
				}
			},
			error: function(response) {

			}
		});
	}
	function addNewLots()
	{
		
		<?php if(@$drug["d_lotTracking"]) { ?>
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

		var to_field = "#add_lots";
		

		if (where == "return") to_field = "#add_return_lots";
		
		//here pickout the qty_out and lot_number from original transaction to autoselect the data in lots
		var entry 			= <?= json_encode($selected_transaction) ?>;
		var lot_name 		= e_lot;
		var lot_names_array = lot_name.split('-');
		var lot_number      = '';
		var qty_out      	= '';
		//alert("lot length:"+entry.length);
		for (var i = 0; i < entry.length; i++) 
		{
			//alert(entry[i].e_lot);
			if(entry[i].e_lot == lot_names_array[0])
			{
			  qty_out 		= Number(entry[i].e_new)- Number(entry[i].e_old) ;
			  lot_number 	= entry[i].e_lot;
			}		
		}

		var select_lot_ddl = lot_number !='' ? 'readonly' : '';

		$(to_field).append('<tr id="lotrow_' + LID + '">' +
			'<td><select name="lotnobrt_'+LID+'" id="lotnobrt_'+LID+'" class="form-control" onchange="showdetails('+LID+');"><option value="" selected disabled>Select</option><option value="newlot">Add New Lot</option><?php foreach($lots_data as $lot) { if($drug["d_id"]==$lot["drugId"])  { ?><option value="<?php echo $lot["lotName"]; ?>"><?php echo $lot["lotName"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("m-d-Y",$lot["expirationDate"]);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lot["count"];?><?php } } ?></td>'+
		'<td><div class="form-group"><input ' +  select_lot_ddl + ' type="text" lid="' + LID + '" id="elot_' + LID + '" name="audit_lot[]" class="e_lot form-control" value="' + lot_number + '" required onkeyup="fn('+LID+')"/>  <input type="hidden" id="e_lot_original_' + LID + '" name="original_lot[]"  value="' + lot_number + '" /><span style="font-size: 85%; color: #B94A48;"></span></div><b id="elot_warning_' + LID + '" style="display: none; color: #FF0000;">Warning! You are adding to an existing Lot Lumber in the system</b></td>' +
		'<td><input ' +  select_lot_ddl + ' type="text" id="edate_' + LID + '" name="audit_expiration[]" class="e_date form-control datetimeST3" value="' + e_date + '" required/><span style="font-size: 85%; color: #B94A48;"></span></td>' +
		'<td><div class="lot_old_qqh" id="oldqoh_' + LID + '">' + e_qoh + '</div><input  id="oldqoh_f_' + LID + '" name="audit_oldqoh[]" type="hidden" value="' + e_qoh + '"></td> <td class="lot_last_out_qty">'+ qty_out +'</td> ' +
		'<td> <input type="hidden" name="e_original_out[]"  value="' + qty_out + '" /> <input type="text" name="audit_qoh[]" onkeyup="recountLots()" class="lot_out audit_qohs form-control" value="' + qty_out + '" required/><span style="font-size: 85%; color: #B94A48;"></span></td>' +
		'<td  class="new_lot_qqh"></td>'+
		 '<td  class="lot_variance"></td>'+
		'<td><a href="javascript://void();" onclick="removeLotsFromTable(' + LID + ');">remove</a></td>' +
		'</tr>');
		
		$('.lot_out').keyup(function(){
				var row = $(this).parent().parent();
				var out = row.find('.lot_out').val();
				var lastOutqty = row.find('.lot_last_out_qty').text();	
				if(lastOutqty == '')
				{
				row.find('.lot_variance').text(out);
				row.find('.new_lot_qqh').text(Number(row.find('.lot_old_qqh').text()) + Number(out));
				}
				else
				{
				row.find('.lot_variance').text(out - lastOutqty);
				row.find('.new_lot_qqh').text(Number(row.find('.lot_old_qqh').text()) + Number(out - lastOutqty));
				}	
				
        });
		
		initLotList(".e_lot");
		initDatePicker();
		FIRST_LOT_ADDED = true;
		$('#form2').bootstrapValidator('revalidateField', 'audit_lot[]');
		
	}
	function fn(lid)
	{
		//alert("keyup");
//alert($("#elot_" + lid).val());
var code=$("#elot_" + lid).val();
//(code);
//alert(lid);
var ret=checkalready1(code,lid);
if(ret==0) {
$("#elot_" + lid).val("");
					$("#edate_" + lid).val("");
					$("#oldqoh_" + lid).html("");
					$("#oldqoh_f_" + lid).val("");
		return false;
}
	}

	function checkInvoice(code)
	{
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url('logbook/checkInvoice');?>",
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

    function show_table(id) {
        var table = $('#table'+id);
		//show transaction history table when table 1 get visible
		if(id == 1)
		$('#history').removeClass('hidden');
		
		$('#numPacks').keyup();
		$('#costPack').keyup();
		
        table.removeClass('hidden');
        $('#inputNdc').attr('disabled', true);
        $('#button0').attr('disabled', true);
        if (id == 2){
            $('#button2').attr('disabled', true)
        }
        else if (id == 3){
            $('#button1').attr('disabled', true)
        }
    }

	var LOTS = <?= json_encode($lots_data) ?>;

	initLotList(".e_lot");

	function autoFillLotDateByReturnStock(lotName)
	{
		for (var i = 0; i < LOTS.length; i++) {
			if (LOTS[i].lotName == lotName) {
				var timestamp = moment.unix(LOTS[i].expirationDate);
				$("#e_expiration").val(timestamp.format("MM/DD/YYYY"));
			}
		}
	}

	function removeLotsFromTable(id)
	{
		$("#lotrow_" + id).remove();
	}

	function initLotList(field)
	{
		$(field).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "<?php echo site_url('logbook/getJSON_lotsEditTransaction/with_date_and_count');?>",
					dataType: "json",
					data: {
						q: request.term,
						drugId: <?= $drug["d_id"] ?>
					},
					success: function( data ) {
						response(data);
						//console.log(data.responseText);
					},
					error: function( data ) {
						console.log(data.responseText);
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

	function checkForm(form)
	{
		<?if (@!$drug["d_lotTracking"]) { ?>
		return true;
		<? } ?>

		var brk = false;

		$(form + " .e_lot, " + form + " .e_date, " + form + " .audit_qohs").each(function(index, element) {
			$(element).parent().removeClass("has-error");

			$(element).parent().find("span").html("");

			if ($(element).val() === "")
			{
				$(element).parent().addClass("has-error");
				$(element).parent().find("span").html("Field is required and cannot be empty");
				brk = true;
			}
		});

		return !brk;
	}

    function applyValidator(){
        $('#form2').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			excluded: ':disabled',
            fields: {
                e_costPack: {
                    message: 'Cost/Pack is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Cost/Pack is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9\.]+$/,
                            message: 'Cost/Pack can only consist of numerical characters'
                        }
                    }
                },
                e_numPacks: {
                    message: '# of packs is not valid',
                    validators: {
                        notEmpty: {
                            message: '# of packs is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9.]+$/,
                            message: '# of packs can only consist of numerical characters'
                        }
                    }
                },
				<?if (@$drug["d_lotTracking"]) { ?>
				"audit_lot[]": {
					message: 'Lot is not valid',
					validators: {
						notEmpty: {
							message: 'Lot is required and cannot be empty'
						}
					}
				}
				<? } ?>
            }
        });

        $('#form3').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e_returned: {
                    message: 'Units Returned is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Units Returned is required and cannot be empty'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Units Returned can only consist of numerical characters'
                        }
                    }
                }
            }
        });
    }
function backButton(dbval) {
			if(dbval==0)
		window.location = "<?=base_url()?>edit_transaction/index";	
		else
			window.location="<?=base_url()?>logbook/dashboard";
		}
    $(document).ready(function()
	{
		applyValidator();

        $('#confirm1').mousedown(function(){
            $('#success_or_new1').val(0);
        });

        $('#another1').mousedown(function(){
            $('#success_or_new1').val(1);
        });

        $('#confirm2').mousedown(function(){
            $('#success_or_new2').val(0);
        });

        $('#another2').mousedown(function(){
            $('#success_or_new2').val(1);
        });

        $('#numPacks').keyup(function(){
            //var row = $(this).parent().parent().parent();
            var units 	    = $('#units');
            var num 		= $('#numPacks').val();
            var size 		= $('#size').text();
			var e_old_units_added = $('#e_old_units_added').val();
			var total_qty = num * size;
            units.text(total_qty);
			$("#e_total").val(total_qty);

            var old = $('#onHand').text();
            old = parseFloat(old);
			var newVal = 0;
			if(e_old_units_added > total_qty)
			 newVal = old - Number(e_old_units_added - total_qty);
			else
			 newVal = old + Number(total_qty - e_old_units_added);
            $('#input1').val(newVal);
			$('#new_onHand').text(newVal);

			recountLots();
        });

        $('#costPack').keyup(function(){
            //var row = $(this).parent().parent();
            var costU = $('#costUnit');
            var costP = $('#costPack').val();
            var size = $('#size').text();
            var number = costP/size;
            costU.text('$'+number.toFixed(2));

        });

        $('#returned').keyup(function(){
            //var row = $(this).parent().parent();
            var newHand = $('#new_onHand2');
            var returned = $('#returned').children().children().val();
            var old = $('#onHand2').text();
            newHand.text(parseFloat(old)+parseFloat(returned));
            $('#input2').attr('value',parseFloat(old)+parseFloat(returned));

			recountLots();
        });
		
		$('.lot_out').keyup(function(){
				var row = $(this).parent().parent();
				var out = row.find('.lot_out').val();
				var lastOutqty = row.find('.lot_last_out_qty').text();				
				if(lastOutqty == '')
				{
				row.find('.lot_variance').text(out);
				row.find('.new_lot_qqh').text(Number(row.find('.lot_old_qqh').text()) + Number(out));
				}
				else
				{
				row.find('.lot_variance').text(out - lastOutqty);
				row.find('.new_lot_qqh').text(Number(row.find('.lot_old_qqh').text()) + Number(out - lastOutqty));
				}	
        });

		initDatePicker();
		
		<?if (@$drug["d_lotTracking"]) { ?>
		addNewLots();
		addNewLots('', '', '', '', 'return');
		<? } ?>
    });

	function initDatePicker()
	{
		$('.datetimeST3').datetimepicker({
			pickDate: true,
			pickTime: false,
			format: 'MM/DD/YYYY'
		});
	}

	$('.datetimeST1').datetimepicker({
		pickDate: true,
		pickTime: true,
		format: 'MM/DD/YYYY HH:mm',
		maxDate: new Date()
	});

    $('.datetimeST2').datetimepicker({
        pickDate: true,
        pickTime: false,
        format: 'MM/DD/YYYY',
        minDate: '<?=date('m/d/Y', strtotime('today'))?>'
    });

	$('.datetimeST3').datetimepicker({
		pickDate: true,
		pickTime: false,
		format: 'MM/DD/YYYY'
	});
</script>

<script>
	  
		function confirmDialog(transactionId) {
		
		var result = confirm("Are you sure you want to delete this record?");
		if (result == true)
		window.location = "<?=base_url()?>edit_transaction/reverse_in_transaction/"+ transactionId;
		else
		return false;	
		}
	
		function backButton() {
		window.location = "<?=base_url()?>edit_transaction/index";	
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

