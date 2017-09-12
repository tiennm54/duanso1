@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="#">Checkout</a></li>
            </ul>

            <div class="row">
                <div id="content" class="col-sm-12">
                    <h1>Shopping Cart</h1>
                    <p>Your shopping cart is empty!</p>
                    <div class="buttons clearfix">
                        <div class="pull-right"><a href="{{ URL::route('frontend.articles.index') }}" class="btn btn-primary">Continue</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop