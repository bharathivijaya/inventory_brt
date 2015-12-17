<form action="<?=base_url()?>edit_transaction/search_transaction" method="post" >
  <div class="row form-group" style="margin-left:60px;">
    <h2>Search Transaction</h2>
    <div class="row" id="dateRow">
      <div class="col-md-12">
        <div class="col-md-3" id="firstDate">
          <label id="firstDateLabel1">From</label>
          <input type="text" name="fromDate" class="datetimeST form-control" placeholder="Select from date" value="">
        </div>
        <div class="col-md-3" id="secondDate">
          <label>To</label>
          <input type="text" name="toDate" class="datetimeST form-control" placeholder="Select to date" value="">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <label> <span style="margin:100px;"> Or </span> </label>
      </div>
    </div>
    <div class="row" id="dateRow">
      <div class="col-md-12">
        <div class="col-md-3">
       <input id="search_transaction" type="text" name="search_transaction" class="form-control" value="" placeholder="Search By NDC,Rx/Trans #,Name">
        </div>
        <div class="form-group">
          <input id="button0" type="submit" value="Search" class="btn btn-primary">
        </div>
      </div>
    </div>
  </div>
</form>

<?php if($this->session->flashdata('transaction_reversed_message')){?>
  <div class="alert alert-success">      
    <?php echo $this->session->flashdata('transaction_reversed_message')?>
  </div>
<?php } ?>

<?php if(isset($entries)) { ?>
<h3> Transactions</h3>
<div  id="report">
  <table class="table table-striped table-hover dt-responsive display" style="width:100%" cellspacing="0"   id="myTable">
    <thead style="font-weight: bold">
      <tr>
        <?foreach ($labels as $l) {
		if($l=='Status' or $l=='Deleted Date' ) continue;?>
        <td><?php echo $l ?></td>
        <?}?>
      </tr>
    </thead>
    <tbody>
      <?php  $checkrx="";foreach ($entries as $entry) {
	   if($checkrx!=($entry->e_rx.$entry->e_invoice)  ) {?>
      <tr class="units">
        <td><?php echo date('m-d-Y', $entry->e_date) ?></td>
        <td><?php if($entry->e_type == 'edit') 
			{ 
			echo strtoupper($entry->e_out == 0 ? ' In ('.$entry->e_type.')' : 'Out ('.$entry->e_type.')');  
			} 
			else 
			{ 
			echo strtoupper($entry->e_type =='new' ? 'in ' : $entry->e_type); 
			} ?></td>
		 
        <td><?php echo $entry->e_rx.$entry->e_invoice; ?></td>
        <td><?php echo str_replace(',','<br/>',$entry->total_drug_codes)?></td>
        <td style="white-space:nowrap;overflow: hidden;max-width:100px;"><?php echo str_replace(',','<br/>',$entry->d_name); ?></td>
        <td><?php echo $entry->v_name; ?></td>
        <td><?php  if ($entry->e_type =='new' || $entry->e_out == 0) {               
                echo ($entry->total_new_qty - $entry->total_old_qty);
            } ?></td>
        <td><?php echo $entry->e_out_total; ?></td>
        <td><?php echo str_replace(',','<br/>',$entry->total_lots)?></td>
        <td><?php echo str_replace(',','<br/>',$entry->e_expiration); ?></td>
        
        <td><?php  if ($entry->e_last_edit_date == 0) {

                echo '';
            } else {
                echo date('m-d-Y', $entry->e_last_edit_date);
            } ?>
        </td>
        <td><?php echo $entry->username; ?></td>
		<!--<td><?php if($entry->e_deleteddate==0 && $entry->e_status!=3) echo "NA"; else echo date('m-d-Y', $entry->e_deleteddate);?></td>-->
		<!--<td><?php if($entry->e_status==1) echo "New";
		if($entry->e_status==2) echo "Edit";
		if($entry->e_status==3) echo "Reversed"; ?></td>-->
        <td class="datatable-nosort"><div class="btn-group">
         
             
              <?php if($entry->e_out != 0 ) { ?>
              <a href="<?=base_url()?>edit_transaction/edit_entry_out/<?php echo str_replace(",","-",$entry->total_entry_ids); ?>">  <button type="button" class="btn btn-success dropdown-toggle btn-xs" >view/edit</button></a>
               <?php } else { ?>
               <a href="<?=base_url()?>edit_transaction/edit_entry_in/<?php echo str_replace(",","-",$entry->total_entry_ids); ?>">  <button type="button" class="btn btn-success dropdown-toggle btn-xs" >view/edit</button></a>
               <?php }?>
              
          
          </div></td>
      </tr>
      <?php } $checkrx=$entry->e_rx.$entry->e_invoice;
       }?>
    </tbody>
  </table>
  
</div>

<?php }?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/jstree.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.1.1/themes/default/style.min.css" rel="stylesheet">
<script>
	$(document).ready(function() {
    $('.datetimeST').datetimepicker({
        pickDate: true,
        pickTime: false,
        format: 'MM/DD/YYYY',
        maxDate: '<?=date('m-d-Y', strtotime('today'))?>'
    });
	 $('#myTable').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     false,
		"filter" : false,
		"responsive": true ,
		"aLengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
		"pagingType": "simple_numbers",
		"aoColumnDefs": [{
      	"bSortable": false, 
      	"aTargets": [6,7,8,9,10,11,12]
    }]
    } );
	
	});
	
  
		function confirmDialog(transactionId , transaction_type) {
		
		var result = confirm("Are you sure you want to delete this record?");
		if (result == true) {
		if(transaction_type != 0)
		window.location = "<?=base_url()?>edit_transaction/reverse_transaction/"+ transactionId;
		else
		window.location = "<?=base_url()?>edit_transaction/reverse_in_transaction/"+ transactionId;
		}
		else
		return false;	
		}
	
</script>
