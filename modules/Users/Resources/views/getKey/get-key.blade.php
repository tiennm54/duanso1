@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li>Get Premium Key</li>
            </ul>

            @include('validator.flash-message')

            <div id="content" class="col-sm-9">
                <h1>Get Premium Key</h1>

                <form action="{{ URL::route('users.guestOrder.postGuestGetKey') }}" method="post" enctype="multipart/form-data" class="form-horizontal">

                    <fieldset>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Order Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" placeholder="Order Email" class="form-control" value="{{ old('email') }}" required>
                                {!! $errors->first('email','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-email">Order No. (BPK-***)</label>
                            <div class="col-sm-9">
                                <input type="text" name="order_no" placeholder="BPK-123456" class="form-control" value="{{ old('order_no') }}" required>
                                {!! $errors->first('order_no','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Captcha</label>
                            <div class="col-sm-9">

                                {!! Captcha::display($attributes) !!}
                                {!! $errors->first('g-recaptcha-response','<span class="control-label color-red" style="color: red">:message</span>') !!}

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