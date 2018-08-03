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
                
                <h1 style="margin-top: 0px; margin-bottom: 20px;">Get the premium key you bought</h1>
                <form action="{{ URL::route('users.guestOrder.postGuestGetKey') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <fieldset>

                        <div class="form-group required">
                            <label class="col-sm-2">Order Email</label>
                            <div class="col-sm-6">
                                <input type="email" name="email" placeholder="Your order email" class="form-control" value="{{ old('email') }}" required>
                                {!! $errors->first('email','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2" for="input-email">Order No</label>
                            <div class="col-sm-6">
                                <input type="text" name="order_no" placeholder="BPK-12345679. We have sent it to your email." class="form-control" value="{{ old('order_no') }}" required>
                                {!! $errors->first('order_no','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2">Captcha</label>
                            <div class="col-sm-6">

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