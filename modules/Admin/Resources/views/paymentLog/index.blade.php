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
        <h1>Log VISA Stripe </h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo URL::route("paymentType.index"); ?>">Payment Type</a>
            </li>
            <li>
                <a href="">Log STRIPE</a>
            </li>
        </ul>
    </div>
</div>

<!--
    --------------------------PAYMENT LOG INDEX----------------------------
-->

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Stripe VISA history</h3>
        </div>
        <div class="panel-body">



            <div class="well">
                <form action="" method="get">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class='input-group datetimepicker'>
                                    <input type='text' value="{{ app('request')->input('start_date') }}" class="form-control" name="start_date" placeholder="Start Date..."/>
                                    <span class="input-group-addon fa-date">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <div class='input-group datetimepicker'>
                                    <input type='text' value="{{ app('request')->input('end_date') }}" class="form-control" name="end_date" placeholder="End Date..."/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </span>
                                </div>
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
                                <a href="<?php echo URL::route("admin.paymentLog.index", ['id' => $model_payment_type->id]); ?>" class="btn btn-default form-control" type="sumit">Reset</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>


            <div class="row">   
                <div class="col-sm-6">
                    <form action="<?php echo URL::route('admin.paymentLog.postCreate', ['id' => $model_payment_type->id]); ?>" method="post" enctype="multipart/form-data">                        
                        <div class="col-sm-5">                            
                            <div class="form-group">                                
                                <label class="control-label">MONEY RECEIVED FROM STRIPE</label>                                
                                <input type="number" step="any" class="form-control border-input" name="money_received" required>                            
                            </div>                        
                        </div>                       
                        <div class="col-sm-1">                            
                            <div class="form-group">                                
                                <label class="control-label">Create</label>                                
                                <div>                                    
                                    <button type="submit" class="btn btn-primary">Create</button>                                
                                </div>                            
                            </div>                        
                        </div>               
                    </form> 
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label">Tiền nhận vào từ khách hàng</label>
                        <input type="number" step="any" class="form-control border-input" value="<?php echo $model_payment_type->money_total; ?>">    
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label" style="color: blue"><strong>Tiền đã rút về</strong></label>
                        <input type="number" step="any" class="form-control border-input" value="<?php echo $count_total_money; ?>">    
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label">Tiền chưa rút</label>
                        <input type="number" step="any" class="form-control border-input" value="<?php echo $model_payment_type->money_current; ?>">    
                    </div>
                </div>

            </div>      

        </div>

        <div class="panel-body">
            @include('validator.flash-message')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Money</th>
                            <th class="text-center">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>

                            <tr>
                                <td><?php echo $key + 1; ?></td>

                                <td class="text-center"><?php echo $item->created_at; ?></td>
                                <td class="text-center"><?php echo $item->money_received; ?></td>
                                <td class="text-center">
                                    <span class="label {{ ($item->status == 1) ? "label-primary" : "label-danger" }}">{{ ($item->status == 1) ? "Success" : "Hold" }}</span>
                                </td>
                                <td>
                                    <a data-toggle="modal" 
                                       data-target="#editPaymentLogId" onclick="editPaymentLog('<?php echo $item->id; ?>', '<?php echo $item->money_received; ?>', '<?php echo $item->status; ?>')" class="btn btn-primary">
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
                'start_date' => Request::get('start_date'),
                'end_date' => Request::get('end_date')])->render();
            ?>
        </div>
    </div>
</div>



<div id="editPaymentLogId" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit STRIPE Log</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="<?php echo URL::route('admin.paymentLog.postEdit'); ?>">
                    <fieldset>
                        <input id="payment_log_id" name="payment_log_id" type="hidden"/>
                        <input id="money_received_old_id" name="money_received_old" type="hidden"/>

                        <div class="form-group required">
                            <label class="col-sm-2 control-label">Money</label>
                            <div class="col-sm-9">
                                <input id="money_received_id" class="form-control" type="number" step="any" name="money_received" required/>
                            </div>
                        </div>


                        <div class="form-group required">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-9">
                                <select name="status" class="form-control" id="statusId">   
                                    <option value="1">Success</option>
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
    function editPaymentLog(id, money, status) {
        console.log(money);
        $("#payment_log_id").val(id);
        $("#money_received_old_id").val(money);
        $("#money_received_id").val(money);
        $("#statusId").val(status);
    }
</script>

@stop
