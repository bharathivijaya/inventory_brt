<script>
function check()
{
		$('#multiDiv_e_date').datetimepicker({
		pickDate: true,
		pickTime: true,
		format: 'MM/DD/YYYY HH:mm',
		maxDate: new Date(),
	onSelect : function(x, u){
 $(this).focus(); 
   $(this).datepicker("hide");     
},
onClose: function(e){
e.preventDefault();
}
});
}
function checkInvoice(code)
	{
		jQuery.ajax({
			type: "POST",
			url: "<?php echo site_url('/logbook/checkInvoice');?>",
			data: {
				"e_code": code
			},
			cache: false,
			success: function(response){
					alert("success");
				if (response == "true")
				{
					$("#erx_warning").css("display", "block");
					$("#erx_warning2").css("display", "none");
				} else {
					$("#erx_warning").css("display", "none");
					$("#erx_warning2").css("display", "none");
				}
			},
			error: function(response) {

			}
		});
	}

function showsinglendc_block(){
	//alert("single");
	document.getElementById('singlendc_block').style.display="block";
		document.getElementById('multiplendc_block').style.display="none";
		document.getElementById('multiplendc_block1').style.display="none";
		//hide_table(4);
		  $('#button2_1').attr('disabled', true);
}
function showmultiplendc_block(){
//alert("multi");
	  $('#button1_1').attr('disabled', true);
	document.getElementById('singlendc_block').style.display="none";
		document.getElementById('multiplendc_block').style.display="block";
		//	document.getElementById('multiplendc_block1').style.display="block";
		check();
		hide_table(1);
		hide_table(2);
		hide_table(3);
	
		}
	
	function checkMultiForm(form)
	{
		
		/*<?if (@!$drug["d_lotTracking"]) { ?>
		return true;
		<? } ?>*/

		var brk = false;
if($('#multiDiv_e_date').val()=="" || $('#multiDiv_e_rx').val()=="" || $('#multiDiv_v_name').val()=="") { brk=true;$("#vals_warning").css("display", "block");}
		
if(brk==false) { $("#vals_warning").css("display", "none");
$('#multiplendc_block').css("display","block");
$('#multiplendc_block1').css("display","block");
 $('#ndc').attr('disabled', false);
	    $('#button0').attr('disabled', false);
	show_table(1);
	//show_table(2);
		//show_table(4);
		//return brk;
	}
	}
	    function show_table1(idval) {
		
		if(idval==2) {
			  $('#button2_1').attr('disabled', true);

	$("#singlendc_block").css("display", "block");
	$("#multiplendc_block").css("display","none");
	$("#multiplendc_block1").css("display","none");
	  $('#ndc').attr('disabled', false);
	    $('#button0').attr('disabled', false);
		}
		if(idval==4) {
	$("#singlendc_block").css("display", "none");
	$("#multiplendc_block").css("display","block");
	
		}
      
      
       
    }
	function showbulkuploaddiv()
	{
			$("#bulkuploaddiv").css("display","block");
				$("#singlendc_block").css("display", "none");
					$("#multiplendc_block").css("display","none");
	$("#multiplendc_block1").css("display","none");
	}
</script>
<h2>Inventory In</h2>

<div class="row">
 <input type="button" id="button1_1" onclick="show_table1(2)" value="Single NDC" class="btn btn-info">
  <input type="button" id="button2_1" onclick="showmultiplendc_block()" value="Multiple NDC" class="btn btn-success">
	<!--<input id="singlendc_but" type="button" value="Single NDC1" class="btn btn-primary" onclick="show_table(2);">
		<input id="multiplendc_but" type="button" value="Multiple NDC1" class="btn btn-primary" onclick=" show_table(3);">-->
	<input id="bulkupload_but" type="button" value="Bulk Upload" class="btn btn-primary" onclick="showbulkuploaddiv() "></div>
<br/>


<div id="bulkuploaddiv" style="display:none;">
 <form action="<?php echo base_url();?>logbook/upload" method="post" class="smallform" enctype="multipart/form-data">
        <div class="form-group">
		<input type="text" name="drug_id" value="<?=@$drug['d_code']?>">
            <input type="file" name="file">
        </div>

        <input type="submit" class="btn btn-primary" value="Upload">
    </form>
</div>
<div id="multiplendc_block" style="display:none;width: 50%;">
	<form name="multiform" id="multiform" action="" method="post" class="form-inline" >
  <table class=" table table-bordered entry-table">   <tr><td>Date</td><td>Rx/ Trans /Invoice #</td>
  <td>Vendor</td></tr>
   <tr><td>	<div class="form-group"><input type="text" name="multiDiv_e_date" class="form-control  datetimeST1" id="multiDiv_e_date"  value="<?php echo $multi_e_date;?>" required ></div>
	</td>
  	<td>	<div class="form-group"><input type="text" name="multiDiv_e_rx" class="form-control  " id="multiDiv_e_rx" onkeyup="checkInvoice(this.value);"  value="<?php echo $multi_e_rx;?>" required ></div>
							<b id="erx_warning" style='display: none; color: #FF0000;'>Warning! There is the same RX/Trans/Invoice number in the system</b>

	</td>
  <td>
						<div class="form-group">
						<select name="multiDiv_v_name" id="multiDiv_v_name" class="form-control">
							<? foreach ($vendors as $one) { ?>
                           <? if($multi_v_name!="") {?><option value="<?php echo $multi_v_name;?>"><?php echo $multi_v_name;?></option>
						   <?php } ?>
							<option value="">Select Vendor</option>
                            <option  value="<?=$one['v_id']?>"><?=$one['v_name']?><?=$one['v_id']?></option>
							<? }  ?>
						</select>
						</div>
					</td>
							<b id="vals_warning" style='display: none; color: #FF0000;'>Please provide all the values</b>

	  </tr></table><input type="button" id="multindc" name="multindc" value="ADD NDC"  class="btn btn-primary" onclick="checkMultiForm('#multiform');">




