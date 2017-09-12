@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li><a href="#">Register Success</a></li>
            </ul>

            <div class="row">
                <div id="content" class="col-sm-9"><h1>Your Account Has Been Created!</h1>
                    <p>Congratulations! Your new account has been successfully created!</p>
                    <p>You can now take advantage of member privileges to enhance your online shopping experience with us.</p>
                    <p>If you have ANY questions about the operation of this online shop, please e-mail the store owner.</p>
                    <p>A confirmation has been sent to the provided e-mail address. If you have not received it within the hour, please
                        <a href="#">contact us</a>.
                    </p>
                    <div class="buttons">
                        <div class="pull-right">
                            <a href="{{ URL::route('users.getMyAccount') }}" class="btn btn-primary">Continue</a>
                        </div>
                    </div>
                </div>

                @include('users::includes.my_account_column_right')

            </div>


        </div>
    </div>
@stop