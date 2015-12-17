<script>
function showsinglendc_block(){
	document.getElementById('singlendc_block').style.display="block";
}
function showmultiplendc_block(){
	document.getElementById('singlendc_block').style.display="none";
		document.getElementById('multiplendc_block').style.display="block";
		}
		function verifyFields(){
			//alert("checking");
			//alert($('#multiDiv_e_date').val());
	//alert($('#multiDiv_e_rx').val());
alert($("#multiDiv_v_name").val());
//$( "#myselect" ).val();
alert($('#multiDiv_v_name : selected').text());
//$('#dropDownId').val();
			/*if($('#multiDiv_e_date').val()=="") || $('#multiDiv_e_rx').val()=="") || $('#multiDiv_v_name').val()=="")){

				alert("please enter the values");
				//return false;
			}*/

		}
	function checkMultiForm(form)
	{
		alert(form);
		/*<?if (@!$drug["d_lotTracking"]) { ?>
		return true;
		<? } ?>*/
alert("here");
		var brk = false;

		$(form + " .multiDiv_e_date, " + form + " .multiDiv_e_rx, " + form + " .multiDiv_v_name").each(function(index, element) {
			$(element).parent().removeClass("has-error");

			$(element).parent().find("span").html("");

			if ($(element).val() === "")
			{
				alert("Enter values");
				brk=true;
				/*$(element).parent().addClass("has-error");
				$(element).parent().find("span").html("Field is required and cannot be empty");
				brk = true;*/
			}
		});
if(brk==false) { alert("false");
$('#multiplendc_block').css("display","block");

//$("#elot_warning").css("display", "none");
$('#multiplendc_block1').css("display","block");
		//return !brk;
	}
	}
</script>
<h2>Inventory In</h2>

<div class="row">
	<input id="singlendc_but" type="button" value="Single NDC" class="btn btn-primary" onclick=" showsinglendc_block();">
		<input id="multiplendc_but" type="button" value="Multiple NDC" class="btn btn-primary" onclick=" showmultiplendc_block();">
			<input id="bulkupload_but" type="button" value="bulkupload" class="btn btn-primary" onclick=" showsinglendc_block();"></div>
<br/>
<div id="multiplendc_block" style="display:none;width: 50%;">
	<div id="multiDiv" style="display:block;">
	<form name="multiform" id="multiform" action="" method="post" class="form-inline">
   <table class="table" >
   <tr><td>Date</td><td>Rx/ Trans /Invoice #</td>
  <td>Vendor</td></tr>
   <tr><td>	<div class="form-group"><input type="text" name="multiDiv_e_date" class="form-control  datetimeST1" id="multiDiv_e_date" value=<?=$multi_e_date?> required ></div>
	</td>
  	<td>	<div class="form-group"><input type="text" name="multiDiv_e_rx" class="form-control  " id="multiDiv_e_rx" value=<?=$multi_e_rx?> required ></div>
	</td>
  <td>
						<div class="form-group">
						<select name="multiDiv_v_name" id="multiDiv_v_name" class="form-control">
							<? foreach ($vendors as $one) { ?>
                           
							<option value="">Select Vendor</option>
                            <option  value="<?=$one['v_id']?>"><?=$one['v_name']?><?=$one['v_id']?></option>
							<? }  ?>
						</select>
						</div>
					</td>

	  </tr></table><input type="button" id="multindc" name="multindc" value="ADD NDC"  class="btn btn-primary" onclick="checkMultiForm('#multiform');">
</div>


<div id="multiplendc_block1" style="display:none;">
<? if (@!$auditForce) { ?>
	
		<div class="form-group">
			<label>Multiple NDC</label>
		</div>
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
<?}
?>
</div>















