<h2>Inventory Audit</h2>

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

<?if (@empty($drug)&&($first == false)){?>
    <p>There are no drugs with specified NDC.</p>
    <a href="<?=base_url()?>drug/add_drug" target="_blank" class="btn btn-primary">New drug</a>
<?} else if (!@empty($drug)){?>

    <label><?=$drug['d_name']?><? if($drug['d_status'] == '0'){ echo ': Inactive';}?></label><br>

    <button class="btn btn-primary" onclick="show_table(1)" <? if($drug['d_status'] == '0'){ echo 'disabled';}?>>Continue</button>
    <a href="<?=base_url()?>logbook/" class="btn btn-danger">Cancel</a>


    <div class="row hidden" id="table1">

            <!--<form action="logbook/save_entry" method="post">-->
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
            <input type="button" id="button1" onclick="show_table(2)" value="Audit" class="btn btn-info">

            <!--</form>-->

    </div><!--row-->

    <div class="row hidden" id="table2">
    	<form id="auditform" action="<?=base_url()?>logbook/save" method="post">
			<input type="hidden" value="<?=$drug['d_id']?>" name="e_drugId">
			<input type="hidden" value="<?=$drug['d_onHand']?>" name="e_old">
			<input type="hidden" id="e_total" name="e_total">
			<input type="hidden" id="e_operator" name="e_operator" value="+">
			<input type="hidden" value="audit" name="e_type">

			<table class="table table-bordered entry-table">
				<thead>
					<tr>
						<td>Date</td>
						<td>Quantity on hand</td>
						<td>Actual Quantity on Hand</td>
						<td>Confirm Actual Quantity on hand</td>
						<td>Variance</td>
						<td>Notes</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" value="<?=date('m/d/Y H:i')?>" name="e_date" class="form-control datetimeST" readonly required></td>
						<td id="onHand"><?=$drug['d_onHand']?></td>
						<td class="twoInputs"><input id="actual" type="text" class="form-control"  required></td>
						<td class="twoInputs"><input id="new_onHand" type="text" name="e_new" onkeyup="NEW_QOH=this.value * 1; recountLots(); zeroCheck();" class="form-control" required></td>
						<td id="variance"></td>
						<td><input type="text" name="e_note" class="form-control uppercase" required></td>
					</tr>
				</tbody>
			</table>
            <div id="div_audit_lots_table" style="width: 50%; display: none">
                <table id="audit_lots_table" class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Lot Number</td>
                            <td>Expiration Date</td>
                            <td>QOH per Lot Number</td>
                            <td>Remove</td>
                        </tr>
                    </thead>
                    <tbody id="add_lots">

                    </tbody>
                </table>
                <button class="btn btn-success" id="addnewlots_btn_sm" onclick="addNewLots();" type="button" style="float: right; display: none">Add lot</button><br><br>
                <div id="lots_total_count" style="text-align: right; padding: 5px;"><b>Lot Total: 0</b></div>
                <div id="lots_remain_count" style="text-align: right; padding: 5px;"><b>Total Remaining:  </b></div>
            </div>
			<input id="submit" type="submit" value="Confirm" class="btn btn-primary" disabled>
			<button class="btn btn-primary" type="submit" id="confirm_new" name="confirm_new" disabled>Confirm & New Audit</button>
			<?if ($drug["d_lotTracking"]) { ?>
			<button class="btn btn-success" id="addnewlots_btn" onclick="addNewLots();" type="button">Confirm and Add Lot # / Exp Date</button>
			<? } ?>
    	</form>
    </div>

<?}?>

