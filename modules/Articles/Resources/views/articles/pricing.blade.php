@extends('frontend.master')
@section('content')
<div class="container">

    <ul class="breadcrumb">
        <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
        <li><a href="{{ $model->getUrlPricing() }}">{{ $model->title }}</a></li>
    </ul>


    <div class="row">
        <div class="col-md-4">
            <?php
            $rate_reviews = 0;
            if (isset($model_reviews) && $model_reviews != null) {
                $rate_reviews = $model_reviews->getRate();
            }
            ?>

            <ul class="product-thumb">
                <li>
                    <a href="<?php echo ($model_reviews != null) ? $model_reviews->getUrl() : ""; ?>">
                        <img src="{{url('images/'.$model->image)}}" alt="{{ $model->title }}" title="{{ $model->title }}" class="img-responsive img-pricing">
                        <div class="view-rating">
                            <h4 style="text-align: center;">
                                <span >
                                    <i class="fa fa-star {{ ($rate_reviews > 0) ? "" : "fa-star-o" }}"></i>
                                    <i class="fa fa-star {{ ($rate_reviews > 1) ? "" : "fa-star-o" }}"></i>
                                    <i class="fa fa-star {{ ($rate_reviews > 2) ? "" : "fa-star-o" }}"></i>
                                    <i class="fa fa-star {{ ($rate_reviews > 3) ? "" : "fa-star-o" }}"></i>
                                    <i class="fa fa-star {{ ($rate_reviews > 4) ? "" : "fa-star-o" }}"></i>
                                </span><br>
                            </h4>
                        </div>
                    </a>
                </li>
            </ul>
            <?php if (isset($model_reviews) && $model_reviews != null) { ?>
                <a href="<?php echo $model_reviews->getUrl();?>" class="btn btn-primary btn-lg btn-block">
                    <i class="glyphicon glyphicon-star"></i>
                    Reviews {{ $model->title }}
                </a>
            <?php } ?>
        </div>
        <div class="col-md-8">
            <h1 style="margin-top: 0px;">
                <span>Buy {{ $model->title }} Premium Key at BuyPremiumKey Reseller get 2% bonus</span>
            </h1> 
        </div>
    </div>
    <hr/>

    <div class="row">
        <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
        <?php foreach ($model_type as $key => $item): ?>
            <div class="col-md-4 whole">
                <div class="type
                <?php
                switch ($key) {
                    case 0 : echo "standard";
                        break;
                    case 1 : echo "ultimate";
                        break;
                    default : echo "";
                        break;
                }
                ?>">
                    <p>
                        <a style="color: white" href="{{ $item->getUrl() }}" title="Read more...">{{ $item->title }}</a>
                    </p>

                </div>
                <div class="plan">
                    <div class="header-pricing">
                        <?php if ($item->status_stock == 1) { ?>
                            <p class="month">
                                <?php if (isset($item->old_price) && $item->old_price != 0): ?>
                                    <span class="old-price">$<?php echo $item->old_price; ?></span>
                                    <span class="sale-box"></span>
                                <?php endif; ?>
                                <span>${{ $item->price_order }}</span>
                            </p>
                        <?php } else { ?>
                            <p class="month">NOT IN STOCK</p>
                        <?php } ?>
                    </div>

                    <div class="content">
                        <ul>
                            <?php if ($item->getDescription != null && count($item->getDescription) != 0) { ?>
                                <?php foreach ($item->getDescription as $spe): ?>
                                    <li class="li-content">{{ $spe->description }}</li>
                                <?php endforeach; ?>
                            <?php }else { ?>
                                <li class="li-content">No specifications</li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="price">
                        <a onclick="addToCart({{ $item->id }})" class="btn btn-primary" data-toggle="modal" data-target="#myModal" <?php echo ($item->status_stock == 0) ? "disabled" : "" ?>>
                            <img src="{{url('theme_frontend/image/cart-1.png')}}" alt="Add to cart">
                            ADD TO CART
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <hr/>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">

                <?php if (isset($model_faq) && $model_faq != null): ?>
                    <li class="active">
                        <a data-toggle="tab" href="#howToActive">How to activate</a>
                    </li>
                <?php endif; ?>

                <li class="<?php echo (isset($model_faq) && $model_faq != null) ? "" : "active" ?>">
                    <a data-toggle="tab" href="#description">Description</a>
                </li>

                <li>
                    <a data-toggle="tab" href="#comment">Comment</a>
                </li>
            </ul>

            <div class="tab-content">

                <?php if (isset($model_faq) && $model_faq != null): ?>
                    <div id="howToActive" class="tab-pane fade in active">
                        <h1><?php echo $model_faq->title; ?></h1>
                        {!! $model_faq->description !!}
                        <a href="<?php echo $model_faq->getUrl(); ?>">Read more...</a>
                    </div>
                <?php endif; ?>

                <div id="description" class="tab-pane fade  <?php echo (isset($model_faq) && $model_faq != null) ? "" : "in active" ?>">
                    {!! $model->description !!}
                </div>

                <div id="comment" class="tab-pane fade">

                    <div class="fb-comments" data-href="{{ $model->getUrlPricing() }}" data-numposts="6"></div>

                </div>
            </div>
        </div>
    </div>
    <br/>
    <a href="{{ $model->getUrlPricing() }}">
        <img src="{{url('images/icon/step-buy-key.png')}}" alt="step buy premium key" width="100%">
    </a>

    <hr/>

    <div class="row">
        <div class="col-md-12">
            <h2 style="color: #1f90bb">Product List</h2>
        </div>

        <?php if (count($model_all_product)) { ?>
            <?php foreach ($model_all_product as $item_product): ?>
                <div class="col-md-3">
                    <a href="{{ $item_product->getUrlPricing() }}">{{ $item_product->title }}</a>
                </div>
            <?php endforeach; ?>
        <?php } ?>

    </div>


</div>
@stop

