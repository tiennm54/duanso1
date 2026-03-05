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
    <p style="color: red; font-weight: bold">You have not paid for this Invoice.</p>

<?php } ?>