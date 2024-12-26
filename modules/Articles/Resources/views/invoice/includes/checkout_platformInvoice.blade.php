<?php if ($model->payment_status == "completed" || $model->payment_status == "paid") { ?>
    <h3>
        <strong>Your order has been paid successfully.</strong>
    </h3>
    <p>
        <span>1. If you do not receive premium voucher/account by email within 2 hours, Please contact us: <?php echo EMAIL_BUYPREMIUMKEY; ?>. We will check again and re-send premium voucher to you.</span><br>
        <span>2. Please <span style="color: red">DO NOT OPEN DISPUTE</span> in any case. <span style="font-weight: bold">We are always here to assist you.</span></span><br>
        <span>3. If you cannot find the product in your inbox, please check your spam folder.</span><br>
        <span>4. If you have any problems, just contact us: <?php echo EMAIL_BUYPREMIUMKEY; ?></span><br>
    </p>
    <p>
        Thank you for using our service!
    </p>
    <?php } else {
    ?>
    <p style="color: red; font-weight: bold">How do you pay for this Invoice?</p>
    <p>
        <span>  We have sent a PayPal Invoice to your email. Please check your inbox or <span style="color: red">spam folder</span> for the invoice. After that, kindly click on the <span style="font-weight: bold;">"Check out with paypal"</span> button in the invoice to complete the payment.</span><br/>
        <span>  Once your payment is successful, we will send the premium key to your email or you can get your premium key on this page. Please reload this page to get your premium key. Thank you very much!</span>
    </p>
    <p style="color: red">Notice*: The product name in your invoice has been changed for security purposes.</p>

<?php } ?>