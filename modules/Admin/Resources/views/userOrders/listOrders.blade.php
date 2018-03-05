@extends('backend.master')
@section('content')

<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">

            <a href="<?php echo URL::route('articles.index'); ?>" data-toggle="tooltip" title=""
               class="btn btn-default" data-original-title="Cancel">
                <i class="fa fa-reply"></i>
            </a>

        </div>
        <h1>User Orders</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">Orders</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Order List</h3>

        </div>
        <div class="panel-body">
            <div class="well">
                <form action="{{ URL::route('adminUserOrders.listOrders') }}" method="get"
                      enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-sm-4">

                            <div class="form-group">
                                <label class="control-label">Order ID</label>
                                <input type="text" name="order_id" placeholder="Order ID" class="form-control"
                                       value="{{ app('request')->input('order_id') }}">
                            </div>

                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" name="email" placeholder="Email orders"
                                       class="typeahead form-control" value="{{ app('request')->input('email')}}">
                            </div>
                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <select name="payment_status" class="form-control">
                                    <option value="">Select status</option>
                                    <option value="pending" {{ (app('request')->input('payment_status') == "pending") ? "selected" : "" }} >
                                        Pending
                                    </option>
                                    <option value="paid" {{ (app('request')->input('payment_status') == "paid") ? "selected" : "" }}>
                                        Paid
                                    </option>

                                    <option value="completed" {{ (app('request')->input('payment_status') == "completed") ? "selected" : "" }}>
                                        Completed
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class='col-sm-4'>
                            <div class="form-group">
                                <div class='input-group date datetimepicker'>
                                    <input type='text' class="form-control" name="start_created_at" placeholder="Start Date Added" value="{{ app('request')->input('start_created_at')}}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class='col-sm-4'>
                            <div class="form-group">
                                <div class='input-group date datetimepicker'>
                                    <input type='text' class="form-control" name="end_created_at" placeholder="End Date Added" value="{{ app('request')->input('end_created_at')}}"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-4">
                            <div class="form-group ">
                                <button type="submit" class="btn btn-primary pull-right">Search</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Invoice</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php if (count($model) == 0) { ?>
                            <tr>
                                <td colspan="8">Không có order nào! Cố gắng lên Minh Tiến</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($model as $item): ?>
                                <tr>
                                    <td>#{{ $item->id }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="<?php echo URL::route('adminUserOrders.viewOrders', ['id' => $item->id]); ?>">
                                            #{{ $item->order_no }}
                                        </a>
                                    </td>
                                    <td>{{ $item->total_price }}$</td>
                                    <td>
                                        <span class="label {{($item->payment_type->code == "BONUS") ? "label-danger" : "label-success"}}">{{ $item->payment_type->title }}</span>
                                        
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->payment_status }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td><a class="btn btn-primary"
                                           href="<?php echo URL::route('adminUserOrders.viewOrders', ['id' => $item->id]); ?>"><i
                                                class="fa fa-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php echo $model->render(); ?>

        </div>
    </div>
</div>


<script type="text/javascript">
    var path = "{{ URL::route('adminUserOrders.autoCompleteEmail') }}";
    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.get(path, {query: query}, function (data) {
                return process(data);
            });
        },
    });
</script>

@stop
