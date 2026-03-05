<!DOCTYPE html>
<html>
    <head>
        <title>INVOICE #<?php echo $model_orders->order_no; ?></title>
        <link href="{{url('theme_frontend/css/bootstrap.css')}}" rel="stylesheet" media="screen">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="{{url('theme_frontend/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
    </head>
    <body>
        <div class="product">
            <div class="container">
                @include('validator.flash-message')
                <div class="row">
                    <div id="content" class="col-sm-12">
                        <div class="page-title">
                            <h1>INVOICE #<?php echo $model_orders->order_no; ?></h1>
                        </div>
                        
                        <?php
                            $price_order = $model_product->price_order;
                            $chargers_order = $model_payment->getPaymentCharges($model_product->price_order);
                            
                            //chia hai % giá phí để đánh lừa khách hàng
                            $chargers_fake =  round($chargers_order / 2, 2);
                            $price_view = $price_order + $chargers_fake;
                            $chargers_view = $chargers_order - $chargers_fake;
                            
                        ?>
                        
                        <div class="tab-content">
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left"><b>Product</b></td>
                                                <td class="text-right"><b>Product Name</b></td>
                                                <td class="text-right"><b>Unit Price</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">
                                                    <img src="{{ $model_product->getArticles->getImage() }}" style="width: 200px"/>
                                                </td>
                                                <td class="text-right"><?php echo $model_product->title; ?></td>
                                                <td class="text-right">$<?php echo $price_view; ?></td>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td class="text-left"><b>Payment Method:</b> <?php echo $model_payment->title; ?></td>
                                                <td class="text-right"><b>Chargers </b></td>
                                                <td class="text-right">$<?php echo $chargers_view; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left"><b>Instant delivery to</b>: <?php echo $model_user->email; ?></td>
                                                <td class="text-right"><b>Total</b></td>
                                                <td class="text-right">$<?php echo $model_payment->getPaymentTotal($model_product->price_order); ?></td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <!--Nếu tìm được acc paypal là invoice hoặc none thì yêu cầu khách hàng thanh toán qua email-->
                                                    <?php
                                                    if(isset($response["status"]) && $response["status"] == "success"){//NẾU KHÔNG LỖI
                                                        if((isset($response["payment_type"]) && $response["payment_type"] == "invoice") || (isset($response["payment_type"]) && $response["payment_type"] == "none")){//REDIRECT SANG PAGE ĐỢI KEY
                                                    ?>
                                                        <p>
                                                            We have sent a PayPal Invoice to your email. Please check your inbox or spam folder for the invoice. After that, kindly click on the "Check out with paypal" button in the invoice to complete the payment.
                                                            <b>After your payment is successful, we will send the premium key/voucher to your email.</b>
                                                        </p>
                                                        
                                                        <p>
                                                            <strong>You will be redirect to "TRACK YOUR INVOICE" page in </strong> 
                                                            <strong id="countdown2">5</strong><strong>s</strong>
                                                        </p>
                                                        
                                                    <?php 
                                                        }else{//ĐÂY LÀ REDIRECT SANG PAGE THANH TOÁN PAYPAL QUA SITE FAKE
                                                    ?>
                                                            <strong>You will be redirect to <?php echo $model_payment->title; ?> in </strong> 
                                                            <strong id="countdown">5</strong><strong>s</strong>
                                                    <?php 
                                                    
                                                        }
                                                    }else{//NẾU LỖI THÌ YÊU CẦU CHUYỂN SANG PHƯƠNG THỨC THANH TOÁN VISA
                                                    ?>
                                                        <p>
                                                            The current payment method is unavailable. Would you like to use another payment method to complete the payment?
                                                        </p>
                                                        <button class="btn btn-primary text-right" type="button" onclick="changePaymentMethodCheckout()">Yes</button>
                                                    <?php }?>
                                                    <button class="btn btn-danger" type="button" onclick="cancelCheckout()">Cancel</button>
                                                    <input id="statusCheckout" value="<?php echo (isset($response["status"])) ? $response["status"] : ""; ?>" hidden="">
                                                    <input id="paymentType" value="<?php echo (isset($response["payment_type"])) ? $response["payment_type"] : ""; ?>" hidden="">
                                                    
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        
        $(document).ready(function () {
            
            var statusCheckout = $("#statusCheckout").val();
            var paymentType = $("#paymentType").val();
            if(statusCheckout == "success"){
                if(paymentType != "invoice" && paymentType != "none"){
                    countDownCheckout();
                }else{
                    countDownGetProduct();
                }
            }
            
            
        });
        
        function countDownCheckout(){// PAID
            var seconds = document.getElementById("countdown").textContent;
            var countdown = setInterval(function () {
                seconds--;
                document.getElementById("countdown").textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(countdown);
                    if (seconds == 0) {
                        window.location.href = '<?php echo (isset($response["payment_url"])) ? $response["payment_url"] : ""; ?>';
                    }
                }
            }, 1000);
        }
        
        
        function countDownGetProduct(){//TRACK ORDER
            var seconds = document.getElementById("countdown2").textContent;
            var countdown = setInterval(function () {
                seconds--;
                document.getElementById("countdown2").textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(countdown);
                    if (seconds == 0) {
                        var url = '<?php echo URL::route('frontend.trackOrder.getProduct', ["id" => $model_orders->id]); ?>';
                        window.location.href = url;
                    }
                }
            }, 1000);
        }
        
        function cancelCheckout(){
            window.location.href = '<?php echo $model_product->getUrlBuyNow()?>';
        }
        
        function changePaymentMethodCheckout(){
            var url = '<?php echo URL::route('frontend.fcheckout.view', ["payment_type" => "visa" , "product_id" => $model_product->id, "customer_email" => $model_user->email ])?>';
            window.location.href = url;
        }
        
    </script>
</html>

