@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="#">Notification</a></li>
        </ul>

        <div class="row">
            <div id="content" class="col-sm-12">
                <div class="page-title">
                    <h1>Payment Error</h1>
                </div>
                <p>
                    <span>The payment method you selected cannot process payment for your order. </span><br/><br/>
                    <span>Please create a new order and choose another payment method. I apologize for the inconvenience. </span><br/><br/>
                    <span>Thank you very much!</span><br/><br/>
                    <span>Best regards!</span>
                </p>
                <div class="buttons clearfix">
                    <div class="pull-right"><a href="{{ URL::route('frontend.articles.index') }}" class="btn btn-success">Continue</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop