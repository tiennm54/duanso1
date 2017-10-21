@extends('frontend.master')
@section('content')
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('frontend.articles.pricing', ['id' => $model->id, 'url'=> $model->url_title.".html"] ) }}">{{ $model->title }}</a></li>
        </ul>


        <div class="row">
            <div class="col-md-4">
                <img src="{{url('images/'.$model->image)}}" alt="{{ $model->title }}" title="{{ $model->title }}" class="img-responsive">
            </div>
            <div class="col-md-8">
                <h1 style="margin-top: 0px;">{{ $model->title }} Premium Key |   We Are Best Official Reseller {{ $model->title }} Premium Key/Account</h1>
                <p style="color: red">Paypal payment method will charge 10-15% fee & Take 24 hours to delivery! Thank you so much!</p>
            </div>
        </div>
        <hr/>

        <div class="row">
            <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
                <?php foreach ($model_type as $key=>$item):?>
                <div class="col-md-4 whole">
                    <div class="type
                        <?php switch ($key){
                        case 0 : echo "standard"; break;
                        case 1 : echo "ultimate"; break;
                        default : echo ""; break;
                    }?>">

                    <p>
                        <a style="color: white" href="{{ URL::route('frontend.articles.view', ['id'=>$item->id, 'url'=>$item->url_title.".html"]) }}" title="Read more...">{{ $item->title }}</a>
                    </p>
                    </div>
                    <div class="plan">

                        <div class="header-pricing">
                            <p class="month">${{ $item->price_order }}</p>
                        </div>

                        <div class="content">
                            <ul>
                                <?php if($item->getDescription != null && count($item->getDescription) != 0){?>
                                    <?php foreach ($item->getDescription as $spe):?>
                                        <li class="li-content">{{ $spe->description }}</li>
                                    <?php endforeach; ?>
                                <?php }else{?>
                                    <li class="li-content">No specifications</li>
                                <?php }?>
                            </ul>
                        </div>

                        <div class="price">
                            <a onclick="addToCart({{ $item->id }})" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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
                    <li class="active">
                        <a data-toggle="tab" href="#description">Description</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#comment">Comment</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div id="description" class="tab-pane fade  in active">
                        {!! $model->description !!}
                    </div>

                    <div id="comment" class="tab-pane fade row">
                        <div class="col-md-6">
                            <div class="fb-comments" data-href="{{ URL::route('frontend.articles.pricing', ['id' => $item->id, 'url' => $item->url_title.".html" ]) }}" data-numposts="6"></div>
                        </div>

                        <div class="col-md-6">
                            <div class="fb-page  pull-right" data-href="https://www.facebook.com/buypremiumkey/" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/buypremiumkey/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/buypremiumkey/">Buy Premium Key</a></blockquote></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <hr/>

        <a href="{{ URL::route('frontend.articles.pricing', ['id' => $model->id, 'url'=> $model->url_title.".html"] ) }}"><img src="{{url('images/icon/step-buy-key.png')}}" alt="step buy premium key" width="100%"></a>

        <hr/>

        <div class="row">
            <div class="col-md-12">
                <h2 style="color: #1f90bb">Product List</h2>
            </div>

            <?php if(count($model_all_product)){?>
                <?php foreach ($model_all_product as $item_product):?>
                    <div class="col-md-3">
                        <a href="{{ URL::route('frontend.articles.pricing', ['id' => $item_product->id, 'url' => $item_product->url_title.".html" ]) }}">{{ $item_product->title }}</a>
                    </div>
                <?php endforeach;?>
            <?php }?>

        </div>


    </div>
@stop

