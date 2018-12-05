<script src="https://code.jquery.com/jquery-1.11.0.min.js" integrity="sha256-spTpc4lvj4dOkKjrGokIrHkJgNA0xMS98Pw9N7ir9oI=" crossorigin="anonymous"></script>
<?php

$url = "";
if ($model != null) {
    if ($model->payment_type->status_website == 1 && $model->payment_type->website != "") {
        if ($model->payment_status == "completed" || $model->payment_status == "paid") {
            echo "Your order has been paid successfully. Thank you for using our service!";
            exit;
        } else {
            $url = $model->payment_type->website . "/payment.php?hash=" . $model->paypal_token;
        }
    } else {
        echo "Your order has expried, please try again!!";
        exit;
    }
} else {
    echo "Your order has expried, please try again!!";
    exit;
}
?>
<?php if ($url != "") { ?>
    <a href="<?php echo $url ?>" id="paypal">Redirect to make a payment</a>
    <script>
        $(document).ready(function () {
            document.getElementById('paypal').click();
        });
    </script>
    <?php
}?>