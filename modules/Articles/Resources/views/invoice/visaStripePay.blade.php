<script src="https://code.jquery.com/jquery-1.11.0.min.js" integrity="sha256-spTpc4lvj4dOkKjrGokIrHkJgNA0xMS98Pw9N7ir9oI=" crossorigin="anonymous"></script>
<?php
$url = "";
if ($model != null) {
    if ($model->payment_status == "completed" || $model->payment_status == "paid") {
        echo "Your order has been paid successfully. Thank you for using our service!";
        exit;
    } 
    if($model->stripeAccount->total_money >= $model->stripeAccount->max_receive){
        echo "This payment gateway is temporarily closed. Please come back in 24 hours. I apologize for this inconvenience!";
        exit;
    }
    else {

        $url_stripe_pay = "";
        if ($model->stripeAccount->status_activate == 1) {
            $url_stripe_pay = $model->stripeAccount->url_web;
        }

        if ($url_stripe_pay != "") {
            $url = $url_stripe_pay . "?wc-ajax=stripe_redirect&email=" . $model->email . "&hash=" . $model->paypal_token; // TRUONG NAY DUNG CHUNG CHO CA VISA VA PAYPAL
        } else {
            echo "Your order has expried, please try again!!";
            exit;
        }
    }
} else {
    echo "Your order has expried, please try again!!";
    exit;
}
?>
<?php if ($url != "") { ?>
    <a href="<?php echo $url ?>" id="visa-stripe">Redirect to visa payment gateway...</a>
    <script>
        $(document).ready(function () {
            document.getElementById('visa-stripe').click();
        });
    </script>
    <?php
}?>