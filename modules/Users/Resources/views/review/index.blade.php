@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a>Review website</a></li>
        </ul>
        @include('frontend.banner')
        @include('validator.validator-input')
        @include('validator.flash-message')
        <div id="content" class="col-sm-9">
            <div class="page-title">
                <h1>Some of our 379,868+ customers used services</h1>
            </div>
            <div class="view-rating">
                <span >
                    <i class="fa fa-star {{ ($data_reviews["sum"] > 0) ? "" : "fa-star-o" }}"></i>
                    <i class="fa fa-star {{ ($data_reviews["sum"] > 1) ? "" : "fa-star-o" }}"></i>
                    <i class="fa fa-star {{ ($data_reviews["sum"] > 2) ? "" : "fa-star-o" }}"></i>
                    <i class="fa fa-star {{ ($data_reviews["sum"] > 3) ? "" : "fa-star-o" }}"></i>
                    <i class="fa fa-star {{ ($data_reviews["sum"] > 4) ? "" : "fa-star-o" }}"></i>
                </span>
                <span>Reviews (<?php echo $data_reviews["count"]; ?>)</span>
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
                        <span style="color: red">Our working time: 8h00 - 23h00 GMT +8</span>.
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

            @include('users::includes.review_widget')


        </div>
        <div class="col-sm-3">
            <div class="list-group">
                <a href="" class="list-group-item active">Reviews Product ({{ count($model_product_reviews) }})</a>
                <?php foreach ($model_product_reviews as $item): ?>
                    <a href="{{ $item->getUrl() }}" class="list-group-item">&nbsp;&nbsp;&nbsp;- {{ $item->title }}</a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

@stop