@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a>Feedback</a></li>
        </ul>
        @include('validator.flash-message')
        <div id="content" class="col-sm-9">
            <p style="font-size: 18px; color: blue">
                Please let us know your feedback so that we can serve you better.
                If our web site is bug, please send the bug's image to us, we will fix it immediately.
                Thank you so much!
            </p>
            <hr/>
            <form action="{{ URL::route('users.feedback.postFeedBack') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                <fieldset>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label">Your Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" placeholder="Your Name" class="form-control" value="{{ old('name') }}" required>
                            {!! $errors->first('name','<span class="control-label color-red" style="color: red">:message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="col-sm-2 control-label">Feed Back</label>
                        <div class="col-sm-10">
                            <textarea type="text" rows="5" name="description" class="form-control textarea" required>{{ old('description') }}</textarea>
                            {!! $errors->first('description','<span class="control-label color-red" style="color: red">:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control border-input" name="image">
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
                    <div class="pull-right">
                        <input type="submit" value="Continue" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>

        @include('users::includes.login_column_right')


    </div>
</div>

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
$('.textarea').ckeditor();
</script>
@stop