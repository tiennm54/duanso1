@extends('frontend.master')
@section('content')
<div class="container">

    <ul class="breadcrumb">
        <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
        <li><a href="{{ $model->getArticles->getUrlPricing() }}">{{ $model->getArticles->title }}</a></li>
        <li><a href="{{ $model->getUrl() }}">{{ $model->title }}</a></li>
    </ul>
    @include('frontend.banner')
    @include('validator.validator-input')
    @include('validator.flash-message')
    <div class="row">
        <div id="content" class="col-sm-12">
            <div class="row">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-5">
                            <ul class="product-thumb">
                                <li>
                                    <a href="{{ $model->getArticles->getUrlPricing() }}">
                                        <img src="{{url('images/'.$model->getArticles->image)}}" title="{{ $model->title }}" alt="{{ $model->title }}" width="100%">
                                    </a>
                                </li>
                                <h1 style="text-align: center; font-size: 26px">{{ $model->title }}</h1>
                            </ul>
                            <div id="product">
                                <div class="form-group">
                                    <a onclick="location.href = '<?php echo $model->getUrlBuyNow();?>';"
                                        class="btn btn-success btn-lg btn-block"  <?php echo ($model->status_stock == 0) ? "disabled" : "" ?>>
                                        <i class="glyphicon glyphicon-shopping-cart"></i> BUY NOW
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7">
                            <ul class="list-unstyled">
                                <li>Brand: <b><a href="{{ $model->getArticles->getUrlPricing() }}"> {{ $model->getArticles->title }}</a></b></li>
                                <li>Product Code: <b>{{ $model->code }}</b></li>
                                <li>Availability:
                                    <?php if ($model->status_stock == 1) { ?>
                                        <div class="label label-primary badge">
                                            <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> In Stock</span>
                                        </div>
                                    <?php } else { ?>
                                        <div class="label label-primary badge">
                                            <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Not In Stock</span>
                                        </div>
                                    <?php } ?>

                                </li>
                            </ul>

                            <ul class="list-unstyled">
                                <li>
                                    <h2>
                                        ${{ $model->price_order }}
                                        <button type="button" data-toggle="tooltip" class="btn btn-default" title="" onclick="addWishlist({{ $model->id }});" data-original-title="Add to Wish List">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </h2>
                                </li>
                            </ul>
                            
                            <div class="rating">
                                <?php 
                                    $sum_rate = 0;
                                    if($model_reviews){
                                        $sum_rate = $model_reviews->getRate();
                                    }
                                ?>
                                <p>
                                    <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 1) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                    <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 2) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                    <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 3) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                    <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 4) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                    <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 5) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                    <a href="<?php echo ($model_reviews) ? $model_reviews->getUrl() : "#"; ?>"> Write a review</a>
                                </p>
                            </div>
                            <hr/>
                            <div>
                                <div id="fb-root" class="col-sm-3">
                                    <div class="fb-like" data-href="{{ $model->getUrl() }}" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/u/0/107279642922867219348" data-rel="publisher"></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="g-plus" data-action="share" data-href="{{ $model->getUrl() }}"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-description" data-toggle="tab">Description</a></li>
                        <li><a href="#tab-specific" data-toggle="tab">Specification</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-description">
                            {!! $model->description !!}
                        </div>

                        <div class="tab-pane" id="tab-specific">
                            @include('articles::includes.view_tab_specific')
                        </div>
                    </div>
                </div>


                @include('articles::includes.view_column_right',compact('model'))

            </div>
        </div>
    </div>

    @include('articles::includes.view_related_product', compact('model_related'))



</div>
@stop