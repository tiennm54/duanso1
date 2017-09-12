@extends('frontend.master')
@section('content')
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('frontend.articles.pricing', ['id' => $model->getArticles->id, 'url'=> $model->getArticles->url_title.".html"] ) }}">{{ $model->getArticles->title }}</a></li>
            <li><a href="{{ URL::route('frontend.articles.view', ['id' => $model->id, 'url' => $model->url_title.".html" ] ) }}">{{ $model->title }}</a></li>
        </ul>

        @include('validator.flash-message')

        <div class="row">
            <div id="content" class="col-sm-12">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1>{{ $model->title }}</h1>

                                <ul class="thumbnails" style="margin-top: 30px">
                                    <li>
                                        <a href="{{ URL::route('frontend.articles.pricing', ['id'=>$model->getArticles->id, 'url'=>$model->getArticles->url_title.".html"] ) }}">
                                            <img src="{{url('images/'.$model->getArticles->image)}}" title="{{ $model->title }}" alt="{{ $model->title }}">
                                        </a>

                                    </li>
                                </ul>
                            </div>

                            <div class="col-sm-5">

                                <ul class="list-unstyled">
                                    <li>Brand: <a href="{{ URL::route('frontend.articles.pricing', ['id'=>$model->getArticles->id, 'url'=>$model->getArticles->url_title.".html"] ) }}"> {{ $model->getArticles->title }}</a></li>
                                    <li>Product Code: {{ $model->code }}</li>
                                    <li>Availability:
                                        <?php if ($model->status_stock == 1){?>
                                            <div class="label label-primary badge">
                                                <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> In Stock</span>
                                            </div>
                                        <?php }else{?>
                                            <div class="label label-primary badge">
                                                <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Not In Stock</span>
                                            </div>
                                        <?php }?>

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


                                <div id="product">
                                    <div class="form-group">
                                        <button type="button" id="button-cart" data-loading-text="Loading..." onclick="addToCart({{ $model->id }})" data-toggle="modal" data-target="#myModal"
                                                class="btn btn-primary btn-lg btn-block">Add to Cart
                                        </button>
                                    </div>
                                </div>
                                <div class="rating">
                                    <p>
                                        <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 1) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                        <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 2) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                        <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 3) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                        <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 4) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                        <span class="fa fa-stack"><i class="fa {{ ($sum_rate >= 5) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>

                                        <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">{{ count($model->getReview) }} reviews</a> /
                                        <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Write a review</a>
                                    </p>

                                </div>
                                <hr/>
                                <div>
                                    <div id="fb-root" class="col-sm-3">
                                        <div class="fb-like" data-href="https://www.facebook.com/buypremiumkey/" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/u/0/107279642922867219348" data-rel="publisher"></div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-description" data-toggle="tab">Description</a></li>
                            <li><a href="#tab-specific" data-toggle="tab">Specification</a></li>
                            <li><a href="#tab-review" data-toggle="tab">Reviews ({{ count( $model->getReview ) }})</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-description">
                                {!! $model->description !!}
                            </div>

                            <div class="tab-pane" id="tab-specific">
                                @include('articles::includes.view_tab_specific')
                            </div>

                            <div class="tab-pane" id="tab-review">
                                @include('articles::includes.view_tab_review', compact('model','attributes'))
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