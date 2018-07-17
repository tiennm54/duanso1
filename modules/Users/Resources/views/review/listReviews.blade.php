@extends('frontend.master')

@section('content')

<div class="container">

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
                                <a href="<?php echo $item->getUrl();?>">
                                    <img src="{{url('images/'.$item->getArticles->image)}}" alt="Reviews {{ $item->title }} Premium Account" title="Click here to reviews {{ $item->title }}"
                                         class="img-responsive" style="width: 100%; max-height: 71px">
                                </a>
                                
                            </div>
                            <div class="">
                                <a href="<?php echo $item->getUrl();?>">
                                    <h4 style="text-align: center;">
                                        <span class="rating">
                                            <span class="fa fa-stack"><i class="fa {{ ($item->getRate() > 0) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                            <span class="fa fa-stack"><i class="fa {{ ($item->getRate() > 1) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                            <span class="fa fa-stack"><i class="fa {{ ($item->getRate() > 2) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                            <span class="fa fa-stack"><i class="fa {{ ($item->getRate() > 3) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                            <span class="fa fa-stack"><i class="fa {{ ($item->getRate() > 4) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                                        </span>
                                    </h4>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

@stop