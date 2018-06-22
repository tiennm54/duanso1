@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a>Review</a></li>
        </ul>
        @include('validator.flash-message')
        <div id="content" class="col-sm-9">
            <div>
                <p style="font-size: 18px">
                    <b>Review BuyPremiumKey.com Reseller</b>
                </p>
            </div>
            <hr>
            <div>
                <p style="font-size: 16px">
                    We always aim for the following criteria:
                </p>
                <ul>
                    <li>
                        1. Cheapest Prices:  We selling premium file-sharing plans with cheapest prices. If there is another reseller that sells cheaper, let us know.
                    </li>
                    <li>
                        2. Fastest Delivery: We always try to deliver premium key to you as soon as possible. Usually it does not exceed 30 minutes for on-line payments during opening time, maximum 6 hours. <br/>
                        <span style="color: red">Our working time: 8h00 - 23h00 GMT+7</span>.
                    </li>
                    <li>
                        3. Easy payment methods: We support more worldwide payment methods: Paypal, Visa/MasterCard, WMZ, Perfect Money, Amazon pay, Bonus pay.
                    </li>
                    <li>
                        4. Non-Recurring payment: We DO NOT recurring the payments of our customers.
                    </li>
                    <li>
                        5. High Secure Security: We do not keep records of the card details. Credit/Debitcard are processed by a third party secured payment gateway (Qwikpay.org).
                    </li>
                </ul>
            </div>
            <hr>

            <p style="font-size: 16px">
                Please let us know the evaluation from you, so that we can improve our service better. Sincerely thank.
            </p>

            <hr>

            <div class="fb-comments" data-href="<?php echo URL::route('users.review.index'); ?>" data-numposts="20"></div>
        </div>
        @include('users::includes.login_column_right')
    </div>
</div>
@stop