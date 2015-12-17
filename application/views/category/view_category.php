<h2>Category <?=$cat['c_name']?></h2>
<h3>Drug List</h3>
<table class="table table-striped" id="myTable">
    <thead>
    <tr>
        <td>Name</td>
        <td>NDC Code</td>
        <td>Description</td>
        <td>Package Size</td>
        <td>Manufacturer</td>
        <td>Starting Inventory in Units</td>
        <td>Schedule</td>
        <td>Barcode</td>
        <td>Status</td>
        <td>Date Created</td>
        <td>Last Modified</td>
        <td>Quantity on Hand</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($drugs as $one) {?>
        <tr>
            <td><a href="<?=base_url()?>drug/view_drug/<?=$one['d_id']?>"><?=$one['d_name']?></a></td>
            <td><?=$one['d_code']?></td>
            <td><?=$one['d_descr']?></td>
            <td><?=$one['d_size']?></td>
            <td><?=$one['d_manufacturer']?></td>
            <td><?=$one['d_start']?></td>
            <td><?=$one['d_schedule']?></td>
            <td><?=$one['d_barcode']?></td>
            <td><?if ($one['d_status'] == 1){echo 'Active';} else{echo 'Inactive';}?></td>
            <td><?=date('m-d-Y', $one['d_created'])?></td>
            <td><?=date('m-d-Y', $one['d_modified'])?></td>
            <td><?=$one['d_onHand']?></td>
            <td><a href="<?=base_url()?>drug/add_drug/<?=$one['d_id']?>">Edit</a></td>
        </tr>
    <?}?>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#myTable').DataTable({"aoColumnDefs": [
            { "sWidth": "100px", "aTargets": [1]},
            { "sWidth": "85px", "aTargets": [3]},
            { "sWidth": "85px", "aTargets": [5]},
            { "sWidth": "85px", "aTargets": [11]}
        ]});
        //$('#myTable_filter').find('input').addClass('form-control');
       // $('#myTable_filter').after('<div id="after_filter"><a href="<?=base_url()?>drug/add_drug" class="btn btn-warning" style="line-height: 0.9">New drug</a></div>');
    });
</script>