@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('frontend.checkout.index') }}">Checkout Visa</a></li>
            <li><a href="#">Success</a></li>
        </ul>

        <div class="row">
            <div id="content" class="col-sm-12"><h1>Your order has been paid!</h1>
                <p>
                    <span>We have received your payment.</span>
                    <span>Our working time is: Mon - Sun / 8:00AM - 10:00PM GTM + 7</span><br>
                    <span>If you pay within this period, you will receive premium key/voucher within 1 hours.</span><br>
                    <span>In contrast, you will be received your premium key/voucher within 6->8 hours. We're sorry for the delay in delivery.</span><br>
                </p>
                <p>
                    <span>If you wait too long. Please send your proof of payment to us via email <?php echo EMAIL_BUYPREMIUMKEY ?>.</span><br>
                    <span>Subject is: Proof of payment #your order. Example:  Proof of payment #BPK-20180608123</span><br>
                    <span>This will help us send premium keys to you sooner</span>
                </p>

                <p>
                    You can view your order history by going to the
                    <a href="{{ URL::route('users.getMyAccount') }}">my account</a>
                    page and by clicking on
                    <a href="{{ URL::route('users.orderHistory') }}">history</a>. <br>
                    Thanks you for choosing us service. 
                    We apologize for any inconvenience this may have caused you.
                </p>
                <p>Buypremiumkey.com reseller</p>
                <div class="buttons">
                    <div class="pull-right">
                        <a href="{{ URL::route('frontend.articles.index') }}" class="btn btn-primary">Continue</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop