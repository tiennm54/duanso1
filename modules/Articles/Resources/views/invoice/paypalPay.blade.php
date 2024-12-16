<script src="https://code.jquery.com/jquery-1.11.0.min.js" integrity="sha256-spTpc4lvj4dOkKjrGokIrHkJgNA0xMS98Pw9N7ir9oI=" crossorigin="anonymous"></script>
<?php

$url = "";
if ($model != null) {
    if ($model->paypalAccount->status_website == 1 && $model->paypalAccount->website != "") {
        
        if(($model->paypalAccount->money_activate + $model->paypalAccount->money_hold + 0) >= ($model->paypalAccount->max_receive + 0)){
            echo "This payment gateway is temporarily closed. Please come back in 8 hours. I apologize for this inconvenience."
            . " If you have crypto in your wallet then please buy your products at this website: https://takepremium.com."
            . " Thank you for using our service!";
            exit;
        }else if ($model->payment_status == "completed" || $model->payment_status == "paid") {
            echo "Your order has been paid successfully. Thank you for using our service!";
            exit;
        } else {
            //Mac dinh lay trong bang payment type
            $website_paid = $model->payment_type->website;
            //X? l? tr�?ng h?p kh�ch h�ng �?t h�ng ? account c? nh�ng khi �� h? th?ng �? chuy?n sang account m?i
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
    <a href="<?php echo $url ?>" id="paypal">Redirect to Paypal...</a>
    <script>
        $(document).ready(function () {
            document.getElementById('paypal').click();
        });
    </script>
    <?php
}?>