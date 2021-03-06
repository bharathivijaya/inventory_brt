<style>
    .multiselect {
        width: 200px;
    }
    .selectBox {
        position: relative;
    }
    .selectBox select {
        width: 100%;
        font-weight: bold;
    }
    .overSelect {
        position: absolute;
        left: 0; right: 0; top: 0; bottom: 0;
    }
    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }
    #checkboxes label {
        display: block;
    }
    #checkboxes label:hover {
        background-color: #1e90ff;
    }
</style>
<script>
    var expanded = false;
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
</script>
<h2>Reports</h2>

<form action="<?=base_url()?>report/generate" method="post" class="left">
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
            <div class="col-md-3" id="firstDate">
                <label id="firstDateLabel1">From</label>
                <!--<label id="firstDateLabel2">Select Date</label>-->
                <input type="text" name="date1" class="datetimeST form-control" required="">
            </div>
            <div class="col-md-3" id="secondDate">
                <label>To</label>
                <input type="text" name="date2" class="datetimeST form-control">
            </div>



    
    <div class="col-md-3">
        <label>Specify Report Type</label>
        <select name="type" class="form-control" id="selectType" required="">
            <option value="" selected>Select Report</option>
            <option value="in">Inventory In</option>
            <option value="out">Inventory Out</option>
            <option value="audit">Inventory Audit</option>
			 <option value="deleted">Deleted transactions</option>
            <option value="all">All transactions</option>
            <option value="drug">Drug Catalog</option>
            <option value="vendor">Vendor Catalog</option>

            <option value="cat">Category</option>
            <option value="ndc">NDC</option>
            <option value="dname">Drug Name</option>
        </select>
    </div>

	<div class="col-md-3"> <label>Parameters</label>
<div class="multiselect">
        <div class="selectBox" onclick="showCheckboxes()">
            <select class="form-control">
                <option>Select an option</option>
            </select>
            <div class="overSelect"></div>
        </div>
        <div id="checkboxes">
            <label>  <input type="checkbox" name="parameters[]" value="e_deleteddate" class="autoDel">
               Date Deleted
           </label>
       
		  
			
             <label> <input type="checkbox" name="parameters[]" value="e_last_edit_date" class="">
               Date Edited</label>
             <label>
                <input type="checkbox" name="parameters[]" value="e_type" class="autoAll autoDel">
                Transaction Type</label>
          
           <label> <input type="checkbox" name="parameters[]" value="e_date" class="autoIn autoOut autoAudit autoAll ">
                Date Entered
          </label>
                <label><input type="checkbox" name="parameters[]" value="d_created" class="autoDrug">
                Date Created</label>
            <label><input type="checkbox" name="parameters[]" value="e_invoice" class="">
                Invoice #</label>
				           <label> <input type="checkbox" name="parameters[]" value="e_rx" class="autoOut autoIn autoAll autoDel" >
                RX / Trans #</label>
           <label> <input type="checkbox" name="parameters[]" value="v_name" class="">
                Vendor</label>
             <label><input type="checkbox" name="parameters[]" value="c_name" class="">
                Category
            </label>
               <label>  <input type="checkbox" name="parameters[]" value="d_code" class="autoIn autoOut autoAudit autoDrug autoAll autoDel">
                NDC</label>
            <label> <input type="checkbox" name="parameters[]" value="d_barcode" class="">
                Barcode</label>
             <label> <input type="checkbox" name="parameters[]" value="d_name" class="autoIn autoOut autoAudit autoDrug autoAll autoDel">
                Name</label>
            <label><input type="checkbox" name="parameters[]" value="d_descr" class=" autoDrug">
                Description</label>
            <label> <input type="checkbox" name="parameters[]" value="d_size"  class="autoIn autoDrug autoAll">
                Package Size</label>
            <label> <input type="checkbox" name="parameters[]" value="d_manufacturer" class=" autoDrug">
                Manufacturer</label>
           
              <label>   <input type="checkbox" name="parameters[]" value="d_schedule" class="">
                Schedule</label>
           <label> <input type="checkbox" name="parameters[]" value="d_start" class="autoIn autoAll">
                Starting Inventory<!-- in Units--></label>
             <label><input type="checkbox" name="parameters[]" value="qty_in" class="autoIn autoAll autoDel">
                Quantity In</label>
             <label><input type="checkbox" name="parameters[]" value="e_costPack" class="">
                Cost / Pack</label>
            <label><input type="checkbox" name="parameters[]" value="costUnit" class="">
                Cost / Unit</label>
            <label><input type="checkbox" name="parameters[]" value="e_out" class="autoOut autoAll autoDel">
                Quantity Out</label>
           
               <label> <input type="checkbox" name="parameters[]" value="e_lot" class="autoDel">
                Lot #</label>
           <label> <input type="checkbox" name="parameters[]" value="e_expiration" class="autoDel">
                Exp<!--iration--> Date</label>
 
            <label> <input type="checkbox" name="parameters[]" value="d_onHand" class="autoIn autoOut autoAudit autoDrug autoAll ">
                Quantity on Hand</label>
             <label><input type="checkbox" name="parameters[]" value="e_old"  class="autoAudit autoAll ">
                Expected Quantity on Hand</label>
            <label> <input type="checkbox" name="parameters[]" value="e_new"  class="autoAudit autoAll ">
                Actual Quantity on Hand</label>
            <label><input type="checkbox" name="parameters[]" value="variance" class="autoAudit autoAll ">
                Variance
          
             <label> <input type="checkbox" name="parameters[]" value="in_status" class="">
                Inactive Status</label>
           <label> <input type="checkbox" name="parameters[]" value="username" class="autoDel">
                Username</label>
             <label> <input type="checkbox" name="parameters[]" value="d_modified" class=" autoDrug autoAll">
                Last Modified</label>
              <label> <input type="checkbox" name="parameters[]" value="e_note" class="">
                Notes</label>
          
             <label>   <input type="checkbox" name="parameters[]" value="v_name" class="autoVendor autoDel">
                Name</label>
          <label><input type="checkbox" name="parameters[]" value="v_address" class="">
                Address</label>
           <label> <input type="checkbox" name="parameters[]" value="v_city" class="autoVendor ">
                City</label>
           <label> <input type="checkbox" name="parameters[]" value="v_state" class="autoVendor ">
                State</label>
            <label><input type="checkbox" name="parameters[]" value="v_zip" class="">
                Zipcode</label>
            <label> <input type="checkbox" name="parameters[]" value="v_tel" class="autoVendor ">
                Tel</label>
            <label> <input type="checkbox" name="parameters[]" value="v_fax" class="">
                Fax</label>
            <label> <input type="checkbox" name="parameters[]" value="v_email" class="">
                Email</label>
           <label> <input type="checkbox" name="parameters[]" value="v_license" class="autoVendor ">
                License Number</label>
            <label> <input type="checkbox" name="parameters[]" value="v_dea" class="autoVendor ">
                DEA</label>
             <label><input type="checkbox" name="parameters[]" value="v_cname" class="">
                Contact Name</label>
            <label> <input type="checkbox" name="parameters[]" value="v_status" class="">
                Status</label>
           

