@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
            <li><a href="{{ URL::route('users.orderHistory') }}">Order History</a></li>
            <li>Order Information</li>
        </ul>
        @include('validator.flash-message')
        <div class="row">
            <div id="content" class="col-sm-9">
                <h2>Order Information</h2>
                <?php
                $intProgress = "";
                $stringProgress = "";
                switch ($model->payment_status) {
                    case "pending" :
                        $intProgress = "width: 30%";
                        $stringProgress = "Pending";
                        break;
                    case "paid" :
                        $intProgress = "width: 60%";
                        $stringProgress = "Paid";
                        break;
                    case "completed" :
                        $intProgress = "width: 100%";
                        $stringProgress = "Completed";
                        break;
                    case "refund" :
                        $intProgress = "width: 100%";
                        $stringProgress = "Refunded";
                        break;

                    case "cancel" :
                        $intProgress = "width: 100%";
                        $stringProgress = "Canceled";
                        break;
                }
                ?>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="{{ $intProgress }}">
                        {{ $stringProgress }}
                    </div>
                </div>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                    <form method="post" action="{{ URL::route('users.postCancelOrder',['id'=>$model->id] ) }}">
                        <td class="text-left" colspan="2">
                            Order Details
                            <?php if ($model->payment_status == "pending"): ?>
                                <button class="btn btn-danger" 
                                        data-toggle="confirmation" 
                                        data-placement="left" style="float: right" 
                                        data-toggle="tooltip" title="Cancel Order">
                                    Cancel
                                </button>
                            <?php endif; ?>
                        </td>
                    </form>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left" style="width: 50%;">
                                <p>Invoice: 
                                    <span style="font-weight: bold">
                                        <a href="<?php echo URL::route('frontend.invoice.view', ['id' => $model->id, 'email' => $model->email]) ?>" title="View Invoice Detail">
                                            #{{ $model->order_no }}
                                        </a>
                                    </span>
                                </p>
                                <p>Date Added: <span style="font-weight: bold">{{ $model->created_at }}</span></p>
                                <p>Order ID: <span style="font-weight: bold">#{{ $model->id }}</span></p>
                            </td>
                            <td class="text-left" style="width: 50%;">
                                <p>Orders Status: 
                                    <span class="label  <?php echo ($model->payment_status == "completed") ? "label-primary" : "label-danger"; ?>">
                                        {{ $model->payment_status }}
                                    </span>
                                </p>
                                <p>Payment Method: <span style="font-weight: bold">{{ $model->payment_type->title }}</span></p>
                                <p>Shipping Method: <span style="font-weight: bold">Send by email.</span></p>
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
                                <p>Full name: <span style="font-weight: bold">{{ $model->first_name }} {{ $model->last_name }}</span></p>
                                <p>Email: <span style="font-weight: bold">{{ $model->email }}</span></p>
                            </td>
                            <td class="text-left">
                                <p>Email: <span class="label label-primary">{{ $model->email }}</span></p>
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

                <!--HISTORY-->
                @include('users::order-history.includes.orders_history')


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