@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="#">Checkout</a></li>
        </ul>
        @include('validator.flash-message')
        <h2>Checkout Premium Key</h2>
        <?php if (Auth::guest()): ?>
            <p>
                <span>Fill in the Fields below to complete your purchase!</span>
                <span>Already registered ? <a class="" href="{{ URL::route('users.getLogin') }}"> Login here</a></span>
            </p>

        <?php endif; ?>

        <form method="post" action="<?php echo URL::route('frontend.checkout.confirmOrder'); ?>" id="form-checkout-id">

            <input type=hidden name=member value="buypremiumkey">
            <input type=hidden name=id value="1207">
            <input id="visa-total-price" type=hidden name=price value="{{ $totalOrder['total'] }}">
            <input id="visa-order-id" type=hidden name=order_id value="0">
            <input id="visa-order-no" type="hidden" name="product" value="">
            <input type=hidden name=tax value="0">
            <input type=hidden name=ureturn value="http://buypremiumkey.com/checkout-visa/success">
            <input type=hidden name=unotify value="http://buypremiumkey.com/checkout-visa/callback">
            <input type=hidden name=ucancel value="http://buypremiumkey.com/checkout-visa/failure">

            @include('articles::checkout.includes.billing_information')
            @include('articles::checkout.includes.payment_method')
            @include('articles::checkout.includes.review_order')

        </form>
    </div>
</div>

<script>
    var type = "PAYPAL";
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

    function saveOrder() {
        var check = eventLoading();
        if (check == 0) {
            return 0;
        }
        if (type == "VISA") {
            var token = $("#_token").val();
            var email = $("#user_orders_email").val();
            var firstName = $("#first_name").val();
            var lastName = $("#last_name").val();
            var checkUseBonus = $("#cb-my-bonus").is(':checked');
            var userBonus = 0;
            if(checkUseBonus == true){
                userBonus = 1;
            }

            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.checkout.createOrderVisa') ?>",
                data: {
                    "_token": token,
                    "email": email,
                    "first_name": firstName,
                    "last_name": lastName,
                    "use_my_bonus": userBonus
                },
                success: function (data) {
                    console.log(data);
                    if (data["status"] == 1) {
                        $("#visa-total-price").val(data["total_price"]);
                        $("#visa-order-id").val(data["order_id"]);
                        $("#visa-order-no").val(data["order_no"]);
                        $("#form-checkout-id").submit();
                    } else {
                        alert("<?php echo VISA_ERROR_PRICE; ?>");
                        location.reload();
                    }
                },
                error: function (ex) {
                    alert("<?php echo VISA_ERROR_CHECKOUT; ?>");
                    location.reload();
                }
            });
        } else {
            $("#form-checkout-id").submit();
        }
    }

    function selectTypePayment(item) {
        var token = $("#_token").val();
        var check_bonus = $("#cb-my-bonus").is(':checked');
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.checkout.selectTypePayment') ?>",
            data: {"payment_id": item.id, "check_bonus": check_bonus, "_token": token},
            success: function (data) {
                type = data["payment_code"];
                updateTotalOrder(data);
            },
            error: function (ex) {
                console.log(ex.responseJSON);
                location.reload();
            }
        });
    }

    function updateTotalOrder(data) {
        $("#sub-total-order").html("$" + data["sub_total"]);
        $("#sub-total").html(data["sub_total"]);
        $("#payment_charges").html(data["charges"]);
        $("#total").html(data["total"]);
        $("#text_payment_selected").text(data["payment_name"]);
        $("#sub-total-popup").html(data["total"]);

        $("#visa-total-price").val(data["total"]);
        if (data["payment_code"] == "VISA") {
            document.getElementById('form-checkout-id').action = 'https://qwikpay.org/process.htm';
        } else {
            document.getElementById('form-checkout-id').action = '<?php echo URL::route('frontend.checkout.confirmOrder'); ?>';
        }

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
        if (number <= 0) {
            number = 1;
            $("#quantityProduct" + id).val(1);
        }
        var token = $("#_token").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.checkout.changeQuantity') ?>",
            data: {"id": id, "number": number, "payment_type": payment_type, "check_bonus": check_bonus, "_token": token},
            success: function (data) {
                updateTotalOrder(data);
            },
            error: function (ex) {
                console.log(ex.responseJSON);
                location.reload();
            }
        });
    }

    function deleteProductCheckout(id) {
        if (confirm("Are you sure you want to delete this item?")) {
            var token = $("#_token").val();
            var payment_type = $('input[type="radio"][class="payment-type"]:checked').val();
            var check_bonus = $("#cb-my-bonus").is(':checked');
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.checkout.deleteProductCheckout') ?>",
                data: {"id": id, "payment_type": payment_type, "check_bonus": check_bonus, "_token": token},
                success: function (data) {
                    $("#list-product-checkout").html(data);
                },
                error: function (ex) {
                    alert(ex.responseJSON);
                    location.reload();
                }
            });
        }
    }

    function chooseBonusMoney() {
        var token = $("#_token").val();
        var payment_id = $('input[type="radio"][class="payment-type"]:checked').val();
        var check_bonus = $("#cb-my-bonus").is(':checked');
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.checkout.chooseBonusMoney') ?>",
            data: {"payment_id": payment_id, "check_bonus": check_bonus, "_token": token},
            success: function (data) {
                updateTotalOrder(data)
            },
            error: function (ex) {
                alert(ex.responseJSON);
                //location.reload();
            }
        });
    }

</script>


@stop

<style>
    .input-require{
        color: red;
    }
</style>