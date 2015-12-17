<h2>Inventory Out</h2>
<?if (@!$auditForce) { ?>
<form action="" method="post" class="form-inline">
  <div class="form-group">
    <label>NDC</label>
  </div>
  <div class="form-group">
    <input id="inputNdc" type="text" name="ndc" class="form-control" data-mask="99999-9999-99" value="<?=@$drug['d_code']?>">
  </div>
  <div class="form-group">
    <input id="button0" type="submit" value="Go" class="btn btn-primary">
  </div>
</form>
<? } else { ?>
<p>You have to make audit for this drug!</p>
<? } ?>
<?if (@empty($drug)&&($first == false)){?>
<p>There are no drugs with specified NDC.</p>
<a href="<?=base_url()?>drug/add_drug" class="btn btn-primary">New drug</a>
<?} else if (!@empty($drug)){?>
<label>
<?=$drug['d_name']?>
<? if($drug['d_status'] == '0'){ echo ': Inactive';}?>
</label>
<br>
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
      <tr>
        <td><?=$drug['d_code']?></td>
        <td><?=$drug['d_name']?></td>
        <td><?=$drug['d_descr']?></td>
        <td><?=$drug['d_size']?></td>
        <td><?=$drug['d_manufacturer']?></td>
        <td><?=$drug['d_schedule']?></td>
        <td id="qtyOnHand"><?=$drug['d_onHand']?></td>
      </tr>
    </tbody>
  </table>
  <input type="button" id="button1" onclick="show_table(2)" value="Single NDC" class="btn btn-info">
  <input type="button" id="button2" onclick="show_table(3)" value="Multiple NDC" class="btn btn-success">
</div>
<!--row-->
<div class="row hidden" id="table2">
  <form action="<?=base_url()?>logbook/save" method="post" class="save-form" id="form1">
    <input type="hidden" name="add_new" value="0" id="success_or_new1">
    <input type="hidden" value="<?=$drug['d_id']?>" id="e_drugId" name="e_drugId">
    <input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">
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
          <td>New QOH</td>
          <!--<td># Lot</td>-->
          <td>Notes</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><div class="form-group">
              <input type="text" name="e_date" class="form-control  datetimeST" id="date1" required>
            </div></td>
          <td><div class="form-group">
              <input type="text" name="e_rx" autocomplete="off" onkeyup="checkRX_Transaction(this.value);" class="form-control uppercase" required>
            </div></td>
          <td><div class="form-group">
              <input id="qty_out" type="text" autocomplete="off" name="e_out" class="form-control" required >
            </div></td>
          <td id="new_qty"></td>
          <td><div class="form-group">
              <input type="text" name="e_note" class="form-control note uppercase">
            </div></td>
        </tr>
      </tbody>
    </table>
	<div id="SomeDiv" style="display:none;">
   <table class="table" >
   <tr><td>Date Entered</td><td>Transaction Type</td><td>Rx/ Trans #</td>
   <td>Invoice #</td><td>NDC</td><td>Name</td><td>Vendor</td><td>Qty In</td><td>Qty Out</td>
   <td>Lot #</td><td>Exp Date</td><td>Last Edited</td><td>User Name</td></tr>
   <tr><td>	<div id="SomeDiv_e_date"></div>	</td>
   <td>	<div id="SomeDiv_e_type"></div>	</td>
   <td>	<div id="SomeDiv_e_rx"></div>	</td>
   <td><div id="SomeDiv_e_invoice"></td>
 
   <td>	<div id="SomeDiv_d_code"></div>	</td>
   <td>	<div id="SomeDiv_d_name"></div>	</td>
   <td><div id="SomeDiv_v_name"></div></td>
   <td><div id="SomeDiv_d_size"></div></td>
   <td><div id="SomeDiv_e_out_total"></div></td>
      <td><div id="SomeDiv_e_lot"></div></td>
	     <td><div id="SomeDiv_e_expiration"></div></td>
		    <td><div id="SomeDiv_e_last_edit_date"></div></td>
			 <td><div id="SomeDiv_username"></div></td>
	  </tr></table>
</div>
    <?if ($drug["d_lotTracking"]) { ?>
    <div style="width: 80%;">
      <table id="lots_table" class="table table-bordered">
        <thead>
          <tr>
            <td>Lot Number</td>
	            <td>Lot Expiration Date</td>
            <td>Lot QOH</td>
            <td>Lot Qty Out</td>
			 <td>New Lot QOH</td>
            <td>Remove</td>
          </tr>
        </thead>
        <tbody id="add_lots">
        </tbody>


      </table>
      <input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots();" style="float: right; padding: 10px;">
      <br>
      <br>
      <div id="lots_total_count" style="text-align: right; padding: 5px;"><b>Lot Total: 0</b></div>
      <div id="lots_remain_count" style="text-align: right; padding: 5px;"><b>Total Remaining: 0</b></div>
    </div>
    <?}?>
    <b id="expires_warning" style='display: none; color: #FF0000;'>Warning! This drug is about to or has already expired</b> <b id="notactive_warning" style='display: none; color: #FF0000;'>Warning! This lot is not active</b> <b id="erx_warning" style='display: none; color: #FF0000;'>Warning! There is the same RX/Transaction number in the system<input type="button" name="Continue" value="Continue" onclick="showconfirms();"></b> <br/>
	<div id="confirmdiv" style="display:none";>
    <input type="submit" value="Confirm" class="btn btn-primary" id="confirm_1">
    <button type="submit" class="btn btn-success" name="add_another_out" id="another_1">Confirm & Add Another</button>
	</div>
    <!--<input type="button" value="Add lot" class="btn btn-success" id="add_new_lots_1" onclick="addNewLots();">-->
  </form>
</div>
<script>
function showconfirms(){
	 // alert("yes");
	  document.getElementById('confirmdiv').style.display="block";
  }
</script>
<!--row hidden table2-->
<form action="<?=base_url()?>logbook/save" method="post" id="form2" class="save-form">
  <div class="row hidden" id="table3">
    <input type="hidden" value="multi_out" name="e_type">
    <input type="hidden" value="0" name="add_new" id="success_or_new2">
    <table class=" table table-bordered entry-table" id="table-table3">
      <thead>
        <tr>
          <td>Date</td>
          <td>RX/Transaction #</td>
          <td>Quantity OUT</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><div class="form-group">
              <input type="text" name="e_date" id="date2" class="form-control  datetimeST" required>
            </div></td>
          <td><div class="form-group">
              <input type="text" name="e_rx" autocomplete="off" onkeyup="checkRX_Transaction(this.value);" class="form-control uppercase" required>
            </div></td>
          <td><div class="form-group">
              <input id="qty_out2" name="e_out" autocomplete="off" type="text" class="form-control" required >
            </div></td>
        </tr>
		
      </tbody>
    </table>
    <b id="erx_warning2" style='display: none; color: #FF0000;'>Warning! There is the same RX/Transaction number in the system</b> <br/>
    <input type="button" onclick="show_table(4)" value="Confirm" class="btn btn-primary">
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
              <input type="hidden" class="input1"  name="e_new[]">
            </td>
            <td><?=$drug['d_name']?></td>
            <td class="hand"><?=$drug['d_onHand']?></td>
            <td><div class="form-group">
                <input id="e_out_1" autocomplete="off" type="text" name="e_out[]" class="out form-control" required>
                <input id="e_lot_tracking_1" autocomplete="off" type="hidden" name="e_lot_tracking[]" class="out form-control" 
                value="<?php echo $drug["d_lotTracking"]?>" >
              </div></td>
            <td><?if ($drug["d_lotTracking"]) { ?>
              <table id="lots_table_1" class="table table-bordered">
                <thead>
                  <tr>
                    <td>Lot Number</td>
                    <td>Lot Expiration Date</td>
                    <td>Lot QOH</td>
                    <td>Lot Qty Out</td>
					
                    <td>Remove</td>
                  </tr>
                </thead>
                <tbody id="add_lots_1">
                </tbody>
              </table>
              <div>
                <input type="button" class="btn btn-success" value="Add Lot" onclick="addNewLotsMulti('', '', '', '', '#add_lots_1', 1, <?= @$drug['d_id'] ?>);" style="float: right">
                <br>
                <br>
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

	var LOTS = <?= json_encode($lots_data) ?>;
		var LOTS2 = <?= json_encode($lots_data) ?>;

	var LID = 0;
	var GLOBAL_DRUG_ID = 1;
	var NEED_CHECK_SUM = false;
	var DRUG_AND_LOTS = {};
	var LOT_TRACKING = false;
	var FIRST_LOT_ADDED = false;

	<? if (@$drug["d_lotTracking"]) { ?>
	LOT_TRACKING = true;
	<? } ?>


	function checkRX_Transaction(code)
	{
		//1442597820
		jQuery.ajax({
			type: "POST",
				dataType: "json",
			url: '/logbook/checkLotRXCode',
			data: {
				"e_code": code
			},
			cache: false,

			success: function(response){
				//alert(response.e_lot);
			
				
				if(response.e_rx!=null) {
					//alert("e_rx:"+response.e_rx);
					var data = {"date_created":response.e_date};
					var edate = {"date_expiry":response.e_expiration};
var date = new Date(parseInt(data.date_created, 10) * 1000);
var expdate = new Date(parseInt(edate.date_expiry, 10) * 1000);

d=date.toLocaleString();
ed=expdate.toLocaleString();

					$("#SomeDiv_e_date").html(d);

					$("#SomeDiv_e_type").html(response.e_type);
				$("#SomeDiv_e_rx").html(response.e_rx);
					$("#SomeDiv_e_invoice").html(response.e_invoice);
					$("#SomeDiv_NDC").html(response.d_code);
						$("#SomeDiv_d_name").html(response.d_name);
							$("#SomeDiv_v_name").html(response.v_name);
							   
	$("#SomeDiv_d_size").html(response.d_size);
		$("#SomeDiv_e_out_total").html(response.e_out_total);
			$("#SomeDiv_e_lot").html(response.e_lot);
				$("#SomeDiv_e_expiration").html(ed);
				$("#SomeDiv_username").html(response.username);
				$("#SomeDiv").css("display","block");
				$("#erx_warning").css("display", "block");
					$("#erx_warning2").css("display", "block");

				$("#confirmdiv").css("display","none");
				}
				 else {
					 	$("#SomeDiv").css("display","none");
					$("#erx_warning").css("display", "none");
					$("#erx_warning2").css("display", "none");
					$("#confirmdiv").css("display","block");
				}
			},
			error: function(response) {

			}
		});

	}
function ConfirmDialog(message){
    $('<div></div>').appendTo('body')
                    .html('<div><h6>'+message+'?</h6></div>')
                    .dialog({
                        modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Yes: function () {
                                // $(obj).removeAttr('onclick');                                
                                // $(obj).parents('.Parent').remove();

                                $(this).dialog("close");
                            },
                            No: function () {
                                $(this).dialog("close");
                            }
                        },
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });
    };
	function removeLotsFromTableSimple(row_id)
	{
		$("#lotrow_" +  "_" + row_id).remove();
		recountLots();

	}

	function removeLotsFromTable(tableId, row_id)
	{
		$("#lotrow_" +  row_id).remove();
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
		var maxval = $("#oldqoh_" + lid).html() * 1;
		var myval = $(field).val() * 1;

		if (myval > maxval) $(field).val(maxval);
		$("#nlqoh_brt_"+lid).val(maxval-$(field).val());
	}

	function addNewLotsMulti()
	{
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

		$(to_field).append('<tr id="lotrow_' + table_id + '_' + LID + '">' +
		'<td><select class="form-control" id="lot_select_' + LID + '"><option>None</option></select><input type="hidden" lid="' + LID + '" drug-id="' + drug_id + '" id="elot_' + LID + '" name="out_lot_' + drug_id + '[]" class="e_lot" value="' + e_lot + '" required/></td>'+
		'<td><input type="text" id="edate_' + LID + '" name="out_expiration_' + drug_id + '[]" class="form-control datetimeST3" value="' + e_date + '" required/></td>' +
		'<td><div id="oldqoh_' + LID + '">' + e_old_qoh + '</div><input id="oldqoh_f_' + LID + '" name="out_oldqoh_' + drug_id + '[]" type="hidden" value="' + e_old_qoh + '"></td>' +
		'<td><input type="text" lid="' + LID + '" name="out_qoh_' + drug_id + '[]" onkeypress="checkMaxQOH(this);" onkeyup="checkMaxQOH(this); recountAllPossibleLotsCount();" autocomplete="off" class="audit_qohs_' + table_id + ' form-control" value="' + e_qoh + '" required/></td>' +
		'<td><a href="javascript://void();" onclick="removeLotsFromTable(' + table_id + ', ' + LID + ');">remove</a></td>' +
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

	function addNewLots()
	{
		LID += 1;
		var e_lot = arguments[0] || "";
		var e_date = arguments[1] || "";
		var e_qoh = arguments[2] || "";
		var e_old_qoh = arguments[3] || 0;
		var where = arguments[4] || "";
		var table_id = arguments[5] || "";
		
		var to_field = "#add_lots";
			if (where) to_field = where;
	$(to_field).append('<tr id="lotrow_' + table_id + '_' + LID + '">' +
		'<td><select class="form-control" id="lot_select_' + LID + '" onchange="checkalready(' + LID + ')";><option>None</option></select><input type="hidden" lid="' + LID + '" drug-id="<?= @$drug["d_id"] ?>" id="elot_' + LID + '" name="audit_lot[]" value="' + e_lot + '" required/></td>'+
		//'<td><input type="text" lid="' + LID + '" drug-id="<?= @$drug["d_id"] ?>" id="elot_' + LID + '" name="audit_lot[]" class="e_lot form-control" value="' + e_lot + '" required/></td>' +
		'<td><input type="text" id="edate_' + LID + '" name="audit_expiration[]" class="form-control" readonly value="' + e_date + '" required/></td>' +
		'<td><div id="oldqoh_' + LID + '">' + e_old_qoh + '</div><input id="oldqoh_f_' + LID + '" name="audit_oldqoh[]" type="hidden" value="' + e_old_qoh + '"></td>' +
		'<td><input type="text" lid="' + LID + '" name="audit_qoh[]" onkeypress="checkMaxQOH(this);" autocomplete="off" onkeyup="checkMaxQOH(this); recountLots();" class="audit_qohs form-control" value="' + e_qoh + '" required/></td>' +'<td><input id="nlqoh_brt_' + LID + '" name="audit_nlqohbrt[]" type="text" readonly class="form-control" value=""></td>' +
		'<td><a href="javascript://void();" onclick="removeLotsFromTableSimple(' + LID + ');">remove</a></td>' +
		'</tr>');
	
		initLotList(".e_lot");
		initDatePicker();
		recountLots();
		FIRST_LOT_ADDED = true;
		
		loadLotsForSelectByDrugID("#lot_select_" + LID, <?= @$drug["d_id"] ?$drug["d_id"] :0 ?>, LID);
	}
	
	
	function checkalready(lid)
	{

	alert(lid);
	alert("checkalready fn");
		for (var i = 0; i < lid; i++) {
			if(i==lid) continue;
			if ($("#lot_select_"+i).val() == $("#lot_select_"+lid).val()) {

				alert("Not Allowed");
				$("#lot_select_"+lid).val("NONE");
				return false;
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

	function loadLotsForSelectByDrugID(field, drugId, numField)
	{
		$.ajax({
			url: "<?php echo site_url('logbook/getJSON_lots/with_date_and_count'); ?>",
			dataType: "json",
			data: {
				q: "",
				drugId: drugId
			},
			success: function(data) {
				for (var i = 0; i < data.length; i++)
				{
					$(field).append("<option value='" + data[i] + "'>" + data[i] + "</option>");
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
				if($("#button").val() == "Confirm Entry") 
				$("#button").attr("disabled", true);
				$("#another2").attr("disabled", true);
			}
		}
		
	}

	function recountLotsMultiple(field, tableId)
	{
		var TOTAL_QOH = 0;
		var TOTAL_UNITS = $("#e_out_" + tableId).val() * 1;
		
		//if($("#e_lot_tracking_" + tableId).val() == 1) // if lot tracking is enabled
		//{
			$(field).each(function(i){
				TOTAL_QOH += +$(this).val();
			});
			var REMAIN = TOTAL_UNITS - TOTAL_QOH;
			$("#lots_total_count_" + tableId).html("<b>Lot Total: " + TOTAL_QOH + "</b>");
			$("#lots_remain_count_" + tableId).html("<b>Total Remaining: " + REMAIN + "</b>");
		//}
		//else
		//{
		// REMAIN = $('#total').text();
		//}

		if(REMAIN == 0)
		return true;
		else
		return false;
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
        table.removeClass('hidden');
        $('#inputNdc').attr('disabled', true);
        $('#button0').attr('disabled', true);
        if (id == 2){
            $('#button2').attr('disabled', true)
        }
        else if (id == 3){
            $('#button1').attr('disabled', true)
        }
        else if (id ==4){
            var out_all = $('#qty_out2').val();
            $('#qty_all').text(out_all);
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
        $('#qty_out').keyup(function(){
            var row = $(this).parent().parent().parent();
            var onHand = $('#qtyOnHand').text();
            var out = $('#qty_out').val();
            var newVal = onHand - out;
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
		
		$('#qty_out_multiple').keyup(function(){
			
            var sum = 0;
            $('.qty_one').each (function (i) {
                sum+= +$(this).text();
            });
            var total = $('#qty_all').text() - sum;
           // $('#total').text(total);
			
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
			addNewLots();
			addNewLotsMulti('', '', '', '', '#add_lots_1', 1, <?= @$drug["d_id"] ?$drug["d_id"] :0; ?>);
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
                    lotCell = '<table id="lots_table_' + GLOBAL_DRUG_ID + '" class="table table-bordered"><thead><tr><td>Lot Number</td><td>Expiration Date</td><td>QOH</td><td>Qty Out</td><td>Remove</td></tr></thead><tbody id="add_lots_' + GLOBAL_DRUG_ID + '"></tbody></table>' + '<div><input type="button" class="btn btn-success" value="Add Lot" style="float: right" onclick="addNewLotsMulti(\'\', \'\', \'\', \'\', \'#add_lots_' + GLOBAL_DRUG_ID + '\', ' + GLOBAL_DRUG_ID + ', ' + response.d_id + ');"><div id="lots_total_count_' + GLOBAL_DRUG_ID + '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Lot Total: 0</b></div><div id="lots_remain_count_' + GLOBAL_DRUG_ID + '" style="display: inline-block; text-align: right; width: 100%; padding: 10px;"><b>Total Remaining: 0</b></div></div>';
                }

				childRow.append('<tr id="'+response.d_id+'">' +
				'<input type="hidden" value="'+response.d_id+'" name="e_drugId[]">' +
				'<input type="hidden" value="'+response.d_onHand+'" name="e_old[]">' +
				'<input class="input1" type="hidden" name="e_new[]">' +
				'<td class="ndc">'+response.d_code+'</td><td>'+response.d_name+'</td>' +
				'<td class="hand">'+response.d_onHand+'</td><td><div class="form-group">' +
				'<input id="e_out_' + GLOBAL_DRUG_ID + '" type="text" name="e_out[]" class="out form-control">' +
				'<input id="e_lot_tracking_'+ GLOBAL_DRUG_ID +'" autocomplete="off" type="hidden" name="e_lot_tracking[]" class="out form-control" '+
                'value="'+ response.d_lotTracking +'" > </div></td>' +
                '<td>' + lotCell + '</td>' +
				'<td class="variance"></td>' +
				'<td><div class="form-group">' +
				'<input type="text" name="e_note[]" class="note form-control uppercase"></div></td></tr>');
                var childTotal = $('#total').parent().before('<tr id="total'+response.d_id+'"><td>'+response.d_code+'</td><td class="qty_one"></td></tr>');
                $('.out').unbind();
                $('.save-form').data('bootstrapValidator', null);
				
				if (response.d_lotTracking == 1)
				addNewLotsMulti('', '', '', '', '#add_lots_' + GLOBAL_DRUG_ID, GLOBAL_DRUG_ID, response.d_id);

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
</script>
