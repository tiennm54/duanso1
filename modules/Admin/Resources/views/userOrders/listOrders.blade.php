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

                        <div class="col-sm-3">

                            <div class="form-group">
                                <label class="control-label">Order ID</label>
                                <input type="text" name="order_id" placeholder="Order ID" class="form-control"
                                       value="{{ app('request')->input('order_id') }}">
                            </div>

                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" name="email" placeholder="Email orders"
                                       class="typeahead form-control" value="{{ app('request')->input('email')}}">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Full Name</label>
                                <input type="text" name="full_name" placeholder="Full Name"
                                       class="typeahead form-control" value="{{ app('request')->input('full_name')}}">
                            </div>
                        </div>


                        <div class="col-sm-3">
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

                                    <option value="cancel" {{ (app('request')->input('payment_status') == "cancel") ? "selected" : "" }}>
                                        Cancel
                                    </option>

                                    <option value="refund" {{ (app('request')->input('payment_status') == "refund") ? "selected" : "" }}>
                                        Refund
                                    </option>

                                </select>
                            </div>
                        </div>


                        <div class='col-sm-3'>
                            <div class="form-group">
                                <label class="control-label">Used bonus</label>
                                <select name="used_bonus" class="form-control">
                                    <option value="">Select type...</option>
                                    <option value="yes" {{ (app('request')->input('used_bonus') == "yes") ? "selected" : "" }} >
                                        Yes
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class='col-sm-3'>
                            <div class="form-group">
                                <label class="control-label">Payment Type</label>
                                <select name="payment_type" class="form-control">
                                    <option value="">Select payment type...</option>
                                    <?php foreach ($model_payment_type as $item): ?>
                                        <option value="{{ $item->id }}" {{ (app('request')->input('payment_type') == $item->id) ? "selected" : "" }} >
                                            {{$item->title}}
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Search</label>
                                <button type="submit" class="btn btn-primary form-control">Search</button>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Reset</label>
                                <a href="{{ URL::route('adminUserOrders.listOrders') }}" class="btn btn-primary form-control">Reset</a>
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
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Used bonus</th>
                            <th>Total</th>
                            <th>Payment</th>
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
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->full_name }}</td>
                                    <td>
                                        <span class="label {{ ($item->used_bonus == 0) ? "label-primary" : "label-danger" }}">{{ ($item->used_bonus) ? $item->used_bonus : 0  }}$</span>
                                    </td>
                                    <td>{{ $item->total_price }}$</td>
                                    <td>
                                        <span class="label {{($item->payment_type->code == "BONUS") ? "label-danger" : "label-success"}}">{{ $item->payment_type->title }}</span>

                                    </td>
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
            <?php
            echo $model->appends(
                    [
                        'order_id' => Request::get('order_id'),
                        'email' => Request::get('email'),
                        'payment_status' => Request::get('payment_status'),
                        'used_bonus' => Request::get('used_bonus'),
                        'payment_type' => Request::get('payment_type'),
            ])->render();
            ?>

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
