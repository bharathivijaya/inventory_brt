<h2>Customers with <?=$type?> subscription</h2>

<table class="table table-striped">
    <thead>
    <tr>
        <td>Business Name</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Email</td>
        <td>Username</td>
        <?if (($type == 'Monthly') || ($type == 'Annual')) {?>
        <td>Payment Date</td>
        <td>Payment Expiry</td>
        <?}?>
    </tr>
    </thead>
    <tbody>
    <?foreach ($users as $one) {?>
        <tr>
            <td><?=$one['cname']?></td>
            <td><?=$one['first_name']?></td>
            <td><?=$one['last_name']?></td>
            <td><?=$one['email']?></td>
            <td><?=$one['username']?></td>
            <?if (($type == 'Monthly') || ($type == 'Annual')) {?>
            <td><?=date('m-d-Y', $one['p_date'])?></td>
            <td><?=date('m-d-Y', $one['payment_expiry'])?></td>
            <?}?>
        </tr>
    <?}?>
    </tbody>
</table>