<?php if ($model->payment_status == "completed" || $model->payment_status == "paid") { ?>
    <h3>
        <strong>Your order has been paid successfully.</strong>
    </h3>
    <p>
        <strong style="color: red">Note *</strong>: If you are not satisfied with the service or product, please contact us via email: <strong>support@buypremiumkey.com</strong>, We will try to solve the problem for you or we can refund you if the fault is on our side. 
        <strong style="color: red">Please do not open the dispute</strong> because if you open a dispute we will be forced to cancel your premium key and lock your account on all our systems. I apologize for this inconvenience.
    </p>
    <p>
        Thank you for using our service!
    </p>
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
    <p> 2. Your product will be delivery <strong style="color: red">within 1-8 hours</strong>. Usually you will get it within 30 minutes -> 1 hours.</p>
    <p> 3. If you do not receive product in maximum 8 hours => Please contact us first, <b style="color: red">do not open the disputed!</b></p>
    <p> 4. If you cannot find the product in your inbox, please check your spam mailbox. Thank you!</p>
    <?php
        if ($model->paypalAccount->status_website == 1 && $model->paypalAccount->website != "") {
    ?>
            <a href="{{ $url_checkout }}" target="_blank">
                <img alt="Buy premium key com" src="{{url('theme_frontend/image/checkout-paypal.png')}}" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
            </a>
    <?php
        }else{
    ?>
        <p style="color: red; font-weight: bold">How do I pay for this order?</p>
        <p style="font-weight: bold">We have sent invoice to your email. Please check your email and click "Check out with paypal" button in your invoice to make payment. After successful payment please send your Transaction ID to us. We will send you the premium key as soon as possible. Thank you very much!</p>
    
    <?php 
        }
    ?>

<?php } ?>



