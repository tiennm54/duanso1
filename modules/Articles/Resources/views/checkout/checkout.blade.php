@extends('frontend.master')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>

<div class="product">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a>Checkout</a></li>
        </ul>
        @include('frontend.banner')
        @include('validator.flash-message')
        <?php if (Auth::guest()): ?>
            <p>
                <span style="font-weight: bold">Already registered ? <a class="" href="{{ URL::route('users.getLogin') }}"> Login here</a></span>
            </p>
        <?php endif; ?>
        <div class="row">
            
            <div class="flash-message col-md-12" id="flash_message_visa" hidden>
                    <p class="alert alert-success">
                    <?php echo NOTI_NOTE_VISA; ?>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            </div>
            
            
            <form method="post" action="<?php echo URL::route('frontend.checkout.confirmOrder'); ?>" id="form-checkout-id">
                
                
                <input type = "hidden" name = "seller_id" value="<?php echo VISA_SELLER_ID; ?>" />
                <input id="visa-order-id" type = "hidden" name = "seller_ref_code" value="" /> 
                <input id="visa-total-price" type = "hidden" name = "total_price" value="" /> 
                <input id="visa-order-no" type = "hidden" name = "product" value="" />
                <input id="visa-order-token" type = "hidden" name = "token" value="" />
                <input id="visa-order-customerEmail" type = "hidden" name = "customer_email" value="" />
                <input id="visa-order-customerName" type = "hidden" name = "customer_name" value="" />
                <input type = "hidden" name = "currency" value="USD" />
                <input type = "hidden" name = "seller_ipn" value="<?php echo URL::route('frontend.checkoutVisa.callback'); ?>" /> 
                <input type = "hidden" name = "seller_success_url" value="<?php echo URL::route('frontend.checkoutVisa.success'); ?>" />
                <input type = "hidden" name = "seller_failed_url" value="<?php echo URL::route('frontend.checkoutVisa.failure'); ?>" />
                <input type = "hidden" name = "pmethod" value="" /> 

                @include('articles::checkout.includes.billing_information')
                @include('articles::checkout.includes.payment_method')
                @include('articles::checkout.includes.review_order')

            </form>
        </div>
    </div>
</div>

