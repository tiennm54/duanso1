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
            
            <!--<form action="" method="post">
                <input name=action value="Product">
                <input name=buyer value="buyer">
                <input name=comment value="comment">
                <input name=orderid value="orderid">
                <input name=pid value="pid">
                <input name=pname value="pname">
                <input name=quantity value="quantity">
                <input name=status value="status">
                <input name=total value="total">
                <input name=signature value="signature">
                <button type="submit">POST</button>
            </form>-->
            
            <div id="content" class="col-sm-12"><h1>An error occurred during the payment process, please try again.</h1>
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