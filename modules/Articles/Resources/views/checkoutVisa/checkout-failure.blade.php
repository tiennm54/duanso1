@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('frontend.checkout.index') }}">Checkout Visa</a></li>
            <li><a href="#">Error</a></li>
        </ul>

        <div class="row">
            <div id="content" class="col-sm-12"><h1>An error occurred during the payment process. Please try a different payment method or try again later.</h1>
                <p>Thank you for using our service!</p>
                <p>Buypremiumkey.com reseller</p>
                <div class="buttons">
                    <div class="pull-right">
                        <a href="{{ URL::route('frontend.articles.index') }}" class="btn btn-primary">Continue</a></div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@stop