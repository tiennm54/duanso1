@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li>Login</li>
            </ul>
            @include('validator.flash-message')
            <div class="row">
                <div id="content" class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="well">
                                <h2>New Customer</h2>
                                <p><strong>Register Account</strong></p>
                                <p>By creating an account you will be able to shop faster, be up to date on an order's
                                    status, and keep track of the orders you have previously made.</p>
                                <a href="{{ URL::route('users.getRegister') }}" class="btn btn-primary">Continue</a>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="well">
                                <h2>Returning Customer</h2>
                                <p><strong>I am a returning customer</strong></p>
                                <form novalidate="novalidate" role="form" method="POST" action="{!! route('users.postLogin') !!}">

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"><span style="color: red">*</span>Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" class="form-control" placeholder="Email"
                                                   value="{{ old('email') }}">
                                            {!! $errors->first('email','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"><span style="color: red">*</span>Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                            {!! $errors->first('password','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                                            <a href="{{ URL::route('users.getForgotten') }}">Forgotten Password</a>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('users::includes.login_column_right')
            </div>
        </div>
    </div>
@stop

