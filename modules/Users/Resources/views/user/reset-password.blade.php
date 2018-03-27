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
                <h1>Reset Your Password.</h1>
                <form action="{{ URL::route('users.postResetPassword', ['user_email'=>$email, "key_forgotten" => $key_forgotten]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <fieldset>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label">New password</label>
                            <div class="col-sm-10">
                                <input type="password" name="new_password" placeholder="New password" class="form-control" required>
                                {!! $errors->first('new_password','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" required>
                                {!! $errors->first('confirm_password','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                    </fieldset>


                    <div class="buttons clearfix">
                        <div class="pull-left"><a onclick="goBack()" class="btn btn-default">Back</a></div>
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