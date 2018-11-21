@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a data-toggle="tooltip" class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
            </a>
            <a href="<?php echo URL::route('admin.paypal.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Back">
                <i class="fa fa-reply"></i>
            </a>
        </div>
        <h1>Receive Paypal</h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo URL::route("admin.paypal.index"); ?>">List Account</a>
            </li>
            <li>
                <a>Receive paypal history</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Receive paypal: <?php echo (isset($model_paypal) && $model_paypal != null) ? $model_paypal->email : ""; ?></h3>
        </div>
        <div class="panel-body">
            <?php if (isset($model_paypal) && $model_paypal != null) { ?>
                <h3>Total activate: $<?php echo $model_paypal->money_activate; ?></h3>
                <h3>Total hold: $<?php echo $model_paypal->money_hold; ?></h3>
            <?php } ?>
            <div class="well">
                <form action="" method="get">
                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Email receive</label>
                                <input type="text" name="paypal_account_email" placeholder="Email Receive" class="form-control"
                                       value="{{ app('request')->input('paypal_account_email') }}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Email paid</label>
                                <input type="text" name="email_paid" placeholder="Email paid" class="form-control"
                                       value="{{ app('request')->input('email_paid') }}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Order No</label>
                                <input type="text" name="order_no" placeholder="Order no" class="form-control"
                                       value="{{ app('request')->input('order_no') }}">
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Status receive</label>
                                <select class="form-control" name="status_receive">
                                    <option value="">Select status</option>
                                    <option value="pending" {{ (app('request')->input('status_receive') == "pending") ? "selected" : "" }}>Pending</option>
                                    <option value="echeck" {{ (app('request')->input('status_receive') == "echeck") ? "selected" : "" }}>eCheck</option>
                                    <option value="refund" {{ (app('request')->input('status_receive') == "refund") ? "selected" : "" }}>Refund</option>
                                    <option value="completed" {{ (app('request')->input('status_receive') == "completed") ? "selected" : "" }}>Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Search</label>
                                <button class="btn btn-primary form-control" type="sumit">Search</button>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Reset</label>
                                <a href="<?php echo URL::route("admin.paypalReceive.index"); ?>" class="btn btn-primary form-control" type="sumit">Reset</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="panel-body">
            @include('validator.flash-message')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Email receive</th>
                            <th>Email paid</th>
                            <th>Order Id</th>
                            <th>Total</th>
                            <th>Total Receive</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>

                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <a href="<?php echo URL::route("admin.paypalReceive.index", ["id" => $item->getPaypalAccount->id]); ?>">
                                        <?php echo $item->getPaypalAccount->email; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $item->email_paid; ?>
                                </td>
                                <td><a href="<?php echo URL::route('adminUserOrders.viewOrders', ['id' => $item->order_id]); ?>">#<?php echo $item->getOrder->order_no; ?></a></td>
                                <td><?php echo $item->total; ?></td>
                                <td><?php echo $item->total_receive . "$"; ?></td>
                                <td>
                                    <span class="label {{ ($item->status == "completed") ? "label-primary" : "label-danger"}}">
                                        <?php echo $item->status; ?>
                                    </span>
                                </td>
                                <td><?php echo $item->created_at; ?></td>
                                <td>
                                    <a data-toggle="modal" 
                                       data-target="#editPaypalReceiveId" onclick="editPaypalReceive('<?php echo $item->id; ?>', '<?php echo $item->total_receive; ?>', '<?php echo $item->status; ?>')" class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
            echo $model->appends([
                'paypal_account_email' => Request::get('paypal_account_email'),
                'email_paid' => Request::get('email_paid'),
                'order_no' => Request::get('order_no'),
                'status_receive' => Request::get('status_receive'),
            ])->render();
            ?>
        </div>
    </div>
</div>



<div id="editPaypalReceiveId" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit status receive</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="<?php echo URL::route('admin.paypalReceive.editPaypalReceive'); ?>">
                    <fieldset>
                        <input id="paypal_account_id" name="paypal_receive_id" type="hidden"/>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <select id="status_receive" class="form-control" name="status">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="refund">Refund</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="buttons clearfix">
                        <div class="pull-right">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editPaypalReceive(id, money, status) {
        $("#paypal_account_id").val(id);
        $("#status_receive").val(status);
    }
</script>

@stop
