@extends('backend.master')
@section('content')


    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <a href="<?php  echo URL::route('adminUserOrders.viewOrders', ['id' => $model->id]); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>
            </div>

            <h1>Add Premium Key</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo URL::route('articles.index'); ?>">Home</a>
                </li>

                <li>
                    <a href="<?php  echo URL::route('adminUserOrders.viewOrders', ['id' => $model_order_detail->user_orders_id]); ?>">User Order</a>
                </li>

                <li>
                    <a href="">Add Premium Key</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> {{ $model_product->title }}</h3>
            </div>
            <div class="panel-body">

                @include('admin::userOrders.includes.orderInformation')


                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#add-key">Add Premium Key</a></li>
                </ul>

                <div class="tab-content">
                    <div id="add-key" class="tab-pane fade in active">
                        @include('validator.flash-message')
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control border-input" placeholder="Điền key vào đây" name="premium_key" required/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-original-title="Add Product Key"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order no</th>
                                    <th>Product</th>
                                    <th>Key</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Received User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($model_key) == 0):?>
                                <tr>
                                    <td colspan="7">Không có key nào cho sản phẩm này!</td>
                                </tr>
                                <?php endif;?>
                                <?php foreach ($model_key as $item):?>
                                <tr>
                                    <td>{{ ($item->getUserOrders) ?  $item->getUserOrders->order_no : "N/A"}}</td>
                                    <td>{{ $item->getProduct->title }}</td>
                                    <td>{{ $item->key }}</td>
                                    <td class="{{ ($item->status == "active" ? "status-green" : "status-red") }}">{{ $item->status }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ ($item->user_email) ?  $item->user_email : "Chưa được nhận" }}</td>
                                    <td>
                                        <form method="post" action="{{ URL::route('adminUserOrders.deletePremiumKey',['id'=>$item->id]) }}">
                                            <button class="btn btn btn-danger" data-toggle="confirmation">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .status-green{
            color: blue;
        }
        .status-red{
            color: red;
        }
    </style>
@stop
