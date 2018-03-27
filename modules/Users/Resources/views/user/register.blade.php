@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
            <li>Register</li>
        </ul>
        
        @include('validator.flash-message')

        <div class="col-md-12 well">
            <form novalidate="novalidate" role="form" method="POST" action="{!! route('users.postRegister') !!}">

                <?php
                $ref = app('request')->input('ref');
                if ($ref) { ?>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sponsor: </label>
                        <div class="col-sm-4">
                            <input type="email" name="sponsor" class="form-control" placeholder="If you don't have sponsor, then leave it blank" value="{{ $ref }}">
                            {!! $errors->first('sponsor','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>

                <?php } ?>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><span style="color: red">*</span>First Name: </label>
                    <div class="col-sm-4">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name..." value="{{ old('first_name') }}">
                        {!! $errors->first('first_name','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><span style="color: red">*</span>Last Name: </label>
                    <div class="col-sm-4">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}">
                        {!! $errors->first('last_name','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><span style="color: red">*</span>Email</label>
                    <div class="col-sm-4">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        {!! $errors->first('email','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><span style="color: red">*</span>Password</label>
                    <div class="col-sm-4">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        {!! $errors->first('password','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><span style="color: red">*</span>Confirm Password</label>
                    <div class="col-sm-4">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password">
                        {!! $errors->first('confirm_password','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>

            </form>

        </div>


    </div>
</div>



@stop

