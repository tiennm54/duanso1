@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li><a href="{{ URL::route('users.orderHistory') }}">Order History</a></li>
                <li><a href="#">Order Information</a></li>
            </ul>

            <div class="row">
                <div id="content" class="col-sm-9">
                    <h2>Order Information</h2>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left" colspan="2">Order Details</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left" style="width: 50%;">
                                Order No: <span class="label label-default">{{ $model->order_no }}</span><br>
                                Date Added: {{ $model->created_at }} <br>
                                Order ID: #{{ $model->id }}
                            </td>
                            <td class="text-left" style="width: 50%;">
                                Orders Status: <span class="label label-primary">{{ $model->payment_status }}</span><br>
                                Payment Method: {{ $model->payment_type->title }} <br>
                                Shipping Method: Send by email.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left" style="width: 50%; vertical-align: top;">Billing Information</td>
                            <td class="text-left" style="width: 50%; vertical-align: top;">Shipping Address</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">
                                Full name: <span class="label label-success">{{ $model->first_name }} {{ $model->last_name }}</span> <br/>
                                Email: {{ $model->email }} <br/>
                            </td>
                            <td class="text-left">
                                Email: <span class="label label-success">{{ $model->email }}</span> <br/>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <h2>Your Products</h2>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#list_order_product"><span style="font-size: 14px">Products</span></a></li>
                        <li><a data-toggle="tab" href="#list_premium_key"><span style="font-size: 14px">Premium Key</span></a></li>
                    </ul>

                    <div class="tab-content">

                        <div id="list_order_product" class="tab-pane fade in active">
                            <!--THONG TIN ĐƠN HÀNG-->
                            @include('users::order-history.includes.list_product')
                        </div>

                        <div id="list_premium_key" class="tab-pane fade">
                            <!--THONG TIN CODE-->
                            @include('users::order-history.includes.premium_key')
                        </div>

                    </div>



                    <div class="buttons clearfix">
                        <div class="pull-right">
                            <a href="{{ URL::route('users.orderHistory') }}" class="btn btn-primary">Continue</a>
                        </div>
                    </div>
                </div>

                @include('users::includes.my_account_column_right')

            </div>

        </div>
    </div>
@stop