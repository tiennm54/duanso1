@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
            <li><a href="">Home</a></li>
            <li><a href="">Dashboard</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
                <div class="tile-heading">Total Paid / Day</div>
                <div class="tile-body"><i class="glyphicon glyphicon-shopping-cart"></i>
                    <h2 class="pull-right">{{ count($model_order_paid)}}</h2>
                </div>
                <div class="tile-footer"><a href="{{ URL::route('adminUserOrders.listOrders') }}">View more...</a></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
                <div class="tile-heading">Total Completed / Day</div>
                <div class="tile-body"><i class="glyphicon glyphicon-shopping-cart"></i>
                    <h2 class="pull-right">{{ count($model_order_completed) }}</h2>
                </div>
                <div class="tile-footer"><a href="{{ URL::route('adminUserOrders.listOrders') }}">View more...</a></div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
                <div class="tile-heading">Total money / Day</div>
                <div class="tile-body"><i class="glyphicon glyphicon-usd"></i>
                    <h2 class="pull-right">
                        {{ $data_money["money"] }}
                    </h2>
                </div>
                <div class="tile-footer">
                    {{ $data_money["money"] }}$ / {{$data_money['money_order']}}$
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
                <div class="tile-heading">Total user</div>
                <div class="tile-body"><i class="fa fa-users"></i>
                    <h2 class="pull-right">{{ $count_user }}</h2>
                </div>
                <div class="tile-footer"><a href="{{ URL::route('admin.userManagement.index') }}">View more...</a></div>
            </div>
        </div>
        
    </div>
</div>

<!--
Danh sách order pending 
Danh sách order paid
Danh sách user locked
Danh sách user sử dụng thanh toán bonus trong tuần
-->
<div class="container-fluid">
    <div class="row">

        <!--DANH SACH TONG SO SAN PHAM MUA TRONG NGAY-->
        <div class="col-lg-6 col-md-12 col-sm-12"><div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Total products Purchased</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Invoice</td>
                                <td>Image</td>
                                <td>Title</td>
                                <td>Quantity</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($model_buyProduct) == 0): ?>
                                <tr>
                                    <td colspan="4">
                                        Không có bản ghi nào!
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($model_buyProduct as $item): ?>
                                <tr>
                                    <td>
                                        <a href="{{ URL::route('adminUserOrders.viewOrders', ["id" => $item->id])}}">{{$item->id}}</a>
                                    </td>
                                    <td>
                                        <?php if($item->image) {?>
                                            <img src="{{ $item->image }}" style="width: 100px"/>
                                        <?php }else{
                                            echo "N/A";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $item->title; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $item->total_quantity; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            {!! $model_buyProduct->render() !!}
        </div>

        <!--DANH SACH ORDER PAID-->
        <div class="col-lg-6 col-md-12 col-sm-12"><div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order paid</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Invoice</td>
                                <td>Email</td>
                                <td>Status</td>
                                <td>Total</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($model_order_paid) == 0): ?>
                                <tr>
                                    <td colspan="4">
                                        Không có bản ghi nào!
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($model_order_paid as $item): ?>
                                <tr>
                                    <td>
                                        <a href="{{ URL::route('adminUserOrders.viewOrders', ["id" => $item->id])}}">{{$item->id}}</a>
                                    </td>
                                    <td>
                                        <a href="{{ URL::route('admin.userManagement.view', ["id" => $item->users_id])}}">{{$item->email}}</a>
                                    </td>
                                    <td>
                                        <span class="<?php echo ($item->payment_status == 'paid') ? 'label label-primary' : 'label label-danger' ?>">
                                            <?php echo $item->payment_status; ?>
                                        </span>
                                    </td>
                                    <td>{{$item->total_price}}$</td>
                                     <td>
                                        <?php
                                            echo $item->created_at->timezone('Asia/Ho_Chi_Minh');
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            {!! $model_order_paid->render() !!}
        </div>

    </div>
    <div class="row">
        <!--DANH SACH ORDER COMPLETED-->
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 20px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Completed (Today: <?php echo count($model_order_completed); ?> order)</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Invoice ID</td>
                                <td>Email</td>
                                <td>Full Name</td>
                                <td>Country</td>
                                <td>Product</td>
                                <td>Total</td>
                                <td>Date completed</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($model_order_completed) == 0): ?>
                                <tr>
                                    <td colspan="4">
                                        Không có bản ghi nào!
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($model_order_completed as $item): ?>
                                <tr>
                                    <td>
                                        <a href="{{ URL::route('adminUserOrders.viewOrders', ["id" => $item->id])}}">{{$item->id}}</a>
                                    </td>
                                    <td>
                                        <a href="{{ URL::route('admin.userManagement.view', ["id" => $item->users_id])}}">{{$item->email}}</a>
                                    </td>
                                    <td>
                                        <?php echo $item->first_name . " " . $item->last_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->user_info; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($item->orders_detail as $product): ?>
                                            {{ $product->articles_type->title }} ({{ $product->quantity }}) <br>
                                        <?php endforeach; ?>
                                    </td>
                                    
                                    <td>{{$item->total_price}}$</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->payment_date)
                                            ->timezone('Asia/Ho_Chi_Minh')
                                            ->format('Y-m-d H:i:s') }}
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@stop