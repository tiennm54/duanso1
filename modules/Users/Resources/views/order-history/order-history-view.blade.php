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
                <div id="content" class="col-sm-9"><h2>Order Information</h2>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left" colspan="2">Order Details</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left" style="width: 50%;">
                                <b>Order No:</b> <span style="color: #00A6C7; font-weight: bold">{{ $model->order_no }}</span><br>
                                <b>Order ID:</b> #{{ $model->id }}<br>
                                <b>Date Added:</b> {{ $model->created_at }}
                            </td>
                            <td class="text-left" style="width: 50%;">
                                <b>Payment Method:</b> {{ $model->payment_type->title }} <br>
                                <b>Shipping Method:</b> Send by email.
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
                                Full name: {{ $model->first_name }} {{ $model->last_name }} <br/>
                                Email: {{ $model->email }} <br/>
                            </td>
                            <td class="text-left">
                                Email: {{ $model->email }} <br/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left">Product Name</td>
                                    <td class="text-left">Model</td>
                                    <td class="text-right">Quantity</td>
                                    <td class="text-right">Price</td>
                                    <td class="text-right">Total</td>
                                    <td style="width: 20px;"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($model_order) == 0):?>
                                    <tr>
                                        <td class="text-left" colspan="6">Your shopping cart is empty!</td>
                                    </tr>
                                <?php endif;?>
                                <?php if (count($model_order) > 0):?>
                                    <?php foreach ($model_order as $item):?>
                                    <tr>
                                        <td class="text-left">{{ $item->articles_type->title }}</td>
                                        <td class="text-left">{{ $item->articles_type->getArticles->title }}</td>
                                        <td class="text-right">{{ $item->quantity }}</td>
                                        <td class="text-right">${{ $item->price_order }}</td>
                                        <td class="text-right">${{ $item->total_price }}</td>

                                        <td class="text-right" style="white-space: nowrap;">
                                            <a onclick="addToCart({{ $item->articles_type_id }})" data-toggle="modal" data-target="#myModal"
                                               data-toggle="tooltip" title="Reorder" class="btn btn-primary" data-original-title="Reorder">
                                                <i class="fa fa-shopping-cart"></i>
                                            </a>
                                            {{--<a href="" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Return">
                                                <i class="fa fa-reply"></i>
                                            </a>--}}
                                        </td>

                                    </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><b>Sub-Total</b></td>
                                    <td class="text-right">${{ $model->sub_total }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><b>Chargers {{ $model->payment_type->title }}</b></td>
                                    <td class="text-right">${{ $model->payment_charges }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right"><b>Total</b></td>
                                    <td class="text-right">${{ $model->total_price }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>

                        </table>
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