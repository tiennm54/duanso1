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
        <h1>Sell Paypal<?php echo (isset($model_paypal) && $model_paypal != null) ? $model_paypal->email : ""; ?></h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo URL::route("admin.paypal.index"); ?>">List Account</a>
            </li>
            <li>
                <a>Sell paypal history</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Sell paypal history</h3>
        </div>
        <div class="panel-body">
            <div class="well">
                <form action="" method="get">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Sell Paypal</label>
                                <input type="text" name="paypal_account_email" placeholder="Paypal account" class="form-control"
                                       value="{{ app('request')->input('paypal_account_email') }}">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Email buyer</label>
                                <input type="text" name="email_buyer" placeholder="Email buyer" class="form-control"
                                       value="{{ app('request')->input('email_buyer') }}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Search</label>
                                <button class="btn btn-primary form-control" type="sumit">Search</button>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Reset</label>
                                <a href="<?php echo URL::route("admin.sellPaypal.index"); ?>" class="btn btn-default form-control" type="sumit">Reset</a>
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
                            <th>Paypal Account</th>
                            <th>Email Buyer</th>
                            <th>Buyer</th>
                            <th>Money</th>
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
                                    <a href="<?php echo URL::route("admin.sellPaypal.index", ["id" => $item->getPaypalAccount->id]); ?>">
                                        <?php echo $item->getPaypalAccount->email; ?>
                                    </a>
                                </td>
                                <td><?php echo $item->email_buyer; ?></td>
                                <td><?php echo $item->name_buyer; ?></td>
                                <td><?php echo $item->money . "$"; ?></td>
                                <td>
                                    <span class="label {{ ($item->status == "completed") ? "label-primary" : "label-danger"}}">
                                        <?php echo $item->status; ?>
                                    </span>
                                </td>
                                <td><?php echo $item->created_at; ?></td>
                                <td>
                                    <a data-toggle="modal" 
                                       data-target="#editPaypalSellId" onclick="editPaypalSell('<?php echo $item->id; ?>', '<?php echo $item->money; ?>', '<?php echo $item->status; ?>')" class="btn btn-primary">
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
                'email_buyer' => Request::get('email_buyer')])->render();
            ?>
        </div>
    </div>
</div>



<div id="editPaypalSellId" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit paypal sell</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="<?php echo URL::route('admin.sellPaypal.editPaypalSell'); ?>">
                    <fieldset>
                        <input id="paypal_account_id" name="paypal_sell_id" type="hidden"/>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Money</label>
                            <div class="col-sm-9">
                                <input id="money_sell" class="form-control" type="number" step="any" name="money" required/>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <select id="status_sell" class="form-control" name="status">
                                    <option value="completed">Completed</option>
                                    <option value="pending">Pending</option>
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
    function editPaypalSell(id, money, status) {
        $("#paypal_account_id").val(id);
        $("#money_sell").val(money);
        $("#status_sell").val(status);
    }
</script>

@stop