<div id="multiplendc_block1" style="display:none;">
<? if (@!$auditForce) { ?>
	
		<div class="form-group">
			<label>Multiple NDC</label>
		</div>
		<input type="hidden" name="ndctype" id="ndctype" value="multi">
		<div class="form-group">
			<input id="ndc" type="text" name="ndc" class="form-control" data-mask="99999-9999-99" value="<?=@$drug['d_code']?>">
		</div>
		<div class="form-group">
			<input id="multi_button0" type="submit" value="Go" class="btn btn-primary" >
		</div>
	</form>
<? } else { ?>
	<p>You have to make audit for this drug!</p>
<? } ?>
</div>
<?if (@empty($drug)&&($first == false)){?>
    <p>There are no drugs with specified NDC.</p>
    <a href="<?=base_url()?>drug/add_drug" target="_blank" class="btn btn-primary">New drug</a>
<?} else if (!@empty($drug) ){?>

    <label><?=$drug['d_name']?><? if($drug['d_status'] == '0'){ echo ': Inactive';}?></label><br>

    <button class="btn btn-primary" onclick="<?php if($ndctype=="multi") echo "show_table(1);show_table(2);"; else echo "show_table(1)";?>" <? if($drug['d_status'] == '0'){ echo 'disabled';}?>>Continue <?php if($ndctype=="multi") echo "show_table(1,4)"; else echo "show_table(1)";?></button>
    <a href="<?=base_url()?>logbook/" class="btn btn-danger">Cancel</a>

	<?php } ?>
</div>





<!--single ndc block start here-->
<div id="singlendc_block" style="display:none;">
<? if (@!$auditForce) { ?>
	<form action="" method="post" class="form-inline">
		<div class="form-group">
			<label>Single NDC</label>
		</div>
		<input type="hidden" name="ndctype" id="ndctype" value="single">
		<div class="form-group">
			<input id="ndc" type="text" name="ndc" class="form-control" data-mask="99999-9999-99" value="<?=@$drug['d_code']?>">
		</div>
		<div class="form-group">
			<input id="button0" type="submit" value="Go" class="btn btn-primary" >
		</div>
	</form>
<? } else { ?>
	<p>You have to make audit for this drug!</p>
<? } ?>