<!--single ndc block start here-->
<div id="singlendc_block" style="display:none;">
<? if (@!$auditForce) { ?>
	<form action="" method="post" class="form-inline">
		<div class="form-group">
			<label>Single NDC</label>
		</div>
		<div class="form-group">
			<input id="inputNdc" type="text" name="ndc" class="form-control" data-mask="99999-9999-99" value="<?=@$drug['d_code']?>">
		</div>
		<div class="form-group">
			<input id="button0" type="submit" value="Go" class="btn btn-primary" >
		</div>
	</form>
<? } else { ?>
	<p>You have to make audit for this drug!</p>
<? } ?>
</div>
<?if (@empty($drug)&&($first == false)){?>
    <p>There are no drugs with specified NDC.</p>
    <a href="<?=base_url()?>drug/add_drug" target="_blank" class="btn btn-primary">New drug</a>
<?} else if (!@empty($drug)){?>

    <label><?=$drug['d_name']?><? if($drug['d_status'] == '0'){ echo ': Inactive';}?></label><br>

    <button class="btn btn-primary" onclick="show_table(1)" <? if($drug['d_status'] == '0'){ echo 'disabled';}?>>Continue</button>
    <a href="<?=base_url()?>logbook/" class="btn btn-danger">Cancel</a>


    <div class="row hidden" id="table1">
            <table class=" table table-bordered entry-table">
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
            <input type="button" id="button1" onclick="show_table(2)" value="Inventory In" class="btn btn-info">
            <input type="button" id="button2" onclick="show_table(3)" value="Return to Stock" class="btn btn-success">
    </div><!--row-->

    <div  class="row hidden" id="table2">
    <form action="<?=base_url()?>logbook/save" onsubmit="return checkForm('#form2');" method="post" id="form2">
        <input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId">
        <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">

		<input type="hidden" value="new_mul" name="e_type">
        <input type="hidden" id="input1" name="e_new">

        <input type="hidden" id="e_total" name="e_total">
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
        <input type="submit" value="Confirm" class="btn btn-primary" id="confirm_1">
		<button type="submit" class="btn btn-success" name="add_another_in" id="another_1">Confirm & Add Another</button>
		<!--<input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots();">-->
    </form>
    </div>

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
<? } ?>

<script>
	var LID = 0;	var LOTS2 = <?= json_encode($lots_data) ?>;

	function showdetails(lid){
	//	alert("show details");
		var lotcode=$('#lotnobrt_'+lid).val();
	//alert(lotcode);
	if(lotcode=='newlot') { //alert("New Lot"); 
		$("#elot_warning").css("display", "none");}
	else
	{
$("#elot_warning").css("display", "none");	checkLotNumber(lotcode,lid);
for (var i = 0; i < LOTS2.length; i++) {
			if (LOTS2[i].lotName == $('#lotnobrt_'+lid).val()) {
				$("#elot_" + lid).val(LOTS2[i].lotName);
				var timestamp = moment.unix(LOTS2[i].expirationDate);
			//	$("#e_expiration").val(timestamp.format("MM/DD/YYYY"));
					$("#edate_" + lid).val(timestamp.format("MM/DD/YYYY"));
					//$("#oldqoh_" + lid).html(LOTS1[i].count);
					$("#oldqoh_brt_" + lid).val(LOTS2[i].count);
					$("#oldqoh_f_" + lid).val(LOTS2[i].count);
			}
		}
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

		$(to_field).append('<tr id="lotrow_' + LID + '">'+'<td><select name="lotnobrt_'+LID+'" id="lotnobrt_'+LID+'" class="form-control" onchange="showdetails('+LID+');"><option value="" selected disabled>Select</option><option value="newlot">Add New Lot</option><?php foreach($lots_data as $lot) { if($drug["d_id"]==$lot["drugId"])  { ?><option value="<?php echo $lot["lotName"]; ?>"><?php echo $lot["lotName"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("m-d-Y",$lot["expirationDate"]);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lot["count"];?><?php } } ?></td><td><div class="form-group"><input type="text"  lid="' + LID + '" id="elot_' + LID + '" name="audit_lot[]" class="e_lot form-control"  required onkeyup="checkLotNumber(this.value,'+ LID + ');"/><span style="font-size: 85%; color: #B94A48;"></span>		<b id="elot_warning_' + LID + '" style="display: none; color: #FF0000;">Warning! You are adding to an existing Lot Lumber in the system</b></div>' +
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

    function show_table(id) {
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
		//alert("ready");
		//alert($("#singlendc_block").css('display'));
		if($("#singlendc_block").css('display') == 'block'){ 
			//alert("block");
			$("#singlendc_block").css('display',"block");
		}
		else
$("#singlendc_block").css('display',"block");
if($("#multindc_block").css('display') == 'block'){ 
			//alert("block");
			$("#multindc_block").css('display',"block");
		}
		
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

	function initDatePicker()
	{
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


</script>

