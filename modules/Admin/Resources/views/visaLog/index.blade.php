@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <h1>Visa Payment Log</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('adminUserOrders.listOrders') }}">List Orders</a>
            </li>
            <li>
                <a>Visa payment Log</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> List News</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="well">
                <div class="row">
                    <form action="" method="get">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Buyer</label>
                                <input type="text" name="buyer" value="{{Request::get('buyer')}}" placeholder="Buyer" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Order ID</label>
                                <input type="number" name="orderId" value="{{Request::get('orderId')}}" placeholder="Order Id" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Search</label>
                                <div>
                                    <button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-filter"></i> Search</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Reset</label>
                                <div>
                                    <a type="submit" class="btn btn-default" href="<?php echo URL::route('admin.visaLog.index'); ?>">
                                        <i class="fa fa-filter"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Order ID</td>
                            <td>Buyer</td>
                            <td>Total ($<?php echo $total_price; ?>)</td>
                            <td>Status</td>
                            <td>Created at</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><a href="<?php echo URL::route('adminUserOrders.viewOrders',['id'=>$item->orderid]);?>">{{ $item->orderid }}</a></td>
                                <td>{{ $item->buyer }}</td>
                                <td>${{ $item->total }}</td>
                                <td><span class="label <?php echo ($item->status == "Transaction Success") ? "label-primary" : "label-danger"; ?>">{{ $item->status }}</span></td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php echo $model->appends(['buyer' => Request::get('buyer'), 'orderId' => Request::get('orderId')])->render(); ?>
            </div>
        </div>
    </div>
</div>
@stop