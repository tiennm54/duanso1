@extends('backend.master')
@section('content')

<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">

            <a href="{{URL::route('import.getImport')}}" data-toggle="tooltip"
               class="btn btn-primary" data-original-title="Import Premium Key">
                <i class="glyphicon glyphicon-save"></i>
            </a>

            <a href="<?php echo URL::route('adminUserOrders.listOrders'); ?>" data-toggle="tooltip"
               class="btn btn-default" data-original-title="Cancel">
                <i class="fa fa-reply"></i>
            </a>

        </div>

        <h1>Orders</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">Orders</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    @include('validator.flash-message')

    @include('admin::userOrders.includes.view_order_detail')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Order #{{ $model->id }}</h3>
        </div>
        <div class="panel-body">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#list_order_product">Product</a></li>
                <li><a data-toggle="tab" href="#list_premium_key">Premium Key</a></li>
            </ul>

            <div class="tab-content">

                <div id="list_order_product" class="tab-pane fade in active">
                    <!--THONG TIN ĐƠN HÀNG-->
                    @include('admin::userOrders.includes.view_order_list_product')
                </div>

                <div id="list_premium_key" class="tab-pane fade">
                     @include('admin::userOrders.includes.view_order_premium_key')
                </div>
                
            </div>
            <!--THONG TIN SHIPPING-->
            @include('admin::userOrders.includes.view_order_billing')
            @include('admin::userOrders.includes.view_order_history')
        </div>
    </div>
</div>
@stop