<?if (@empty($drug)&&($first == false)){?>
    <p>There are no drugs with specified NDC.</p>
    <a href="<?=base_url()?>drug/add_drug" target="_blank" class="btn btn-primary">New drug</a>
<?} else if (!@empty($drug)){?>

    <label><?=$drug['d_name']?><? if($drug['d_status'] == '0'){ echo ': Inactive';}?></label><br>

    <button class="btn btn-primary" onclick="show_table(1)">Continue</button>
    <a href="<?=base_url()?>logbook/" class="btn btn-danger">Cancel</a>
</div>

    <div class="row hidden" id="table1">
            <table class=" table table-bordered entry-table">table1
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
                <tr id="<?=$drug['d_id']?>">
                    <td><?=$drug['d_code']?></td>
                    <td><?=$drug['d_name']?></td>
                    <td><?=$drug['d_descr']?></td>
                    <td><?=$drug['d_size']?></td>
                    <td><?=$drug['d_manufacturer']?></td>
                    <td><?=$drug['d_schedule']?></td>
                    <td><?=$drug['d_onHand']?></td>
                </tr>
                </tbody>
            </table>
			<?php if($ndctype!="multi") { ?>
            <input type="button" id="button1" onclick="show_table(2)" value="Inventory In" class="btn btn-info">
			 <input type="button" id="button2" onclick="show_table(3)" value="Return to Stock" class="btn btn-success">
			<?php } ?>
           
    </div><!--row-->

    <div  class="row hidden" id="table2">table2
    <form action="<?=base_url()?>logbook/save" onsubmit="return checkForm('#form2');" method="post" id="form2">
        <input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId">
        <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">

		<input type="hidden" value="new_mul" name="e_type">
        <input type="hidden" id="input1" name="e_new">

        <input type="hidden" id="e_total" name="e_total">
        <input type="hidden" id="e_operator" name="e_operator" value="+">

        <input type="hidden" value="0" name="add_new" id="success_or_new1">

		<table class="table table-bordered entry-table " id="table-table2">
			<thead>Table2
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
			<tbody>Table2
				<tr>
			<?php if($ndctype=="multi") {?>
			<td>
						<div class="form-group"><input type="text" readonly name="e_date" class="form-control  datetimeST1 " id="date2" value="<?php if($ndctype=="multi") { echo $multi_e_date;} ?>" required ></div>
					</td>
					<?php } ?>

<?php if($ndctype=="single") {?>
			<td>
						<div class="form-group"><input type="text"  name="e_date" class="form-control  datetimeST1 " id="date2"  required ></div>
					</td>
					<?php } ?>

		<?php if($ndctype=="multi") {?>
			<td>
						<div class="form-group"><input type="text" readonly class="form-control" name="e_invoice"  value="<?php if($ndctype=="multi") { echo $multi_e_rx;} ?>" required ></div>
					</td>
					<?php } ?>	
					
<?php if($ndctype=="single") {?>
			<td>
						<div class="form-group"><input type="text"  name="e_invoice" onkeyup="checkInvoice(this.value);" class="form-control uppercase" required></div>
						<b id="erx_warning" style='display: none; color: #FF0000;'>Warning! There is the same RX/Trans/Invoice number in the system</b>
					</td>
					<?php } ?>

			<?php if($ndctype=="multi") {?>
			<td>
						<div class="form-group"><input type="text" readonly class="form-control" name="e_vendorId"  value="<?php if($ndctype=="multi") { echo $multi_v_name;} ?>" required ></div>
					</td>
					<?php } ?>	
				<?php if($ndctype=="single") {?>
			
								
					<td>
						<div class="form-group">
						<select name="e_vendorId" class="form-control">
							<? foreach ($vendors as $one) { ?>
							<option value="<?=$one['v_id']?>"><?=$one['v_name']?></option>
							<? } ?>
						</select>
						</div>
					</td>
					<?php } ?>
				
					<td id="size"><?= $drug['d_size'] ?></td>
					<td id="onHand"><?= $drug['d_onHand'] ?></td>
					<td>
						<div class="form-group"><input type="text" name="e_numPacks" class="form-control" id="numPacks" required></div>
					</td>
					<td id="units"></td>
					<td>
						<div class="form-group"><input type="text" name="e_costPack" class="form-control" id="costPack" required></div>
					</td>
					<td id="costUnit"></td>
					<td id="new_onHand"></td>
					<td>
						<div class="form-group"><input type="text" name="e_note" class="form-control uppercase"></div>
					</td>
				</tr>
        	</tbody>
    	</table>
        <div style="width: 80%">
            <table id="audit_lots_table" class="table table-bordered">
                <thead>
                    <tr><td>Add Lot</td>
                        <td>Lot Number</td>
                        <td>Expiration Date</td>
                        <td>QOH</td>
                        <td>Qty In</td>
                        <td>New Lot QOH</td>
                       <td>Remove</td>
                    </tr>
                </thead>
                <tbody id="add_lots">
					
				<!--<div id="lotnobrtdiv" style="display:block;width:50%;">

<select name="lotnobrt" id="lotnobrt" class="form-control" ><option value="" Selected Disabled>Select Lot </option><option value="newlot">Add New Lot</option>
<?php foreach($lots_data as $lot) { ?><?php if($drug['d_id']==$lot['drugId'])  { ?><option value="<?php echo $lot['lotName'];?>"><?php echo $lot['lotName'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y',$lot['expirationDate']);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $lot['count'];?></option><?php } ?> <?php }?> </select> 
</div>-->
                </tbody>

            </table>
            <input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots(0);" style="float: right; padding: 10px;"><br><br>

            <div id="lots_total_count" style="text-align: right; padding: 5px;"><b>Lot Total: 0</b></div>
            <div id="lots_remain_count" style="text-align: right; padding: 5px;"><b>Total Remaining:  </b></div>
        </div>
		<br/>


		<table class="table table-bordered entry-table " id="table-table2ext" >
		</table>
		
<input type="submit" value="Confirm" class="btn btn-primary" id="confirm_1">
<button type="submit" class="btn btn-success" name="add_another_in" id="another_1">Confirm & Add Another</button>
<!--		<input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots();">-->


		<?php if($ndctype=="multi") { ?>
	
		   <input type="submit" id="anotherndcbutton1" onclick="openModal()" value="Add another NDC" class="btn btn-primary">
		   	<?php } ?>
    </form>
    </div>

   <form action="<?=base_url()?>logbook/save" method="post" id="form2" class="save-form">
<div class="row hidden" id="table3">
        <form action="<?=base_url()?>logbook/save" onsubmit="return checkForm('#form3');" method="post" id="form3">
            <input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId">
            <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">
            <input type="hidden" value="return_mul" name="e_type">
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
                        <div class="form-group"><input type="text" name="e_date" class="form-control  datetimeST1" id="date3"  required></div>
                    </td>
                    <td>
                        <div class="form-group"><input type="text" name="e_rx" onkeyup="checkRX_Transaction(this.value);" class="form-control uppercase"  required></div>
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
			
            <div style="width: 50%">
                <table id="return_lots_table" class="table table-bordered">
                    <thead>
                    <tr><td>Add Lot</td>
                        <td>Lot Number</td>
                        <td>Expiration Date</td>
                        <td>QOH</td>
                        <td>Qty In</td>
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
			<br/>
            <input type="submit" value="Confirm" class="btn btn-primary" id="confirm_2">
            <button type="submit" class="btn btn-success" name="add_another_in" id="another_2">Confirm & Add Another</button>
			<!--<input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_2" onclick="addNewLots('', '', '', '', 'return');">-->
        </form>
    </div>

  <!--row hidden table2-->
  <div  class="row hidden" id="table4">
    <form action="<?=base_url()?>logbook/save" onsubmit="return checkForm('#form2');" method="post" id="form2">
        <input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId">
        <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">

		<input type="hidden" value="new_mul" name="e_type">
        <input type="hidden" id="input1" name="e_new">

        <input type="hidden" id="e_total" name="e_total">
        <input type="hidden" id="e_operator" name="e_operator" value="+">

        <input type="hidden" value="0" name="add_new" id="success_or_new1">

		<table class="table table-bordered entry-table" id="table-table4">
			<thead>
			<tr>

			<?php if($ndctype!="multi") {?>
				<td>Date</td>
				<td>Invoice #</td>
				<td class="wide-td">Vendor</td><?php }?>
			
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
				<?php if($ndctype!="multi") {?>
					<td>
						<div class="form-group"><input type="text" name="e_date" class="form-control  datetimeST1 " id="date2" required ></div>
					</td>
					<td>
						<div class="form-group"><input type="text" name="e_invoice" onkeyup="checkInvoice(this.value);" class="form-control uppercase" required ></div>
<!--						<b id="erx_warning2" style='display: none; color: #FF0000;'>Warning! There is the same RX/Transaction number in the system</b>-->
				<b id="erx_warning" style='display: none; color: #FF0000;'>Warning! There is the same RX/Trans/Invoice number in the system</b>

					</td>
					<td>
						<div class="form-group">
						<select name="e_vendorId" class="form-control">
							<? foreach ($vendors as $one) { ?>
							<option value="<?=$one['v_id']?>"><?=$one['v_name']?></option>
							<? } ?>
						</select>
						</div>
					</td>
				<?php }	?>
					<td>
						<div class="form-group"><input type="text" name="e_numPacks" class="form-control" id="numPacks" required></div>
					</td>
					<td id="units"></td>
					<td>
						<div class="form-group"><input type="text" name="e_costPack" class="form-control" id="costPack" required></div>
					</td>
					<td id="costUnit"></td>
					<td id="new_onHand"></td>
					<td>
						<div class="form-group"><input type="text" name="e_note" class="form-control uppercase"></div>
					</td>
				</tr>
        	</tbody>
    	</table>
        <div style="width: 80%">
            <table id="audit_lots_table" class="table table-bordered">
                <thead>
                    <tr><td>Add Lot</td>
                        <td>Lot Number</td>
                        <td>Expiration Date</td>
                        <td>QOH</td>
                        <td>Qty In</td>
                        <td>New Lot QOH</td>
                       <td>Remove</td>
                    </tr>
                </thead>
                <tbody id="add_lots">
					
				<!--<div id="lotnobrtdiv" style="display:block;width:50%;">

<select name="lotnobrt" id="lotnobrt" class="form-control" ><option value="" Selected Disabled>Select Lot </option><option value="newlot">Add New Lot</option>
<?php foreach($lots_data as $lot) { ?><?php if($drug['d_id']==$lot['drugId'])  { ?><option value="<?php echo $lot['lotName'];?>"><?php echo $lot['lotName'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('d-m-Y',$lot['expirationDate']);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $lot['count'];?></option><?php } ?> <?php }?> </select> 
</div>-->
                </tbody>

            </table>
            <input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots(0);" style="float: right; padding: 10px;"><br><br>

            <div id="lots_total_count" style="text-align: right; padding: 5px;"><b>Lot Total: 0</b></div>
            <div id="lots_remain_count" style="text-align: right; padding: 5px;"><b>Total Remaining:  </b></div>
        </div>
		<br/>
        <!--<input type="submit" value="Confirm" class="btn btn-primary" id="confirm_1">-->
	<!--	<button type="submit" class="btn btn-success" name="add_another_in" id="another_1">Confirm & Add Another</button>-->
		<!--<input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots();">-->
		<?php if($ndctype=="multi") {?>
		   <input type="submit" id="anotherndcbutton" onclick="openModal()" value="Add Another NDC" class="btn btn-primary">
		   <?php } ?>
    </form>
    </div>

    <!--col-md-8-->
	<?php if($ndctype=="multi") {?>
    <div class="col-md-4">
      <table class="table table-bordered entry-table" id="table-total">
        <tr>
          <td> NDC </td>
         <!-- <td id="qty_all"></td>-->
		  <td> Quantity IN (# of packs)</td>
		  <td> Quantity IN (units)</td>
		  <td>Cost</td>
        </tr>
		
       <tr><td><?=$drug['d_code'];?><td id="totalpacks_0"></td>
	   <td id="qtyinunits_0"></td>
	   <td id="cost_0"></td></tr>
      </table>
    </div>
	<?php } ?>
    <!--col-md-4-->
  </div>
  <!--row-->
</form>
<?}?>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Enter another NDC</h4>
      </div>
      <div class="modal-body" >
        <form id="modalForm">
          <input type="text" name="ndc" class="form-control"  data-mask="99999-9999-99">
          <input type="button" onclick="getDrugs();" style="margin-top:10px;"  class="btn btn-primary" value="Search">
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

  

var GLOBAL_DRUG_ID =0;
	var LID = 0;	var LOTS2 = <?= json_encode($lots_data) ?>;



function showdetails(lid,gid){
	
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
					//$("#oldqoh_" + lid).html(LOTS2[i].count);
					$("#oldqoh_brt_" + lid).val(LOTS2[i].count);
					$("#oldqoh_f_" + lid).val(LOTS2[i].count);
					
			}
		}
	}
	else
		{
		$("#elot_warning_"+lid).css("display", "none");
		$("#lotnobrt_"+lid).val("");
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
	
function fncheck(lid)
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

	function recountLots(lid)
	{
		
		var TOTAL_QOH = 0;
		var TOTAL_UNITS = $("#units").html() * 1;
		//alert(TOTAL_UNITS);
		var TOTAL_RETURNED = $("#e_returned").val() * 1;
var newlotval=0;
		//console.log(TOTAL_UNITS);

		$('.audit_qohs').each(function(i)
		{
			newlotval=$(this).val();
			//alert("new lot val:"+newlotval);
			TOTAL_QOH += +$(this).val();
			
		});

        var REMAIN_NEW = TOTAL_UNITS - TOTAL_QOH;
        var REMAIN_RET = TOTAL_RETURNED - TOTAL_QOH;
		//alert(TOTAL_QOH);
		//alert("old qoh _ f:"+$("#oldqoh_f_"+lid).val());
			//if(parseInt(newlotval)==0) { alert("error"); return false;}
		$("#nlqoh_brt_"+lid).val(parseInt($("#oldqoh_f_"+lid).val())+parseInt(newlotval));
	//	if($("#nlqoh_brt_"+lid).val()==0) { alert("Invalid QTY IN value"); }
		$("#lots_total_count").html("<b>Lot Total: " + TOTAL_QOH + "</b>");
        $("#lots_remain_count").html("<b>Total Remaining: " + REMAIN_NEW + "</b>");
		$("#lots_return_total_count").html("<b>Lot Total: " + TOTAL_QOH + "</b>");
        $("#lots_return_remain_count").html("<b>Total Remaining: " + REMAIN_RET + "</b>");
	$("#totalpacks_0").html($("#numPacks").val());
		$("#qtyinunits_0").html($("#units").html());
		alert($("#costUnit").val());
	$("#cost_0").html($("#costUnit").val() * TOTAL_QOH);
	if (TOTAL_QOH == TOTAL_UNITS) checkAndLockButtons(false, 1,0);
		else checkAndLockButtons(true, 1);

		if (TOTAL_QOH == TOTAL_RETURNED) checkAndLockButtons(false, 2,0);
		else checkAndLockButtons(true, 2);
	}



function recountLotsglobal(lid,gid)
	{
		alert("gid:"+gid);
		var TOTAL_QOH = 0;
		var TOTAL_UNITS = $("#units_"+gid).html() * 1;
		//alert(TOTAL_UNITS);
		var TOTAL_RETURNED = $("#e_returned_"+gid).val() * 1;
var newlotval=0;
		//console.log(TOTAL_UNITS);
//alert("before loop");
		$('.audit_qohs_'+gid).each(function(i)
		{
			alert("in loop");
			newlotval=$(this).val();
			//alert("new lot val:"+newlotval);
			TOTAL_QOH += +$(this).val();
			
		});
//alert("outside loop");
        var REMAIN_NEW = TOTAL_UNITS - TOTAL_QOH;
        var REMAIN_RET = TOTAL_RETURNED - TOTAL_QOH;
		alert(TOTAL_QOH);
		//alert("old qoh _ f:"+$("#oldqoh_f_"+lid).val());
			//if(parseInt(newlotval)==0) { alert("error"); return false;}
		$("#nlqoh_brt_"+lid).val(parseInt($("#oldqoh_f_"+lid).val())+parseInt(newlotval));
	//	if($("#nlqoh_brt_"+lid).val()==0) { alert("Invalid QTY IN value"); }
		$("#lots_total_count_"+gid).html("<b>Lot Total: " + TOTAL_QOH + "</b>");
        $("#lots_remain_count_"+gid).html("<b>Total Remaining: " + REMAIN_NEW + "</b>");
		$("#lots_return_total_count_"+gid).html("<b>Lot Total: " + TOTAL_QOH + "</b>");
        $("#lots_return_remain_count_"+gid).html("<b>Total Remaining: " + REMAIN_RET + "</b>");
/*newrow= '<tr><td>'+ response.d_code + '</td><td id="totalpacks_'+GLOBAL_DRUG_ID+'" ></td><td id="qtyinunits_'+GLOBAL_DRUG_ID+ '" > </td><td id="cost_'+GLOBAL_DRUG_ID+'"</td></tr>';*/

	$("#totalpacks_"+gid).html($("#numPacks_"+gid).val());
		$("#qtyinunits_"+gid).html($("#units_"+gid).html());
	$("#cost_"+gid).html($("#costUnit_"+gid).val() * TOTAL_QOH);

		if (TOTAL_QOH == TOTAL_UNITS) checkAndLockButtons(false, 1,gid);
		else checkAndLockButtons(true, 1);

		if (TOTAL_QOH == TOTAL_RETURNED) checkAndLockButtons(false, 2,gid);
		else checkAndLockButtons(true, 2);
	}
	function checkAndLockButtons(lock, type,gid)
	{
		if (lock)
		{
			$("#confirm_" + type).attr("disabled", true);
			$("#another_" + type).attr("disabled", true);
			$("#add_new_lots_" + type).removeAttr("disabled");
			//$("#anotherndcbutton1").attr("disabled", true);
			//alert("am here");
			if(gid>0) 
			{
				$("#add_lotsbut_"+gid).attr("disabled",true);

			}
			else
			if(document.getElementById('add_new_lots_'+type).disabled==true)
				{
					alert("lots but disabled");
					$("#anotherndcbutton1").attr("disabled",false);
				}
		} else {
			$("#confirm_" + type).removeAttr("disabled");
			$("#another_" + type).removeAttr("disabled");
			$("#add_new_lots_" + type).attr("disabled", true);
			//alert("am here 2");
			if(gid>0) 
			{
				$("#add_lotsbut_"+gid).attr("disabled",true);
				$("#anotherndcbutton1").attr("disabled",false);

			}
			else
		if(document.getElementById('add_new_lots_'+type).disabled==true)
		{
			alert("lots but disabled");
				$("#anotherndcbutton1").attr("disabled",false);
		}
		
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
	function checkLotNumber(code,lid)
	{
		//alert("called");

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
	var LOTS1 = <?= json_encode($lots_data) ?>;
	
	function addNewLots(ch)
	{
		//alert(ch);
		LID += 1;

		var e_lot = arguments[0] || "";
		var e_date = arguments[1] || "";
		var e_qoh = arguments[2] || "";
		var e_old_qoh = arguments[3] || 0;
		var where = arguments[4] || "";

		var to_field = "#add_lots";


		if (where == "return") to_field = "#add_return_lots";

		$(to_field).append('<tr id="lotrow_' + LID + '">'+'<td><select name="lotnobrt_'+LID+'" id="lotnobrt_'+LID+'" class="form-control" onchange="showdetails('+LID+');"><option value="" selected disabled>Select</option><option value="newlot">Add New Lot</option><?php foreach($lots_data as $lot) { if($drug["d_id"]==$lot["drugId"])  { ?><option value="<?php echo $lot["lotName"]; ?>"><?php echo $lot["lotName"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("m-d-Y",$lot["expirationDate"]);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lot["count"];?><?php } } ?></td><td><div class="form-group"><input type="text"  lid="' + LID + '" id="elot_' + LID + '" name="audit_lot[]" class="e_lot form-control"  required onkeyup="fncheck('+LID+')"/><span style="font-size: 85%; color: #B94A48;"></span>		<b id="elot_warning_' + LID + '" style="display: none; color: #FF0000;">Warning! You are adding to an existing Lot Number in the system</b></div>' +
		'<td><input type="text" id="edate_' + LID + '" name="audit_expiration[]" class="e_date form-control datetimeST3" value="' + e_date + '" required onchange="setqoh(' +LID+');"/><span style="font-size: 85%; color: #B94A48;"></span></td>' +
		'<td><!--<div id="oldqoh_' + LID + '">' + e_old_qoh + '</div>--><input id="oldqoh_f_' + LID + '" name="audit_oldqoh[]" type="hidden" value="' + e_old_qoh + '"><input id="oldqoh_brt_' + LID + '" name="audit_oldqohbrt[]" type="text" readonly class="form-control" value="' + e_old_qoh + '"></td>' +
		'<td><input type="text" name="audit_qoh[]" onkeyup="recountLots('+LID+')" class="audit_qohs form-control" value="' + e_qoh + '" required/><span style="font-size: 85%; color: #B94A48;"></span></td>' +'<td><input id="nlqoh_brt_' + LID + '" name="audit_nlqohbrt[]" type="text" readonly class="form-control" value="">' +
		'<td><a href="javascript://void();" onclick="removeLotsFromTable(' + LID + ');">remove</a></td>' +
		'</tr>');
	//alert(LOTS1.length);
	//alert("lid:"+LID);
	var lid=LID;
	
		if(ch!=0)
		initLotList(".e_lot");
		initDatePicker();

		$('#form2').bootstrapValidator('revalidateField', 'audit_lot[]');
		
	}
	function setqoh(lid)
	{
		//alert("setqoh called");
		
$("#oldqoh_brt_"+lid).val(0);
	}
	
    function show_table(id) {
		alert("show table"+id);
        var table = $('#table'+id);
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
   function hide_table(id) {
        var table = $('#table'+id);
        table.addClass('hidden');
      /*  $('#inputNdc').attr('disabled', true);
        $('#button0').attr('disabled', true);
        if (id == 2){
            $('#button2').attr('disabled', true)
        }
        else if (id == 3){
            $('#button1').attr('disabled', true)
        }*/
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
		LID=LID-1;
		recountLots(LID);
	}

	function initLotList(field)
	{
		$(field).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "<?php echo site_url('logbook/getJSON_lots/with_date_and_count');?>",
					dataType: "json",
					data: {
						q: request.term,
						drugId: <?= $drug["d_id"] ?>
					},
					success: function( data ) {
					
						response(data);

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
					//$("#oldqoh_" + lid).html(ids[2]);
					$("#oldqoh_brt_" + lid).val(ids[2]);
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

    $(document).ready(function()
	{
alert("ready");
<?php if($ndctype=="multi") {?>
$('#multiplendc_block').css("display","block");
$('#multiplendc_block1').css("display","block");
 $('#button1_1').attr('disabled', true);
  $('#button1').attr('disabled', true);
<?php } else { ?>
	$('#singlendc_block').css("display","block");
  $('#button2_1').attr('disabled', true);
<?php } ?>
initLotList(".e_lot");
applyValidator();
$('#lotnobrt').change(function(){
	//alert("changed lot no");
	var lotcode=$('#lotnobrt').val();
	//alert(lotcode);
	if(lotcode=='newlot') { //alert("New Lot");
		$("#elot_warning").css("display", "none");addNewLots(0);}
	else
	{
$("#elot_warning").css("display", "none");	checkLotNumber(lotcode);addNewLots(1);}
	
});

      
      
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
            var units = $('#units');
            var num = $('#numPacks').val();
            var size = $('#size').text();
            //console.log(num);
            //console.log(size);

            units.text(num*size);
			$("#e_total").val(num * size);

            var old = $('#onHand').text();
            old = parseFloat(old);
            var newVal = num*size+old;

            $('#new_onHand').text(num*size+old);
            $('#input1').val(newVal);

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

		initDatePicker();

		<?if (@$drug["d_lotTracking"]) { ?>
		//addNewLots();
		//addNewLots('', '', '', '', 'return');
		<? } ?>
    });
	$('.datetimeST1').datetimepicker({
		pickDate: true,
		pickTime: true,
		format: 'MM/DD/YYYY HH:mm',
		maxDate: new Date()
	
});

	function initDatePicker()
	{
alert("datepicker");
		$('.datetimeST3').datetimepicker({
			pickDate: true,
			pickTime: false,
			format: 'MM/DD/YYYY',
				minDate: new Date(),
		onSelect : function(x, u){
 $(this).focus(); 
   $(this).datepicker("hide");     
},
onClose: function(e){
e.preventDefault();
}
});
	}
	$('.datetimeST1').datetimepicker({
		pickDate: true,
		pickTime: true,
		format: 'MM/DD/YYYY HH:mm',
		maxDate: new Date(),
	onSelect : function(x, u){
 $(this).focus(); 
   $(this).datepicker("hide");     
},
onClose: function(e){
e.preventDefault();
}
});

    $('.datetimeST2').datetimepicker({
        pickDate: true,
        pickTime: false,
        format: 'MM/DD/YYYY',
        minDate: '<?=date('m/d/Y', strtotime('today'))?>',
   onSelect : function(x, u){
 $(this).focus(); 
   $(this).datepicker("hide");     
},
onClose: function(e){
e.preventDefault();
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

</script>
<script>
 $('#modal-go-button').click(function(event){
        jQuery.ajax({
            type: "POST",
            url: '<?=base_url()?>drug/get_drug',
            data: jQuery('#modalForm').serialize(),
            cache: false,
            success: function(response){
                console.log('success');
                console.log(response.d_lotTracking);
                var childRow = $('#table-table2ext').append();
                var lotCell = '';
var NDCCell='';
				GLOBAL_DRUG_ID += 1;

                if (response.d_lotTracking == 1) {
                    NDCCell = ' <table class="table table-bordered entry-table" id="ndc_table_' + GLOBAL_DRUG_ID + '"  style="width:1200px;"><thead> <tr><td>NDC</td> <td>Drug Name</td> <td>Drug Description</td><td>Package Size</td> <td>Manufacturer</td> <td>Schedule</td><td>Quantity on hand</td>                </tr></thead>';
							
					
                }

					childRow.append(NDCCell+'<tbody><tr id="'+response.d_id+'">' +
				'<input type="hidden" value="'+response.d_id+'" name="e_drugId[]">' +
				'<input type="hidden" value="'+response.d_onHand+'" name="e_old[]">' +
				'<input class="input1" type="hidden" name="e_new[]">' +
				'<td class="ndc">'+response.d_code+'</td><td>'+response.d_name+'</td>' +
				'<td class="hand">'+response.d_descr+'</td>'+
				'<td class="descr">'+response.d_size+'</td>'+
			'<td class="man">'+response.d_manufacturer+'</td>'+
				'<td class="schd">'+response.d_schedule+'</td>'+
				'<td class="onhand">'+response.d_onHand+'</td>'+
				'</tr></tbody></table>');
				childRow.append('	<table class="table table-bordered entry-table " style="width:1200px;"><thead>	<tr><td>Date</td>	<td>Invoice #</td><td >Vendor</td>	<td>Package Size</td>	<td>Quantity on hand</td>		<td class="narrow-td"># of packs</td>	<td>Total Units</td>		<td class="narrow-td">Acq Cost/Pack</td>	<td>Acq Cost/Unit</td>	<!--<td>Lot #</td>	<td>Expiration</td>-->				<td>New Quantity on Hand</td>			<td>Notes</td>		</tr></thead> <tbody><tr><td>abcd</td><td >	<?=$multi_e_rx?>	</td>	<td ><?=$multi_v_name?></td>	<td id="size_'+GLOBAL_DRUG_ID+'"><?= $drug['d_size'] ?></td>	<td id="drug_'+GLOBAL_DRUG_ID+'"><?= $drug['d_onHand'] ?></td><td class="narrow-td"><input type="text" name="e_numPacks" class="form-control" id="numPacks_' +GLOBAL_DRUG_ID + '" onkeyup="fn(' + LID+','+ GLOBAL_DRUG_ID +');" required></td><td id="units_'+GLOBAL_DRUG_ID+'"></td><td class="narrow-td"><input type="text"  name="e_costPack" class="form-control" id="costPack_'+GLOBAL_DRUG_ID+'"  onkeyup="somefn(' + GLOBAL_DRUG_ID +');" required></td><td id="costUnit_'+GLOBAL_DRUG_ID+'"></td><td id="new_onHand_'+GLOBAL_DRUG_ID+'"></td><td><input type="text" name="e_note" class="form-control uppercase">	</td>	</tr></tbody></table>');



				childRow.append('<table id="lot_table_'+ LID + '" class="table table-bordered" style="width:1200px;"><thead>'+'<tr><td>Add Lot</td><td>Lot Number</td><td>Expiration Date</td><td>QOH</td><td>Qty In</td><td>New Lot QOH<td>Remove</td></tr></thead><tbody id="add_lots_' + LID + '"></tbody></table>' + '<div><input type="button" id="add_lotsbut_'+GLOBAL_DRUG_ID+'" class="btn btn-success" value="Add Lot" style="float: right" onclick="addNewLotsMulti(\'\', \'\', \'\', \'\', \'#add_lots_' + LID + '\', ' + LID + ', ' + response.d_id + ');"><div id="lots_total_count_' + GLOBAL_DRUG_ID + '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Lot Total: 0</b></div><div id="lots_remain_count_' + GLOBAL_DRUG_ID+ '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Total Remaining: 0</b></div></div>	LID'+LID+'GID'+GLOBAL_DRUG_ID);

                var childTotal = $('#total').parent().before('<tr id="total'+response.d_id+'"><td>'+response.d_code+'</td><td class="qty_one"></td></tr></tbody></table></div></table>');
                $('.out').unbind();
                $('.save-form').data('bootstrapValidator', null);
				
				if (response.d_lotTracking == 1)
				//addNewLotsMulti('', '', '', '', '#add_lots_' + GLOBAL_DRUG_ID, GLOBAL_DRUG_ID, response.d_id);


				var newrow=    $('#table-total').append();
				newrow.append( '<tr><td>'+ response.d_code + '</td><td id="totalpacks_'+GLOBAL_DRUG_ID+'" ></td><td id="qtyinunits_'+GLOBAL_DRUG_ID+ '" > </td><td id="cost_'+GLOBAL_DRUG_ID+'"</td></tr>');

                //applyValidator();
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
		$('.datetimeST3').datetimepicker({
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
	function fn(lid,gid)
	{
		
			     var s1 = $('#size_'+gid).text();
            var size1= parseInt(s1);
			var s2=$('#numPacks_'+gid).val();
			
		
$('#units_'+gid).html(size1 *s2);
	var qoh=$('#drug_'+gid).text();
	qoh=parseInt(qoh);
	
	var units=$('#units_'+gid).text();
	units=parseInt(units);
	$('#new_onHand_'+gid).html(qoh+units);
	recountLotsglobal(lid,gid);

	}
	function somefn(gid)
	{
		
			     var s1 = $('#size_'+gid).text();
            var size1= parseInt(s1);
			var s2=$('#costPack_'+gid).val();
		
			var cost=s2/size1;
$('#costUnit_'+gid).html('$'+cost);
	

	}



	function addNewLotsMulti()
	{
		alert("multi lot");
		LID += 1;

		
		var e_lot = arguments[0] || "";
		var e_date = arguments[1] || "";
		var e_qoh = arguments[2] || "";
		var e_old_qoh = arguments[3] || 0;
		var where = arguments[4] || "";
		var table_id = arguments[5] || "";
		var drug_id = arguments[6] || "";

		var to_field = "#add_lots";
		if (where) to_field = where;
//alert(to_field)
		$(to_field).append('<tr id="lotrow_'+LID + '">'+'<td><select name="lotnobrt_'+LID+'" id="lotnobrt_'+LID+'" class="form-control" onchange="showdetails('+LID+');"><option value="" selected disabled>Select</option><option value="newlot">Add New Lot</option><?php foreach($lots_data as $lot) { if($drug["d_id"]==$lot["drugId"])  { ?><option value="<?php echo $lot["lotName"]; ?>"><?php echo $lot["lotName"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("m-d-Y",$lot["expirationDate"]);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lot["count"];?><?php } } ?></td><td><div class="form-group"><input type="text"  lid="' + LID + '" id="elot_' + LID + '" name="audit_lot[]" class="e_lot  form-control"  required onkeyup="checkLotNumber(this.value,'+ LID + ');"/><span style="font-size: 85%; color: #B94A48;"></span>		<b id="elot_warning_' + LID + '" style="display: none; color: #FF0000;">Warning! You are adding to an existing Lot Number in the system</b></div>' +
		'<td><input type="text" id="edate_' + LID + '" name="audit_expiration[]" class="e_date form-control datetimeST3" value="' + e_date + '" required onchange="setqoh(' +LID+');"/><span style="font-size: 85%; color: #B94A48;"></span></td>' +
		'<td><!--<div id="oldqoh_' + LID + '">' + e_old_qoh + '</div>--><input id="oldqoh_f_' + LID + '" name="audit_oldqoh[]" type="hidden" value="' + e_old_qoh + '"><input id="oldqoh_brt_' + LID + '" name="audit_oldqohbrt[]" type="text" readonly class="form-control" value="' + e_old_qoh + '"></td>' +
		'<td><input type="text" name="audit_qoh[]" onkeyup="recountLotsglobal('+LID+','+GLOBAL_DRUG_ID+')" class="audit_qohs_'+GLOBAL_DRUG_ID+' form-control" value="' + e_qoh + '" required/><span style="font-size: 85%; color: #B94A48;"></span></td>' +'<td><input id="nlqoh_brt_' + LID + '" name="audit_nlqohbrt[]" type="text" readonly class="form-control" value="">' +
		'<td><a href="javascript://void();" onclick="removeLotsFromTable(' + LID + ');">remove</a></td>' +
		'</tr>');


		initLotList(".e_lot");
		initDatePicker();

		DRUG_AND_LOTS[table_id] = '.audit_qohs_' + table_id;
		recountAllPossibleLotsCount();

		loadLotsForSelectByDrugID("#lot_select_" + LID, drug_id, LID);
		//recountLotsMultiple('.audit_qohs_' + table_id, table_id);

		NEED_CHECK_SUM = true;
		FIRST_LOT_ADDED = true;
	}

	</script>