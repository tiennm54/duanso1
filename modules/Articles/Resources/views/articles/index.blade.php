@extends('frontend.master')
@section('content')
<div class="container">
    @include('frontend.banner')
    @include('validator.flash-message')
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row">
                <?php
                if (count($model) == 0) {
                    echo "There is no product that matches the search criteria.";
                }
                ?>
                <?php foreach ($model as $key => $item): ?>
                    <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="product-thumb transition">
                            <div class="image">
                                <a href="{{ $item->getUrlPricing() }}">
                                    <img src="{{url('images/'.$item->image)}}" alt="Buy {{ $item->title }} Premium via Paypal, Visa/Master card" title="{{ $item->title }} ({{$item->view_count}} views)"
                                         class="img-responsive" style="width: 100%; max-height: 71px">
                                </a>
                            </div>
                            <div class="">
                                <h4 style="text-align: center;">
                                    <a href="{{ $item->getUrlPricing() }}">{{ $item->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="text-center">
                    <a href="{{ URL::route('frontend.articles.getListProduct') }}" class="btn btn-success" style="margin-bottom: 20px">SORT BY NAME A to Z</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class=" banner-homepage" style="padding: 15px;"></div>

<div class=" banner-homepage banner-homepage-content">
    <div class="container ">
        <div class="row">
            <div class="page-title">
                <h2>Some of our 379,868+ customers used services</h2>
            </div>

            <div id="review">
                <?php foreach ($model_reviews as $item): ?>
                    <div class="well">
                        <p>
                            <b><?php echo $item->review_name; ?></b>
                            <span class="rating">
                                <span class="fa fa-stack"><i class="fa {{ ($item->review_rate > 0) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                <span class="fa fa-stack"><i class="fa {{ ($item->review_rate > 1) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                <span class="fa fa-stack"><i class="fa {{ ($item->review_rate > 2) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                <span class="fa fa-stack"><i class="fa {{ ($item->review_rate > 3) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                <span class="fa fa-stack"><i class="fa {{ ($item->review_rate > 4) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                            </span>
                            <span><i class="glyphicon glyphicon-time"></i> <?php echo $item->created_at; ?> </span>
                        </p>
                        <p>
                            <span><?php echo $item->review_des; ?></span>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row">
            <div class="text-center">
                <a href="<?php echo URL::route('users.review.index') ?>" class="btn btn-success" style="margin-bottom: 20px">Read more <i class="glyphicon glyphicon-circle-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>


@stop