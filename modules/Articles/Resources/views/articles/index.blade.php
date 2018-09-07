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
@stop