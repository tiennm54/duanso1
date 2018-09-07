@extends('frontend.master')
@section('content')
<div class="container">
    <ul class="breadcrumb">
        <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
        <li><a href="<?php echo $model->getUrlIndex(); ?>">Reviews Product</a></li>
        <li><a href="">Reviews {{ $model->title }} premium</a></li>
    </ul>
    @include('validator.flash-message')
    @include('validator.validator-input')
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-5">
                            <ul class="product-thumb">
                                <li>
                                    <a href="<?php echo $model->getArticles->getUrlPricing(); ?>">
                                        <img src="{{url('images/'.$model->getArticles->image)}}" title="Buy {{ $model->title }} premium" alt="Buy {{ $model->title }} premium" width="100%">
                                        <div class="view-rating">
                                            <h4 style="text-align: center;">
                                                <span >
                                                    <i class="fa fa-star {{ ($data_reviews["sum"] > 0) ? "" : "fa-star-o" }}"></i>
                                                    <i class="fa fa-star {{ ($data_reviews["sum"] > 1) ? "" : "fa-star-o" }}"></i>
                                                    <i class="fa fa-star {{ ($data_reviews["sum"] > 2) ? "" : "fa-star-o" }}"></i>
                                                    <i class="fa fa-star {{ ($data_reviews["sum"] > 3) ? "" : "fa-star-o" }}"></i>
                                                    <i class="fa fa-star {{ ($data_reviews["sum"] > 4) ? "" : "fa-star-o" }}"></i>
                                                </span><br>
                                            </h4>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <a href="<?php echo $model->getArticles->getUrlPricing(); ?>" class="btn btn-success btn-lg btn-block">
                                <i class="glyphicon glyphicon-shopping-cart	"></i>
                                Buy <?php echo $model->title; ?>
                            </a>
                        </div>
                        <div class="col-sm-7">
                            <div class="page-title" style="margin-top: -20px;">
                                <h1>
                                    Reviews {{ $model->title }} <span style="font-size: 15px">(<?php echo $data_reviews["count"]; ?> reviews)</span>
                                </h1>
                            </div>
                            <p>{!! $model->description !!}</p>
                        </div>
                    </div>
                    <div class="row">
                        @include('users::includes.review_widget')
                    </div>
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
    </div>




</div>

@stop