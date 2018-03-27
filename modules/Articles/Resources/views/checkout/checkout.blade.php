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

        <form method="post" action="{{ URL::route('frontend.checkout.confirmOrder') }}">
            @include('articles::checkout.includes.billing_information')
            @include('articles::checkout.includes.payment_method')
            @include('articles::checkout.includes.review_order')
        </form>

    </div>
</div>



<script>

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $('#confirm_order').on('click', function () {
        var check = false;
        var $this = $(this);
        $this.button('loading');
        var termsConditions = $("#cb-terms").is(':checked');
        var checkEmail = validateEmail($("#user_orders_email").val());
        $('[required]').each(function () {
            if ($.trim($(this).val()) == '' || termsConditions == false || checkEmail == false) {
                check = true;
            }
        });
        if (check == true) {
            setTimeout(function () {
                $this.button('reset');
            }, 1000);
        }
    });

    function selectTypePayment(item) {
        var token = $("#_token").val();
        var check_bonus = $("#cb-my-bonus").is(':checked');
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.checkout.selectTypePayment') ?>",
            data: {"payment_id": item.id, "check_bonus": check_bonus, "_token": token},
            success: function (data) {
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
        
        if(data["payment_code"] == "BONUS"){
            $("#tr-use-bonus").hide();
            $('#cb-my-bonus').prop('checked', false);
        }else{
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