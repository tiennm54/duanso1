@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a>Contact</a></li>
            </ul>
            
            @include('validator.flash-message')
            <div id="content" class="col-sm-9">
                <div class="page-title">
                    <h1>CONTACT US</h1>
                </div>
                <form action="{{ URL::route('users.contact.postContact') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <fieldset>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label">Your Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" placeholder="Your Name" class="form-control" value="{{ old('name') }}" required>
                                {!! $errors->first('name','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-email">E-Mail Address</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" placeholder="E-Mail Address" class="form-control" value="{{ old('email') }}" required>
                                {!! $errors->first('email','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label">Enquiry</label>
                            <div class="col-sm-10">
                                <textarea type="text" rows="5" name="enquiry" class="form-control" required>{{ old('enquiry') }}</textarea>
                                {!! $errors->first('enquiry','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label">Captcha</label>
                            <div class="col-sm-10">

                                {!! Captcha::display($attributes) !!}
                                {!! $errors->first('g-recaptcha-response','<span class="control-label color-red" style="color: red">:message</span>') !!}

                            </div>
                        </div>

                    </fieldset>

                    <div class="buttons clearfix">
                        <div class="pull-left"><a href="{{ URL::route('users.getLogin') }}" class="btn btn-default">Back</a></div>
                        <div class="pull-right">
                            <input type="submit" value="Continue" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>

            @include('users::includes.login_column_right')


        </div>
    </div>
@stop