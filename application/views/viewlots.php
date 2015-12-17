<?php if(isset($lots)) { ?>
<h3> Lot Details</h3>
<div  id="report">
  <table class="table table-striped table-hover dt-responsive display" style="width:100%" cellspacing="0"   id="myTable">
    <thead style="font-weight: bold">
      <tr>
       <td>Expiration date</td>
	   <td>Count</td>
	   <td>LotName</td>
	   <td>Drug Name</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($lots as $lot) {?>
      <tr class="units">
        <td><?php echo date('m-d-Y', $lot['expirationDate']) ?></td>

        <td><?php echo $lot['count']; ?></td>
        <td><?php echo $lot['lotName'];?></td>
               <td><?php echo $lot['d_name'];?></td>

		<!--<td><?php if($entry->e_deleteddate==0 && $entry->e_status!=3) echo "NA"; else echo date('m-d-Y', $entry->e_deleteddate);?></td>-->
		<!--<td><?php if($entry->e_status==1) echo "New";
		if($entry->e_status==2) echo "Edit";
		if($entry->e_status==3) echo "Reversed"; ?></td>-->
       
      </tr>
      <?php }?>
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
	