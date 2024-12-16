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
        <h1>Paid for Filehosting</h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo URL::route('articles.view', ['id' => $model->id, 'url' => $model->url_title . '.html']); ?>"><?php echo $model->title; ?></a>
            </li>
            <li>
                <a href="">Paid for: <?php echo $model->title; ?></a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Paid for: <?php echo $model->title; ?></h3>
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

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Search</label>
                                <button class="btn btn-primary form-control" type="sumit">Search</button>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Reset</label>
                                <a href="<?php echo URL::route("admin.paidFilehost.index", [ "id" => $model->id ]) ?>" class="btn btn-default form-control" type="sumit">Reset</a>
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
                            <th>Package Name</th>
                            <th>Price/unit</th>
                            <th>Unit sold</th>
                            <th>Refund</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($model_report as $key => $item): ?>
                            <?php $total = $total + $item->total_all_paid; ?>
                            <tr>
                                <td><?php echo $item->product_name; ?></td>
                                <td>$<?php echo $item->unit_price; ?></td>
                                <td><?php echo $item->total_sold; ?> </td>
                                <td><?php echo $item->total_refund; ?> </td>
                                <td>$<?php echo $item->total_all_paid; ?> </td>
                            </tr>

                        <?php endforeach; ?>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>$<?php echo $total; ?></strong></td>
                            </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>

@stop


