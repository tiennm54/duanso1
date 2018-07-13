@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('frontend.checkout.index') }}">Checkout</a></li>
                <li><a href="#">Success</a></li>
            </ul>

            <div class="row">
                <div id="content" class="col-sm-12"><h1>Your order has been placed!</h1>
                    <p>Your order has been successfully processed! We have sent an order to your email. After you pay, we will send the premium key to you.</p>
                    <p>You can view your order history by going to the
                        <a href="{{ URL::route('users.getMyAccount') }}">my account</a>
                        page and by clicking on
                        <a href="{{ URL::route('users.orderHistory') }}">history</a>.
                    </p>

                    <p>Please direct any questions you have to the
                        <a href="{{ URL::route('users.contact.getContact') }}">store owner</a>.
                    </p>

                    <?php if ($email != "" && $password != ""){?>
                        <p>Your account: {{ $email }}</p>
                        <p>Password: {{ $password }}</p>
                        <p>Click <a href="{{ URL::route('users.getChangePassword') }}">here</a> to change your password</p>
                    <?php }?>

                    <p>Thanks for shopping with us online!</p>

                    <div class="buttons">
                        <div class="pull-right">
                            <a href="{{ URL::route('frontend.articles.index') }}" class="btn btn-primary">Continue</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop