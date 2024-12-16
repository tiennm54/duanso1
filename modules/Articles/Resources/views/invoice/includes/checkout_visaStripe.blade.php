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
    $url_checkout = URL::route("frontend.invoice.visaStripePay", ["token" => $model->paypal_token]);
    ?>

    <p style="color: red; font-weight: bold">Notice: please read carefully before you make the payment</p>
    <p> 1. Your product will be delivery <strong style="color: red">within 1-8 hours</strong>. Usually you will get it within 30 minutes -> 1 hours.</p>
    <p> 2. If you do not receive product in maximum 8 hours => Please contact us first, <b style="color: red">do not open the disputed!</b></p>
    <p> 3j. If you cannot find the product in your inbox, please check your spam mailbox. Thank you!</p>
    <a href="{{ $url_checkout }}" target="_blank" style="display: block">
        <button class="btn btn-primary" style="font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;"> Click here to pay now </button>
        <img alt="Buy premium key com" src="{{url('theme_frontend/image/checkout-with-visa.png')}}" style="height: 40px" border="0">
    </a>

<?php } ?>