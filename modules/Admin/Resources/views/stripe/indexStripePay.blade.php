@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
           
            <a href="<?php echo URL::route('admin.stripe.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Back">
                <i class="fa fa-reply"></i>
            </a>
        </div>
        
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo URL::route("admin.stripe.index"); ?>">List Account</a>
            </li>
            <li>
                <a>Pay stripe history</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Pay stripe history</h3>
        </div>
        <div class="panel-body">
            <div class="well">
                <form action="" method="get">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Pay Stripe</label>
                                <input type="text" name="stripe_account_url" placeholder="Stripe Website" class="form-control"
                                       value="{{ app('request')->input('stripe_account_url') }}">
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
                                <a href="<?php echo URL::route("admin.stripe.indexStripePay"); ?>" class="btn btn-default form-control" type="sumit">Reset</a>
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
                            <th>Stripe Account</th>
                            <th>Money</th>
                            <th>Status</th>
                            <th>Date pay</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>

                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo $item->stripe_account_url; ?>
                                </td>
                                <td><?php echo $item->money_po . "$"; ?></td>
                                <td>
                                    <span class="label {{ ($item->status == 1) ? "label-primary" : "label-danger"}}">
                                        <?php 
                                            if($item->status == 1){
                                                echo "Completed";
                                            }else{
                                                echo "Hold";
                                            }
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo $item->date_pay; ?></td>
                                <td>
                                    <a data-toggle="modal" 
                                       data-target="#editStripePayId" onclick="editStripePay('<?php echo $item->id; ?>', '<?php echo $item->money_po; ?>', '<?php echo $item->status; ?>')" class="btn btn-primary">
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
                'stripe_account_url' => Request::get('stripe_account_url')
                ])->render();
            ?>
        </div>
    </div>
</div>



<div id="editStripePayId" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Stripe Pay</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="<?php echo URL::route('admin.stripe.editStripePay'); ?>">
                    <fieldset>
                        <input id="stripe_pay_id" name="stripe_pay_id" type="hidden"/>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Money</label>
                            <div class="col-sm-9">
                                <input id="money_pay" class="form-control" type="number" step="any" name="money" required/>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <select id="status_pay" class="form-control" name="status">
                                    <option value="1">Completed</option>
                                    <option value="0">Hold</option>
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
    function editStripePay(id, money, status) {
        $("#stripe_pay_id").val(id);
        $("#money_pay").val(money);
        $("#status_pay").val(status);
    }
</script>

@stop
