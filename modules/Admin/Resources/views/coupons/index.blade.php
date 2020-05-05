@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="{{ URL::route('admin.coupons.getCreate') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <h1>Coupons Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">List Coupons</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Coupons management</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Coupon type</th>
                            <th>Coupon code</th>
                            <th>Description</th>
                            <th>Expiry date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $date_now = date("Y-m-d H:i:s"); ?>
                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo ($item->getCouponsType != null) ? $item->getCouponsType->title : "N/A"; ?></td>
                                <td><?php echo $item->coupon_code; ?></td>
                                <td><?php echo $item->description; ?></td>
                                <td>
                                    <span class="label {{($item->expiry_date < $date_now) ? "label-danger" : "label-success"}}">
                                        <?php echo $item->expiry_date; ?>
                                    </span>
                                    
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="<?php echo URL::route('admin.coupons.getEdit', $item->id); ?>"><i class="fa fa-edit"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo URL::route('admin.coupons.delete', $item->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@stop
