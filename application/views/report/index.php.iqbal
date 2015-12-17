<h2>Reports</h2>

<form action="<?=base_url()?>report/generate" method="post" class="middle">
    <div class="form-group">
        <label>Specify <!--Date or--> Date Range</label>
        <!--<div class="radio">
            <input class="radios" name="dates" type="radio"  value="one" checked>Date
        </div>
        <div class="radio">
            <input class="radios" name="dates" type="radio"  value="range">Date Range
        </div>-->
    </div>
    <div class="form-group">
        <div class="row" id="dateRow">
            <div class="col-md-6" id="firstDate">
                <label id="firstDateLabel1">From</label>
                <!--<label id="firstDateLabel2">Select Date</label>-->
                <input type="text" name="date1" class="datetimeST form-control" required="">
            </div>
            <div class="col-md-6" id="secondDate">
                <label>To</label>
                <input type="text" name="date2" class="datetimeST form-control">
            </div>
        </div>


    </div>
    <div class="form-group">
        <label>Specify Report Type</label>
        <select name="type" class="form-control" id="selectType" required="">
            <option value="" selected>Select Report</option>
            <option value="in">Inventory In</option>
            <option value="out">Inventory Out</option>
            <option value="audit">Inventory Audit</option>
            <option value="all">All transactions</option>
            <option value="drug">Drug Catalog</option>
            <option value="vendor">Vendor Catalog</option>

            <option value="cat">Category</option>
            <option value="ndc">NDC</option>
            <option value="dname">Drug Name</option>
        </select>
    </div>

	<div class="form-group" id="catListBlock">
		<label>Select Category</label>
		<div id="jstree"></div>
		<input id="catList" name="catList" type="hidden" />
		<!--<select name="catList" class="form-control" id="catList">
			<? foreach ($catlist as $cat) { ?>
				<option value="<?= $cat["c_id"] ?>"><?= $cat["c_name"] ?></option>
			<? } ?>
		</select>-->

	</div>

	<div class="form-group" id="ndcInputBlock">
		<label>NDC</label>
		<input name="ndcInput" class="form-control" id="ndcInput" value="" data-mask="99999-9999-99" />
	</div>

	<div class="form-group" id="drugNameBlock">
		<label>Drug Name</label>
		<input name="drugName" class="form-control" id="drugName" value="" />
	</div>

    <!--<div class="form-group">
        <label>3. Enter search query</label>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="query" class="form-control">
            </div>
            <div class="col-md-6">
                <select name="field" class="form-control" id="fSelect">
                    <option value="d_name" class="dOption" id="dFirstOption">Medication Name</option>
                    <option value="d_code" class="dOption">NDC Code</option>
                    <option value="d_manufacturer" class="dOption">Manufacturer</option>
                    <option value="e_rx">Prescription or Transaction Number</option>
                    <option value="username">Username</option>
                    <option value="e_invoice">Invoice Number</option>
                    <option value="v_name" id="vOption">Vendor</option>
                    <option value="d_status" class="dOption">Drug Status</option>
                </select>
            </div>
        </div>
    </div>-->
    <div class="form-group">
        <label>Select Report Parameters</label>
        <div class="notVendor">
            <div class="checkbox in out audit notDrug">
                <input type="checkbox" name="parameters[]" value="e_type" class="autoAll">
                Transaction Type
            </div>
            <div class="checkbox in out audit notDrug">
                <input type="checkbox" name="parameters[]" value="e_date" class="autoIn autoOut autoAudit autoAll">
                Date Entered
            </div>
            <div class="checkbox notIn notOut notAudit drug notAll">
                <input type="checkbox" name="parameters[]" value="d_created" class="autoDrug">
                Date Created
            </div>
            <div class="checkbox in out notAudit notDrug">
                <input type="checkbox" name="parameters[]" value="e_invoice" class="autoIn autoAll">
                Invoice #
            </div>
            <div class="checkbox in out notAudit notDrug">
                <input type="checkbox" name="parameters[]" value="v_name" class="">
                Vendor
            </div>
            <div class="checkbox in out audit drug ">
                <input type="checkbox" name="parameters[]" value="c_name" class="">
                Category
            </div>
            <div class="checkbox in out audit drug ">
                <input type="checkbox" name="parameters[]" value="d_code" class="autoIn autoOut autoAudit autoDrug autoAll">
                NDC
            </div>
            <div class="checkbox notIn notOut notAudit drug notAll">
                <input type="checkbox" name="parameters[]" value="d_barcode" class="">
                Barcode
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="d_name" class="autoIn autoOut autoAudit autoDrug autoAll">
                Name
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="d_descr" class=" autoDrug">
                Description
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="d_size"  class="autoIn autoDrug autoAll">
                Package Size
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="d_manufacturer" class=" autoDrug">
                Manufacturer
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="d_schedule" class="">
                Schedule
            </div>
            <div class="checkbox notIn notOut notAudit drug notAll">
                <input type="checkbox" name="parameters[]" value="d_start" class="">
                Starting Inventory<!-- in Units-->
            </div>
            <div class="checkbox in notOut notAudit notDrug">
                <input type="checkbox" name="parameters[]" value="qty_in" class="autoIn autoAll">
                Quantity In
            </div>
            <div class="checkbox in notOut notAudit drug">
                <input type="checkbox" name="parameters[]" value="e_costPack" class="">
                Cost / Pack
            </div>
            <div class="checkbox in notOut notAudit drug">
                <input type="checkbox" name="parameters[]" value="costUnit" class="">
                Cost / Unit
            </div>
            <div class="checkbox notIn out notAudit notDrug">
                <input type="checkbox" name="parameters[]" value="e_out" class="autoOut autoAll">
                Quantity Out
            </div>
            <div class="checkbox in out notAudit notDrug">
                <input type="checkbox" name="parameters[]" value="e_lot" class="">
                Lot #
            </div>
            <div class="checkbox in out notAudit notDrug">
                <input type="checkbox" name="parameters[]" value="e_expiration" class="">
                Exp<!--iration--> Date
            </div>
            <div class="checkbox in out notAudit notDrug">
                <input type="checkbox" name="parameters[]" value="e_rx" class="autoOut autoIn autoAll" >
                RX / Trans #
            </div>
            <div class="checkbox in out notAudit drug">
                <input type="checkbox" name="parameters[]" value="d_onHand" class="autoIn autoOut autoAudit autoDrug autoAll ">
                Quantity on Hand
            </div>
            <div class="checkbox notIn notOut audit notDrug">
                <input type="checkbox" name="parameters[]" value="e_old"  class="autoAudit autoAll ">
                Expected Quantity on Hand
            </div>
            <div class="checkbox notIn notOut audit notDrug">
                <input type="checkbox" name="parameters[]" value="e_new"  class="autoAudit autoAll ">
                Actual Quantity on Hand
            </div>
            <div class="checkbox notIn notOut audit notDrug">
                <input type="checkbox" name="parameters[]" value="variance" class="autoAudit autoAll ">
                Variance
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="a_status" class="">
                Active Status
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="in_status" class="">
                Inactive Status
            </div>
            <div class="checkbox in out audit drug">
                <input type="checkbox" name="parameters[]" value="username" class="">
                Username
            </div>
            <div class="checkbox notIn notOut notAudit drug notAll">
                <input type="checkbox" name="parameters[]" value="d_modified" class=" autoDrug autoAll">
                Last Modified
            </div>

            <div class="checkbox in out audit notDrug">
                <input type="checkbox" name="parameters[]" value="e_note" class="">
                Notes
            </div>
        </div>

        <div class="vendor">
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_name" class="autoVendor ">
                Name
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_address" class="">
                Address
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_city" class="autoVendor ">
                City
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_state" class="autoVendor ">
                State
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_zip" class="">
                Zipcode
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_tel" class="autoVendor ">
                Tel
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_fax" class="">
                Fax
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_email" class="">
                Email
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_license" class="autoVendor ">
                License Number
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_dea" class="autoVendor ">
                DEA
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_cname" class="">
                Contact Name
            </div>
            <div class="checkbox">
                <input type="checkbox" name="parameters[]" value="v_status" class="">
                Status
            </div>
        </div>
    </div>
    <input type="submit" value="Ok" class="btn btn-primary">
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/jstree.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/themes/default/style.min.css" rel="stylesheet">

