<h2>Sales Total</h2>

<table class="table table-striped">
    <thead>
    <tr>
        <td>Business Name</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Email</td>
        <td>Username</td>
        <td>Payment Date</td>
        <td>Payment Amount</td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($sales as $one) {?>
        <tr>
            <td><?=$one['cname']?></td>
            <td><?=$one['first_name']?></td>
            <td><?=$one['last_name']?></td>
            <td><?=$one['email']?></td>
            <td><?=$one['username']?></td>
            <td><?=date('m-d-Y', $one['p_date'])?></td>
            <td class="amount"><?=$one['p_amount']?></td>
        </tr>
    <?}?>
    <tr>
        <td colspan="5"></td>
        <td style="border-bottom: 1px lightgray solid">Total</td>
        <td style="border-bottom: 1px lightgray solid"id="total"></td>
    </tr>
    </tbody>

</table>

<script>

    $(document).ready(function() {
        var sum = 0;
        $('.amount').each (function (i) {
            sum+= +$(this).text();
        });
        $('#total').text(sum);
    });
</script>