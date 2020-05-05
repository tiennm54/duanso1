<script src="https://code.jquery.com/jquery-1.11.0.min.js" integrity="sha256-spTpc4lvj4dOkKjrGokIrHkJgNA0xMS98Pw9N7ir9oI=" crossorigin="anonymous"></script>
<?php

$url = "";
if ($model != null) {
    if ($model->paypalAccount->status_website == 1 && $model->paypalAccount->website != "") {
        if ($model->payment_status == "completed" || $model->payment_status == "paid") {
            echo "Your order has been paid successfully. Thank you for using our service!";
            exit;
        } else {
            //Mac dinh lay trong bang payment type
            $website_paid = $model->payment_type->website;
            //X? l? trý?ng h?p khách hàng ð?t hàng ? account c? nhýng khi ðó h? th?ng ð? chuy?n sang account m?i
            if($model->paypalAccount->status != 'Limit'){
                if ($model->paypalAccount->status_website == 1 && $model->paypalAccount->website != "") {
                    $website_paid = $model->paypalAccount->website;
                }
            }
            
            $url = $website_paid . "/payment.php?hash=" . $model->paypal_token;
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