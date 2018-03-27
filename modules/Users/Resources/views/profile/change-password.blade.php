@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li>Change Password</li>
            </ul>

            @include('validator.flash-message')

            <div class="row">
                <div id="content" class="col-sm-9"><h1>Change Password</h1>
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <fieldset>
                            <legend>Your Password</legend>

                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-password">Current Password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="current_password" value="" placeholder="Current Password" class="form-control" required>
                                    {!! $errors->first('current_password','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                                </div>
                            </div>


                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-password">New Password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="new_password" value="" placeholder="New Password" class="form-control" required>
                                    {!! $errors->first('new_password','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-confirm">Password Confirm</label>
                                <div class="col-sm-10">
                                    <input type="password" name="confirm_password" value="" placeholder="Password Confirm" class="form-control" required>
                                    {!! $errors->first('confirm_password','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                                </div>
                            </div>

                        </fieldset>
                        <div class="buttons clearfix">
                            <div class="pull-left">
                                <a href="{{ URL::route('users.getMyAccount') }}" class="btn btn-default">Back</a></div>
                            <div class="pull-right">
                                <input type="submit" value="Continue" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

                @include('users::includes.my_account_column_right')

            </div>

        </div>
    </div>
@stop