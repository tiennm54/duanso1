@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li>Forgotten Password</li>
            </ul>

            @include('validator.flash-message')

            <div id="content" class="col-sm-9">
                <h1>Forgot Your Password?</h1>
                <p>Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.</p>
                <form action="{{ URL::route('users.postForgotten') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <fieldset>
                        <legend>Your E-Mail Address</legend>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-email">E-Mail Address</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" placeholder="E-Mail Address" id="input-email" class="form-control" required>
                            </div>
                        </div>
                    </fieldset>
                    <div class="buttons clearfix">
                        <div class="pull-left"><a href="{{ URL::route('users.getLogin') }}" class="btn btn-default">Back</a></div>
                        <div class="pull-right">
                            <input type="submit" value="Continue" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>

            @include('users::includes.login_column_right')


        </div>
    </div>
@stop