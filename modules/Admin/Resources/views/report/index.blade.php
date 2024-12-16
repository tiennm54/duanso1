<!--
    --------------------------Report page----------------------------
-->

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
        <h1>REPORT</h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo URL::route("paymentType.index"); ?>">Payment Type</a>
            </li>
            <li>
                <a href="">Report</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Report Order</h3>
        </div>
        <div class="panel-body">



            <div class="well">
                <form action="" method="get">
                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Payment Type</label>
                                <select name="paymentType" class="form-control" id="paymentTypeId">   
                                    <?php foreach ($model_type as $item): ?>
                                        <option value="<?php echo $item->code; ?>" <?php echo ($item->code == "PAYPAL") ? "selected" : ""; ?>><?php echo $item->title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Date</label>
                                <select name="dateSelect" class="form-control" id="dateSelectId">   
                                    <option value="Day">Day</option>
                                    <option value="Month">Month</option>
                                    <option value="Year">Year</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-2">
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
                        <div class="col-sm-2">
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

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Search</label>
                                <button class="btn btn-primary form-control" type="sumit">Search</button>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Reset</label>
                                <a href="<?php echo URL::route("admin.report.index") ?>" class="btn btn-default form-control" type="sumit">Reset</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>

        <div class="panel-body">
            @include('validator.flash-message')
            <div class="panel-heading">
                <h2 class="panel-title">
                    <i class="fa fa-list"></i>
                    Kết quả tìm kiếm cho: <strong><?php echo $model_type_select->title; ?></strong> theo từng: <strong><?php echo (app('request')->input('dateSelect')) ? app('request')->input('dateSelect') : "Day"; ?></strong>
                </h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Money Total</th>
                            <th>Order Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>

                            <tr>
                                <td><?php echo $item->my_date; ?></td>
                                <td>$<?php echo $item->total_price; ?></td>
                                <td><?php echo $item->total_count; ?> </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>

@stop

