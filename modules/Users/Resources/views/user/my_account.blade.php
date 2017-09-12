@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
            </ul>

            @include('validator.flash-message')
            <div class="row">
                <div id="content" class="col-sm-9"><h2>My Account</h2>
                    <ul class="list-unstyled">
                        <li><a href="{{ URL::route('users.getEditProfile') }}">Edit your account information</a></li>
                        <li><a href="#">Change your password</a></li>
                        <li><a href="{{ URL::route('users.getWishList') }}">Modify your wish list</a></li>
                    </ul>
                    <h2>My Orders</h2>
                    <ul class="list-unstyled">
                        <li><a href="{{ URL::route('users.orderHistory') }}">View your order history</a></li>
                        {{--<li><a href="#">Downloads</a></li>
                        <li><a href="#">Your Reward Points</a></li>
                        <li><a href="#">View your return requests</a></li>
                        <li><a href="#">Your Transactions</a></li>
                        <li><a href="#">Recurring payments</a></li>--}}
                    </ul>
                    <h2>Newsletter</h2>
                    <ul class="list-unstyled">
                        <li><a href="#">Subscribe / unsubscribe to newsletter</a></li>
                    </ul>
                </div>

                @include('users::includes.my_account_column_right')

            </div>

        </div>
    </div>
@stop