</div>
        </div>
    </div>
	<br>
<div class="row">
	<div class="col-md-3" id="catListBlock">
		<label>Select Category</label>
		<div id="jstree"></div>
		<input id="catList" name="catList" type="hidden" />
		<!--<select name="catList" class="form-control" id="catList">
			<? foreach ($catlist as $cat) { ?>
				<option value="<?= $cat["c_id"] ?>"><?= $cat["c_name"] ?></option>
			<? } ?>
		</select>-->

	</div>
	
	<div class="col-md-3" id="ndcInputBlock">
		<label>NDC</label>
		<input name="ndcInput" class="form-control" id="ndcInput" value="" data-mask="99999-9999-99" />
	</div>

<div class="col-md-3" id="drugNameBlock">
		<label>Drug Name</label>
		<input name="drugName" class="form-control" id="drugName" value="" />
	</div>
	
  <div class="col-md-3" >

    <input type="submit" value="Create Report" name="Ok" class="btn btn-primary">
	  </div>
	  </div></div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/jstree.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/themes/default/style.min.css" rel="stylesheet">



<?php if(isset($_POST['Ok'])) { ?>
<h2><?=$labels[$type]?> Report</h2>
<?/*print($ndc_num); print_r($fields);*/?>
<div id="report">
<table class="table" style="width: 100%" autosize="4" id="myTable">
    <thead style="font-weight: bold">
    <tr>
        <?foreach ($fields as $f) { if($labels[$f]=='Invoice #') {?><?php continue; }?>
		
            <td><?=$labels[$f]?></td>
        <?}?>
		<td>Action</td>
    </tr>
    </thead>
    <tbody>
    <? if($labels[$type]=="Inventory In" or $labels[$type]=="Inventory Out" ) {$tranid='';
	
	foreach ($entries as $one) {
	if($tranid!=$one['e_transaction_group_id']) { ?>
        <tr>
            <?foreach ($fields as $f) {?>
                <td class="<?if (($f == 'qty_in')||($f == 'e_out')) {echo 'units';}?>">
                    <?if (in_array($f, $dates)) { if ($one[$f] >0) {echo date('m-d-Y', $one[$f]);}}
                    else if ($f == 'qty_in') {
                        if ($one['e_type'] == 'new') {
                            echo $one['d_size']*$one['e_numPacks'];
                        }
                        else {
                            echo $one['e_returned'];
                        }
						
                    }
                    else if ($f == 'a_status') {
                        if ($one['d_status'] == 1) {
                            echo "Active";
                        }
                    }
                    else if ($f == 'in_status') {
                        if ($one['d_status'] == 0) {
                            echo "Inactive";
                        }
                    }
                    else if ($f == 'costUnit') {
                        if ($one['d_size'] == 0) {
                            echo '-';
                        }
                        else{
                            echo @$one['e_costPack']/$one['d_size'];
                        }

                    }
				else if($f=='e_invoice') {
					if($one[$f]!="") $one['e_rx']=$one[$f];
				}
                    else if ($f == 'e_type') {
                        if (($one[$f] == 'new') || ($one[$f] == 'return')) {
                            echo 'in';
                        }
                        else {
                            echo $one[$f];
                        }
                    }
                    else {
                        echo $one[$f];
                    }?>
                </td>
				
            <?}?>
			<form method="post" action="<?php echo base_url();?>edit_transaction/transaction_details/<?php echo $one['e_id']; ?>">
<td class="viewbut">
<input type="hidden" name="rep" id="rep" value="1"><input type="submit" value="View Transaction"  class="btn btn-primary"></td>
</form>
			
        </tr>
    <?}
	$tranid=$one['e_transaction_group_id'];
			}
			}
else if( $labels[$type]=="Deleted" )
	{?>

      <?php foreach ($entries as $entry) {?>
      <tr class="units">

        <td><?php echo date('m-d-Y', $entry->e_deleteddate) ?></td>
        <td>DELETED <?php if($entry->e_type == 'edit') 
			{ 
			echo strtoupper($entry->e_out == 0 ? ' In('.$entry->e_type.')' : 'Out('.$entry->e_type.')');  
			} 
			else 
			{ 
			echo strtoupper($entry->e_type =='new' ? 'in' : $entry->e_type); 
			} ?></td>
		 
        <td><?php echo $entry->e_rx.$entry->e_invoice; ?></td>
        <td><?php echo str_replace(',','<br/>',$entry->total_drug_codes)?></td>
        <td style="white-space:nowrap;overflow: hidden;max-width:100px;"><?php echo str_replace(',','<br/>',$entry->d_name); ?></td>
   
        <td><?php  if ($entry->e_type =='new' || $entry->e_out == 0) {               
                echo ($entry->total_new_qty - $entry->total_old_qty);
            } ?></td>
        <td><?php echo $entry->e_out_total; ?></td>
        <td><?php echo str_replace(',','<br/>',$entry->total_lots)?></td>
        <td><?php echo str_replace(',','<br/>',$entry->e_expiration); ?></td>
        
       <!-- <td><?php  if ($entry->e_last_edit_date == 0) {

                echo '';
            } else {
                echo date('m-d-Y', $entry->e_last_edit_date);
            } ?>
        </td>-->
        <td><?php echo $entry->username; ?></td>
		     <td><?php echo $entry->v_name; ?></td>
		<!--<td><?php if($entry->e_deleteddate==0 && $entry->e_status!=3) echo "NA"; else echo date('m-d-Y', $entry->e_deleteddate);?></td>-->
		<!--<td><?php if($entry->e_status==1) echo "New";
		if($entry->e_status==2) echo "Edit";
		if($entry->e_status==3) echo "Reversed"; ?></td>-->
        <td class="viewbut">
         
          <form method="post" action="<?php echo base_url();?>edit_transaction/deletedtransaction_details/<?php echo $entry->e_id; ?>">
<input type="submit" value="View Transaction"  class="btn btn-primary btn-xs">
</form>   
</td>
      </tr>
      <?php }
	}
			else
	{
				
	
	foreach ($entries as $one) {

	 ?>
        <tr>
            <?foreach ($fields as $f) {?>
                <td class="<?if (($f == 'qty_in')||($f == 'e_out')) {echo 'units';}?>">
                    <?if (in_array($f, $dates)) { if ($one[$f] >0) {echo date('m-d-Y', $one[$f]);}}
                    else if ($f == 'qty_in') {
                        if ($one['e_type'] == 'new') {
                            echo $one['d_size']*$one['e_numPacks'];
                        }
                        else {
                            echo $one['e_returned'];
                        }
						
                    }
                    else if ($f == 'a_status') {
                        if ($one['d_status'] == 1) {
                            echo "Active";
                        }
                    }
                    else if ($f == 'in_status') {
                        if ($one['d_status'] == 0) {
                            echo "Inactive";
                        }
                    }
                    else if ($f == 'costUnit') {
                        if ($one['d_size'] == 0) {
                            echo '-';
                        }
                        else{
                            echo @$one['e_costPack']/$one['d_size'];
                        }

                    }
				else if($f=='e_invoice') {
					if($one[$f]!="") $one['e_rx']=$one[$f];
				}
                    else if ($f == 'e_type') {
						if($one['e_status']==3) echo "DELETED  ";
                        if (($one[$f] == 'new') || ($one[$f] == 'return')) {
                            echo 'IN';
                        }
                        else {
                            echo strtoupper($one[$f]);
                        }
						
                    }
                    else {
                        echo $one[$f];
                    }?>
                </td>
				
            <?}?>
			<td></td>
		<?php if(	$labels[$type]=='All Transactions') {?>
 <td class="viewbut"><a href="<?php echo base_url();?>edit_transaction/transaction_details/<?php echo $one['e_id']; ?>">View Transaction</a></td><?php } ?>
        </tr>
    <?
	}
	}?>
    </tbody>

</table>

</div>
<form action="<?php echo base_url();?>report/create_pdf" method="post" id="myForm">
    <input type="hidden" value="" name='html' id="inp">
    <input type="hidden" value="<?=$labels[$type]?> Report" name="title">
    <input type="text" value="<?if (!@empty($date_range)){echo 'From '.$date_range[0].' To '.$date_range[1];}?>" name="date_range">
    <div class="radio">
        <label>No page breaks</label>
        <input type="radio" name="pb" value="no" checked>
    </div>
    <div class="radio">
        <label>Page breaks between each NDC</label>
        <input type="radio" name="pb" value="ndc" <?if (!in_array('d_code', $fields)) {echo 'disabled';}?>>
    </div>
    <div class="radio">
        <label>Page breaks between each category</label>
        <input type="radio" name="pb" value="cat" <?if (!in_array('c_name', $fields)) {echo 'disabled';}?>>
    </div>
    <button type="submit" class="btn btn-primary" >Create Pdf</button>
</form>

<script>
    $(document).ready(function() {
	//alert("am here");
		 $('.datetimeST').datetimepicker({
        pickDate: true,
        pickTime: false,
        format: 'MM/DD/YYYY',
        maxDate: '<?=date('m-d-Y', strtotime('today'))?>'
    });
	//initTree();

		$('#catListBlock').hide();
		$('#ndcInputBlock').hide();
		$('#drugNameBlock').hide();
        <?if (($type == 'in') ||($type == 'out')) {?>
			//alert(" in or out");
            var total = 0;
            $('.units').each(function (i, elem){
				//alert("units");
                console.log($(this).text());
                total = total + parseInt($(this).html());
				//alert(total);
            });
        <?}?>
			
$( "#selectType" ).change(function() {
		
        var type = $(this).val();

		$('#catListBlock').hide();
		$('#ndcInputBlock').hide();
		$('#drugNameBlock').hide();

        if ((type == 'drug') || (type == 'vendor')) {
            $('#dateRow').find('input').attr('disabled', false);
            $('#firstDate').find('input').attr('required', true);
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
			else if(type == 'deleted') {
				$('#delBlock').show();
				 $('.in').show();
				   $('.out').show();
				    $('.audit').show();
					  $('.autoDel').prop('checked', true); 
					/*  $('.autoAll').prop('checked', true);*/
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

          $('#myTable').DataTable({
            <? if ($ndc_num !== 0) {?>
                "columnDefs": [
                    { type: "phoneNumber", targets: <?=$ndc_num?> }
                ],
            <?}?>
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            <?if (($type == 'in') ||($type == 'out')) {?>
                "drawCallback": function( settings ) {
                    var total = 0;
                    $('.units').each(function (i, elem){
                        console.log($(this).text());
                        total = total + parseInt($(this).html());
                    });
                    $('#myTable').append('<tr><td><strong>Total Units <?=ucfirst($type)?> Per Report:</strong></td><td id="total">'+total+'</td></tr>');
                }
            <?}?>
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

   
    });

    jQuery("#myForm").submit(function(e) {
        var self = this;
        e.preventDefault();

        var html = $('#report').html();
        $('#inp').val(html);
        self.submit();

    });
  $('.datetimeST').datetimepicker({
        pickDate: true,
        pickTime: false,
        format: 'MM/DD/YYYY',
        maxDate: '<?=date('m-d-Y', strtotime('today'))?>'
    });
</script>
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

   
    
</script>
<?php } ?>