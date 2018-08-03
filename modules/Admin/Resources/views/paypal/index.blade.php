@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="{{ URL::route('admin.paypal.getCreate') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <h1>Paypal Account Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="">List Account</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Paypal Account</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Full Name</th>
                        <th>Money activate</th>
                        <th>Money hold</th>
                        <th>Status Limit</th>
                        <th>Status Activate</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model as $key => $item): ?>

                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $item->email; ?></td>
                            <td><?php echo $item->password; ?></td>
                            <td><?php echo $item->full_name; ?></td>
                            <td><?php echo $item->money_activate . "$"; ?></td>
                            <td><?php echo $item->money_hold . "$"; ?></td>
                            <td>
                                <span class="label {{ ($item->status != "Limit") ? "label-primary" : "label-danger"}}">
                                    <?php echo $item->status; ?>
                                </span>
                            </td>
                            <td> 
                                <span class="label {{ ($item->status_activate == "Activate") ? "label-primary" : "label-danger"}}"> 
                                    <?php echo $item->status_activate; ?>
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="<?php echo URL::route('admin.paypal.getEdit', $item->id); ?>"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-primary" title="Bạn có muốn nhận tiền từ tài khoản này không?" data-toggle="confirmation" href="<?php echo URL::route('admin.paypal.changeStatusActivate', $item->id); ?>"><i class="glyphicon glyphicon-repeat"></i></a>
                                <a class="btn btn-danger" data-toggle="confirmation" href="<?php echo URL::route('admin.paypal.delete', $item->id); ?>"><i class="glyphicon glyphicon-trash"></i></a>
                            </td>
                        </tr>

                    <?php endforeach; ?>


                </tbody>
            </table>

        </div>
    </div>
</div>
@stop
