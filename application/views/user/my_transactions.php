<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 27.03.15
 * Time: 17:28
 */ ?>
<h2>My Transactions</h2>
<table class="table">
    <thead>
    <tr>
        <td>Amount</td>
        <td>Date</td>
        <td>Subscription Type</td>
    </tr>
    </thead>
    <tbody>
    <?foreach ($payments as $one) {?>
        <tr>
            <td><?='$'.$one['p_amount']?></td>
            <td><?=date("m-d-Y H:i", $one['p_date'])?></td>
            <td><?=$one['p_type']?></td>
        </tr>
    <?}?>
    </tbody>
</table>