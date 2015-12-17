<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 27.03.15
 * Time: 17:22
 */ ?>
<h2>Subscription</h2>

<p><?php if($payment_expiry == '1') { ?>

    Unsubscribe button for FREE Trial for 90 Days Then $99.99 Per Year: <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=D87CWBXMHPNCQ">
    <IMG SRC="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_SM.gif" BORDER="0">
</A>

<?php }elseif(@$payment_expiry == 0) { ?>
    $99.99 annual recurring subscription for MyRxPal.com online logbook access
    <!--<a href="<?=base_url()?>user/paypal/year" class="btn btn-primary">Pay</a>-->
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="EQU53BPD27ACA">
        <input type="hidden" name="custom" value="<?=$cid?>">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
<?php } ?>
</p>
<p>
    <?php if($payment_expiry == '2') { ?>
        FREE Trial for 90 Days Then $9.99 a month: <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=D87CWBXMHPNCQ">
            <IMG SRC="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_SM.gif" BORDER="0">
        </A>
<?php }elseif(@$payment_expiry == 0) { ?>
    $9.99 monthly recurring subscription for MyRxPal.com online logbook access
    <!--<a href="<?=base_url()?>user/paypal/month" class="btn btn-primary">Pay</a>-->

    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="LEAN9DBUBX5FJ">
        <input type="hidden" name="custom" value="<?=$cid?>">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>


<?php } ?>
</p>

<a href="<?=base_url()?>main/pricing" class="btn btn-info">Pricing</a>
<!--
<?if ($date-time() > 0){?>
<p>Payment expiry date is <?=date("m-d-Y", $date)?></p>
<?}?>
-->
<a href="<?=base_url()?>user/my_transactions" class="btn btn-info">My transactions</a>



