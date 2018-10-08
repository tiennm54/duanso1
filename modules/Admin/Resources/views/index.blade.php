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
                <div class="tile-heading">Total Paid</div>
                <div class="tile-body"><i class="fa fa-credit-card"></i>
                    <h2 class="pull-right">{{ count($model_order_paid)}}</h2>
                </div>
                <div class="tile-footer"><a href="{{ URL::route('adminUserOrders.listOrders') }}">View more...</a></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
                <div class="tile-heading">Total user locked</div>
                <div class="tile-body"><i class="glyphicon glyphicon-remove-sign"></i>
                    <h2 class="pull-right">{{count($model_user_lock)}}</h2>
                </div>
                <div class="tile-footer"><a href="{{ URL::route('admin.userManagement.index') }}">View more...</a></div>
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
        <div class="col-lg-3 col-md-3 col-sm-6"><div class="tile">
                <div class="tile-heading">Total money</div>
                <div class="tile-body"><i class="glyphicon glyphicon-xbt"></i>
                    <h3 class="pull-right">
                        {{ $data_money["money"] }}$
                    </h3>
                </div>
                <div class="tile-footer">
                    {{ $data_money["money"] }}$ / {{$data_money['money_order']}}$
                </div>
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

        <!--DANH SACH ORDER PENDING-->
        <div class="col-lg-6 col-md-12 col-sm-12"><div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order pending</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Email</td>
                                <td>Date</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($model_order_pending) == 0): ?>
                                <tr>
                                    <td colspan="4">
                                        Không có bản ghi nào!
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($model_order_pending as $item): ?>
                                <tr>
                                    <td>
                                        <a href="{{ URL::route('adminUserOrders.viewOrders', ["id" => $item->id])}}">{{$item->id}}</a>
                                    </td>
                                    <td>
                                        <a href="{{ URL::route('admin.userManagement.view', ["id" => $item->users_id])}}">{{$item->email}}</a>
                                    </td>
                                    <td>
                                        <?php
                                        $date = date_create($item->created_at);
                                        echo date_format($date, "d/m/Y");
                                        ?>
                                    </td>
                                    <td>{{$item->total_price}}$</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            {!! $model_order_pending->render() !!}
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
                                <td>Date</td>
                                <td>Total</td>
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
                                    <td>
                                        <?php
                                        $date = date_create($item->created_at);
                                        echo date_format($date, "d/m/Y");
                                        ?>
                                    </td>
                                    <td>{{$item->total_price}}$</td>
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
        <div class="col-lg-6 col-md-12 col-sm-12" style="margin-top: 20px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Completed (Today: <?php echo count($model_order_completed); ?> order)</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Invoice</td>
                                <td>Email</td>
                                <td>Full Name</td>
                                <td>Date completed</td>
                                <td>Total</td>
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
                                        <?php
                                        echo $item->payment_date;
                                        ?>
                                    </td>
                                    <td>{{$item->total_price}}$</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!--DANH SACH USER BỊ KHÓA-->
        <div class="col-lg-6 col-md-12 col-sm-12" style="margin-top: 20px">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> User locked</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Money account</td>
                                <td>Money bonus</td>
                                <td>Money spending</td>
                                <td>Total money</td>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($model_user_lock) == 0): ?>
                                <tr>
                                    <td colspan="6">
                                        Không có bản ghi nào!
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($model_user_lock as $item): ?>
                                <?php
                                $money_bonus = $item->getMoneyBonus();
                                $money_spending = $item->getSpendingMoney();
                                $total_money = $money_bonus - $money_spending;
                                ?>
                                <tr>
                                    <td>
                                        <a href="{{ URL::route('admin.userManagement.view', ["id" => $item->id])}}">{{$item->full_name}}</a>
                                    </td>
                                    <td>
                                        <a href="{{ URL::route('admin.userManagement.view', ["id" => $item->id])}}">{{$item->email}}</a>
                                    </td>
                                    <td>{{$item->getMoneyAccountCurrent()}}$</td>
                                    <td>{{ ($money_bonus) ? $money_bonus : 0}}$</td>
                                    <td>{{ ($money_spending) ? $money_spending : 0}}$</td>
                                    <td>{{$total_money}}$</td>
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