@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getLogin') }}">Account</a></li>
                <li>Logout</li>
            </ul>


            <div class="row">
                <div id="content" class="col-sm-9">
                    <div class="row">
                        <div id="content" class="col-sm-12">
                            <h1>Account Logout</h1>
                            <p>You have been logged off your account. It is now safe to leave the computer.</p>
                            <p>Your shopping cart has been saved, the items inside it will be restored whenever you log back into your account.</p>
                            <div class="buttons">
                                <div class="pull-right"><a href="{{ URL::route('frontend.articles.index') }}" class="btn btn-primary">Continue</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('users::includes.login_column_right')
            </div>
        </div>
    </div>
@stop

