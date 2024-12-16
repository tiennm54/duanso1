<?php if ($model->payment_status == "completed" || $model->payment_status == "paid") { ?>
    <h3>
        <strong>Your order has been paid successfully.</strong>
    </h3>
    <p>
        <strong style="color: red">Notice*</strong>: If you are not satisfied with the service or product, please contact us via email: <strong>support@buypremiumkey.com</strong>, We will try to solve the problem for you or we can refund you if the fault is on our side. 
        <strong style="color: red">Please do not open the dispute</strong> because if you open a dispute we will be forced to cancel your premium key and lock your account on all our systems. I apologize for this inconvenience.
    </p>
    <p>
        Thank you for using our service!
    </p>
    <?php
} else {?>
    <p style="color: red; font-weight: bold">How do you pay for this Invoice?</p>
    <p>
        We have sent an Invoice to your email. Please check your email and click the <span style="font-weight: bold;">"Check out with paypal"</span> button in your invoice to make payment. After you have successfully paid, please send us your transaction ID. We will send you the premium key as soon as possible. Thank you very much!
    </p>
    <p style="color: red">Notice*: The product name in your invoice has been changed for security purposes.</p>

<?php } ?>