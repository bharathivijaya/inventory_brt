
<h2><?=$labels[$type]?> Report</h2>
<?/*print($ndc_num); print_r($fields);*/?>
<div id="report">
<table class="table" style="width: 1000px" autosize="4" id="myTable">
    <thead style="font-weight: bold">
    <tr>
        <?foreach ($fields as $f) {?>
            <td><?=$labels[$f]?></td>
        <?}?>
    </tr>
    </thead>
    <tbody>
    <?foreach ($entries as $one) {?>
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
        </tr>
    <?}?>
    </tbody>

</table>

</div>


<script>
    $(document).ready(function() {
        <?if (($type == 'in') ||($type == 'out')) {?>
            var total = 0;
            $('.units').each(function (i, elem){
                console.log($(this).text());
                total = total + parseInt($(this).html());
            });
        <?}?>
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


    });

    jQuery("#myForm").submit(function(e) {
        var self = this;
        e.preventDefault();

        var html = $('#report').html();
        $('#inp').val(html);
        self.submit();

    });

</script>