<script>

	var NEW_QOH = 0;
	var TOTAL_QOH = 0;
	var LID = 0;
	var FIRST_OPEN_ADDLOTEXPDATE = false;

	initLotList(".e_lot");

	//applyValidator();

    function zeroCheck() {
        if (NEW_QOH == 0) {
            $("#addnewlots_btn").removeAttr("disabled");
        }
    }
	function recountLots()
	{
		TOTAL_QOH = 0;

		$('.audit_qohs').each(function(i) {
			TOTAL_QOH += +$(this).val();
		});
		var REMAIN = NEW_QOH - TOTAL_QOH;

		if (TOTAL_QOH != NEW_QOH)
		{
			$("#submit").attr("disabled", true);
			$("#confirm_new").attr("disabled", true);
			$("#addnewlots_btn").removeAttr("disabled");

		} else {
			$("#submit").removeAttr("disabled");
			$("#confirm_new").removeAttr("disabled");
			$("#addnewlots_btn").attr("disabled", true);
		}

		$("#lots_total_count").html("<b>Lot Total: " + TOTAL_QOH + "</b>");
        $("#lots_remain_count").html("<b>Total Remaining: " + REMAIN + "</b>");
	}

	function removeLotsFromTable(id)
	{
		$("#lotrow_" + id).remove();

		recountLots();
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

		$("#add_lots").append('<tr id="lotrow_' + LID + '">' +
		'<td><input type="text" lid="' + LID + '" id="elot_' + LID + '" name="audit_lot[]" class="e_lot form-control" value="' + e_lot + '" required/></td>' +
		'<td><input type="text" id="edate_' + LID + '" name="audit_expiration[]" class="form-control datetimeST1" value="' + e_date + '" required/></td>' +
		'<td><input type="text" name="audit_qoh[]" onkeyup="recountLots()" class="audit_qohs form-control" value="' + e_qoh + '" required/></td>' +
		'<td><a href="javascript://void();" onclick="removeLotsFromTable(' + LID + ');">remove</a></td>' +
		'</tr>');

		//$("#audit_lots_table").css("display", "table");
        $('#div_audit_lots_table').show();
        $('#addnewlots_btn_sm').show();
        $('#addnewlots_btn').hide();
		initLotList(".e_lot");
		initDataPicker();
		$("#submit").attr("disabled", true);
		$("#confirm_new").attr("disabled", true);
		recountLots();

		$("#auditform input[name=e_type]").val("audit_mul");
	}

	function initLotList(field)
	{
		$(field).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "/logbook/getJSON_lots/with_date",
					dataType: "json",
					data: {
						q: ""
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
				}, 150);

				//setTimeout(function()
				//{
					/*checkLotExpires();
					checkActiveLot();
					$('.save-form').bootstrapValidator('revalidateField', 'e_lot');
					$('.save-form').bootstrapValidator('revalidateField', 'e_lot[]');*/
					//$('.save-form').bootstrapValidator('revalidateField', 'audit_lot[]');
				//}, 150);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	}

	function applyValidator()
	{
		$('#auditform').bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			excluded: ':disabled',
			fields: {
				'audit_qoh[]': {
					message: 'Qty is not valid',
					validators: {
						notEmpty: {
							message: 'Qty is required and cannot be empty'
						},
						regexp: {
							regexp: /^[0-9]+$/,
							message: 'Qty can only consist of numerical characters'
						}
					}
				}
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


    $(document).ready(function() {
        //$('.datetimeST').click('today');
        $('#actual').keyup(function(){
            var act = $('#actual').val();
            var newVal = $('#new_onHand').val();
            var oldVal = $('#onHand').text();
            var two_inputs = parseFloat(newVal)-parseFloat(act);
            var new_old = parseFloat(act)-parseFloat(oldVal);
            //console.log(new_old);
            if(new_old !== 'NaN') {
                $('#variance').text(new_old);
            }

            if (two_inputs == 0){
                $('#submit').attr('disabled', false);
                $('#confirm_new').attr('disabled', false);

				if (FIRST_OPEN_ADDLOTEXPDATE) recountLots();
            }
            else {
                $('#submit').attr('disabled', true);
                $('#confirm_new').attr('disabled', true);
            }
        });

        $('#new_onHand').keyup(function(){
            var act = $('#actual').val();
            var newVal = $('#new_onHand').val();
            var oldVal = $('#onHand').text();
            var two_inputs = parseFloat(newVal)-parseFloat(act);
            var new_old = parseFloat(act)-parseFloat(oldVal);
            if(new_old !== 'NaN') {
                $('#variance').text(new_old);
            }


            if (two_inputs == 0){
                $('#submit').attr('disabled', false);
                $('#confirm_new').attr('disabled', false);

				if (FIRST_OPEN_ADDLOTEXPDATE) recountLots();
            }
            else {
                $('#submit').attr('disabled', true);
                $('#confirm_new').attr('disabled', true);
            }
        });

        /*$('#new_onHand').keyup(function(){
            var act = $('#actual').val();
            var newVal = $('#new_onHand').val();
            var variance = parseFloat(newVal)-parseFloat(act);
            var oldVal = $('#onHand').text();
            var two_inputs = parseFloat(newVal)-parseFloat(act);
            var new_old = parseFloat(act)-parseFloat(oldVal)

            if ((two_inputs == 0)&&(new_old !== 0)){
                $('#submit').attr('disabled', false);
            }
            else {
                $('#submit').attr('disabled', true);
            }
        })*/

    });


    /*$('.datetimeST').datetimepicker({
        pickDate: true,
        pickTime: true,
        format: 'MM/DD/YYYY HH:mm',
        //minDate: new Date(),
        //maxDate: new Date(),
        defaultDate: dateNow
    });*/

	function initDataPicker() {
		$('.datetimeST1').datetimepicker({
            pickDate: true,
            pickTime: false,
            format: 'MM/DD/YYYY'
            //minDate: new Date(),
            //maxDate: new Date(),
            //defaultDate: dateNow
		});
	}
</script>