<script>
	function initTree()
	{
		$('#jstree').jstree({
			'core': {
				'data': <?= json_encode($catlist); ?>
			}
		});

		$("#jstree").bind(
			"changed.jstree", function(evt, data){
				console.log(data.selected);
				$("#catList").val(data.selected);
			}
		);
	}

    $(document).ready(function() {
        //$('#secondDate').hide();
        //$('#firstDateLabel1').hide();
        //$('#dPar').hide();
        //$('#vPar').hide();

		initTree();

		$('#catListBlock').hide();
		$('#ndcInputBlock').hide();
		$('#drugNameBlock').hide();
    });
/*
    $( ".radios" ).change(function() {
        $('#secondDate').toggle();
        $('#firstDateLabel1').toggle();
        $('#firstDateLabel2').toggle();
    });
*/
    $( "#selectType" ).change(function() {
        var type = $(this).val();

		$('#catListBlock').hide();
		$('#ndcInputBlock').hide();
		$('#drugNameBlock').hide();

        if ((type == 'drug') || (type == 'vendor')) {
            $('#dateRow').find('input').attr('disabled', true);
            $('#firstDate').find('input').attr('required', false);
            //$( ".radios" ).attr('disabled', true);
            if (type == 'drug'){
                $('.notDrug').hide();
                $('.vendor').hide();
                $('.notVendor').show();
                $('.drug').show();
                $('.autoDrug').prop('checked', true);
                $(':not(.autoDrug)').prop('checked', false);
                /*$('#fSelect').find('option').attr('disabled', true);
                $('.dOption').attr('disabled', false);
                $('#dFirstOption').attr('selected', true);*/
            } else {//vendor
                $('.vendor').show();
                $('.notVendor').hide();
                $('.autoVendor').prop('checked', true);
                $(':not(.autoVendor)').prop('checked', false);
                /*$('#fSelect').find('option').attr('disabled', true);
                $('#vOption').attr('disabled', false);
                $('#vOption').attr('selected', true);*/
            }
        } else {
            $('#dateRow').find('input').attr('disabled', false);
            $('#firstDate').find('input').attr('required', true);
            //$( ".radios" ).attr('disabled', false);
            $('.vendor').hide();
            $('.notVendor').show();

			if (["cat", "ndc", "dname"].indexOf(type) != -1)
			{
				$('.in').show();
				$('.out').show();
				$('.audit').show();
				$('.notAll').hide();
				$('.autoAll').prop('checked', true);
				$(':not(.autoAll)').prop('checked', false);
			}

			if (type == 'cat') {
				$('#catListBlock').show();
			}

			if (type == 'ndc') {
				$('#ndcInputBlock').show();
			}

			if (type == 'dname') {
				$('#drugNameBlock').show();
			}

            if (type == 'in') {
                $('.in').show();
                $('.notIn').hide();
                $('.autoIn').prop('checked', true);
                $(':not(.autoIn)').prop('checked', false);
            }
            else if (type == 'out') {
                $('.out').show();
                $('.notOut').hide();
                $('.autoOut').prop('checked', true);
                $(':not(.autoOut)').prop('checked', false);
            }
            else if (type == 'audit') {
                $('.audit').show();
                $('.notAudit').hide();
                $('.autoAudit').prop('checked', true);
                $(':not(.autoAudit)').prop('checked', false);
            }
            else if (type == 'all') {
                $('.in').show();
                $('.out').show();
                $('.audit').show();
                $('.notAll').hide();
                $('.autoAll').prop('checked', true);
                $(':not(.autoAll)').prop('checked', false);
            }
            //$('#fSelect').find('option').attr('disabled', false);
        }
        //console.log(type);
    });

	initSearchDrugs("drugName");

	function initSearchDrugs(field)
	{
		$("#" + field).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "/drug/getJSON/",
					dataType: "json",
					data: {
						q: request.term,
						type: "report"
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 1,
			select: function( event, ui ) {
				var id = ui.item.label.split(" - ");
				setTimeout(function() {
					$("#" + field).val(id[0]);
				}, 100);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	}

    $('.datetimeST').datetimepicker({
        pickDate: true,
        pickTime: false,
        format: 'MM/DD/YYYY',
        maxDate: '<?=date('m-d-Y', strtotime('today'))?>'
    });
</script>