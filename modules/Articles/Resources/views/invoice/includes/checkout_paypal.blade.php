<?php if ($model->payment_status == "completed" || $model->payment_status == "paid") { ?>
    <b>Your order has been paid successfully. Thank you for using our service!</b>
    <?php
} else {
    $url_checkout = "";
    if ($model->paypalAccount->status_website == 1 && $model->paypalAccount->website != "") {
        $url_checkout = URL::route("frontend.invoice.paypalPay", ["token" => $model->paypal_token]);
    } else {
        $url_checkout = "https://www.paypal.com/cgi-bin/webscr?business=" . $model->paypalAccount->email . "&cmd=_xclick&currency_code=USD&amount=" . $model->total_price . "&item_name=" . $model->order_no;
    }
    ?>

    <p style="color: red; font-weight: bold">Notice: please read carefully before you make the payment</p>
    <p> 1. Please DO NOT write any things on MESSAGE BOX (We will cancel your payment if you write any things)</p>
    <p> 2. Your keys/vouchers/account will be delivery within 1-8 hours. Usually you will get it within 30 minutes -> 1 hours.</p>
    <p> 3. If you do not receive premium in maximum 8 hours => Please contact us first, <b style="color: red">do not open the disputed!</b></p>
    <p> 4. Your premium key/account will be delivery by email from <b><?php echo EMAIL_BUYPREMIUMKEY ?></b>. Please make sure to check your inbox and Spam(Junk) box to get the key/account.</p>
    <a href="{{ $url_checkout }}" target="_blank">
        <img alt="Buy premium key com" src="{{url('theme_frontend/image/checkout-paypal.png')}}" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
    </a>

<?php } ?>