<script>
    var total_money = <?php echo $totalOrder['total']; ?>
    
    var type = "PAYPAL";
    var user_country = "";
    var check_proxy = "";
    
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function eventLoading() {
        var return_check = 0;
        var check = false;
        var $this = $('#confirm_order');
        $this.button('loading');
        var termsConditions = $("#cb-terms").is(':checked');
        var checkEmail = validateEmail($("#user_orders_email").val());
        $('[required]').each(function () {
            if ($.trim($(this).val()) == '') {
                check = true;
                return_check = 1;
            }

            if (checkEmail == false) {
                check = true;
                return_check = 2;
            }

            if (termsConditions == false) {
                check = true;
                return_check = 3;
            }
        });

        if (check == true) {
            setTimeout(function () {
                $this.button('reset');
            }, 1000);
        }

        switch (return_check) {
            case 1:
                alert("Please fill in all required fields");
                return 0;
            case 2:
                alert("Your email address is invalid. Please enter a valid address.");
                return 0;
            case 3:
                alert("Please agree to our terms");
                return 0;
        }
        return 1;
    }
    
    //Ham da duoc sua de su dung cho platform
    function saveOrder() {
        var check = eventLoading();
        if (check == 0) {
            return 0;
        }
        let check_platform_method = type.indexOf("PREMIUM_");
        if (check_platform_method >= 0) { // Day la phuong thuc thanh toan thong qua platform
            var token = $("#_token").val();
            var email = $("#user_orders_email").val();
            var firstName = $("#first_name").val();
            var lastName = $("#last_name").val();
            var checkUseBonus = $("#cb-my-bonus").is(':checked');
            var userBonus = 0;
            if (checkUseBonus == true) {
                userBonus = 1;
            }

            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.platform.platformCreateOrder') ?>",
                data: {
                    "_token": token,
                    "email": email,
                    "first_name": firstName,
                    "last_name": lastName,
                    "use_my_bonus": userBonus,
                    "payment_type_code" : type,//code cua phuong thuc thanh toan
                },
                success: function (data) {
                    console.log(data);
                    if (data["status"] == "success") {
                        if(data["payment_type"] == "site_fake"){
                            if(data["payment_url"] != ""){
                                window.location.replace(data["payment_url"]);
                            }
                        }else{
                            // Hệ thống tự đọng gửi hóa đơn qua email rồi, đoạn này chỉ cần redirect sang hóa đơn của khách
                           window.location.replace(data["url_invoice"]);
                        }
                    } else {
                        location.reload();
                    }
                },
                error: function (ex) {
                    alert("<?php echo VISA_ERROR_CHECKOUT; ?>");
                    location.reload();
                }
            });
        } else { // Phuong thuc thanh toan thong thuong
            $("#form-checkout-id").submit();
        }
    }

    function selectTypePayment(id) {
        var token = $("#_token").val();
        var check_bonus = $("#cb-my-bonus").is(':checked');
        var spinHandle = loadingOverlay().activate();
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.checkout.selectTypePayment') ?>",
            data: {"payment_id": id, "check_bonus": check_bonus, "_token": token},
            success: function (data) {
                type = data["payment_code"];
                updateTotalOrder(data);
                loadingOverlay().cancel(spinHandle);
            },
            error: function (ex) {
                console.log(ex.responseJSON);
                location.reload();
                loadingOverlay().cancel(spinHandle);
            }
        });
    }
    
    function updateTotalOrder(data) {
        total_money = data["total"];
        $("#sub-total-order").html("$" + data["sub_total"]);
        $("#sub-total").html(data["sub_total"]);
        $("#payment_charges").html(data["charges"]);
        $("#total").html(data["total"]);
        $("#text_payment_selected").text(data["payment_name"]);
        $("#sub-total-popup").html(data["total"]);

        if (data["payment_code"] == "BONUS") {
            $("#tr-use-bonus").hide();
            $('#cb-my-bonus').prop('checked', false);
        } else {
            $("#tr-use-bonus").show();
        }
    }

    function changeQuantity(id) {
        var check_bonus = $("#cb-my-bonus").is(':checked');
        var number = $("#quantityProduct" + id).val();
        var payment_type = $('input[type="radio"][class="payment-type"]:checked').val();

        if(payment_type == "" || typeof payment_type == "undefined"){
            alert("Please select a payment method. Thank you!") ? "" : location.reload();
            return 0;
        }
        if (number <= 0) {
            number = 1;
            $("#quantityProduct" + id).val(1);
        }
        var token = $("#_token").val();
        var spinHandle = loadingOverlay().activate();
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.checkout.changeQuantity') ?>",
            data: {"id": id, "number": number, "payment_type": payment_type, "check_bonus": check_bonus, "_token": token},
            success: function (data) {
                updateTotalOrder(data);
                //kiem tra hien thi button visa
                checkDisablePaymentMethod(user_country, check_proxy);
                loadingOverlay().cancel(spinHandle);
            },
            error: function (ex) {
                console.log("error change quantity");
                location.reload();
                loadingOverlay().cancel(spinHandle);
            }
        });
    }

    function deleteProductCheckout(id) {
        if (confirm("Are you sure you want to delete this item?")) {
            var token = $("#_token").val();
            var payment_type = $('input[type="radio"][class="payment-type"]:checked').val();
            var check_bonus = $("#cb-my-bonus").is(':checked');
            var spinHandle = loadingOverlay().activate();
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.checkout.deleteProductCheckout') ?>",
                data: {"id": id, "payment_type": payment_type, "check_bonus": check_bonus, "_token": token},
                success: function (data) {
                    $("#list-product-checkout").html(data);
                    loadingOverlay().cancel(spinHandle);
                },
                error: function (ex) {
                    location.reload();
                    loadingOverlay().cancel(spinHandle);
                }
            });
        }
    }

    function chooseBonusMoney() {
        var token = $("#_token").val();
        var payment_id = $('input[type="radio"][class="payment-type"]:checked').val();
        var check_bonus = $("#cb-my-bonus").is(':checked');
        var spinHandle = loadingOverlay().activate();
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.checkout.chooseBonusMoney') ?>",
            data: {"payment_id": payment_id, "check_bonus": check_bonus, "_token": token},
            success: function (data) {
                updateTotalOrder(data)
                loadingOverlay().cancel(spinHandle);
            },
            error: function (ex) {
                loadingOverlay().cancel(spinHandle);
            }
        });
    }
    
    //Hàm kiểm tra ẩn hiện của phương thức thanh toán đối với người dùng
    function checkDisablePaymentMethod(check_user_country, check_paypal_proxy){
        
        
        var user_orders_email = $("#user_orders_email").val(); 
        var user_orders_email_conf = $("#user_orders_email_conf").val();
        
        //console.log("USER CONTRY AND CHECK PROXY");
        //console.log(user_country);
        //console.log(check_paypal_proxy);
        
        user_country = check_user_country;
        check_proxy = check_paypal_proxy;
        
        if(user_orders_email == user_orders_email_conf){
            var token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.checkout.checkDisablePaymentMethod') ?>",
                data: {
                    "user_orders_email": user_orders_email, 
                    "user_country" : user_country, 
                    "check_paypal_proxy" : check_proxy, 
                    "_token": token
                },
                success: function (data_hidden) {
                    
                    //console.log(data.length);
                    if(data_hidden.length != 0){
                        data_hidden.forEach(function(item, index) {
                            var payment_type_id = item["payment_type_id"];
                            var status_show = item["status_show"];
                            var isIdPaymentType = document.getElementById('payments_type_' + payment_type_id);
                            if(isIdPaymentType !== null){
                                var isHidden = $('#payments_type_'+ payment_type_id).is(':hidden');// true là đang ẩn, false là đang hiển thị
                                if(status_show == 0 && isHidden == false){ // ẩn phương thức thanh toán này đi
                                    document.getElementById('payments_type_' + payment_type_id).style.display = 'none';
                                    //document.getElementById('flash_message_visa').style.display = 'none';
                                    $("input[id="+'payments_type_id_' + payment_type_id+"]:radio").prop( "checked", false );

                                }else if(status_show == 1 && isHidden == true){// mở phương thức thanh toán này lên
                                    document.getElementById('payments_type_' + payment_type_id).style.display = 'block';
                                    //document.getElementById('flash_message_visa').style.display = 'block';
                                }
                            }
                        });
                    }else{// trường hợp này xảy ra khi khách hàng đã mở tranh chấp
                        window.location.replace('<?php echo URL::route('frontend.checkout.error'); ?>');
                    }
                   
                },
                error: function (ex) {
                    console.log(ex.responseJSON);
                }
            });
        }
    }

    $( document ).ready(function() {
        console.log( "ready!" );
        checkDisablePaymentMethod(user_country, check_proxy);
        
        var $radios = $('input:radio[name=payments_type_id]');
        if($radios.is(':checked') === false) {
            var isClassPaymentType = document.getElementsByClassName('payment-type');//Kiểm tra xem có tồn tại class payment-type không?
            if (isClassPaymentType !== null){
                $('input:radio[name=payments_type_id]')[0].checked = true;
                var payment_type = $('input[type="radio"][class="payment-type"]:checked').val();
                if(payment_type != "" && typeof payment_type != "undefined") {
                    selectTypePayment(payment_type);
                }
            }
        }
    });
</script>


@stop

<style>
    .input-require{
        color: red;
    }
</style>