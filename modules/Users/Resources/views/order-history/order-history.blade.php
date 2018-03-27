@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
            <li><a href="{{ URL::route('users.orderHistory') }}">Order History</a></li>
        </ul>
        <?php
        $searchOrderNo = app('request')->input('searchOrderNo');
        $searchStatus = app('request')->input('searchStatus');
        ?>

        <div class="row">
            <div id="content" class="col-sm-9">
                <form class="form-inline" method="GET">
                    <input type="text" class="form-control" name="searchOrderNo" placeholder="Order No" value="{{ $searchOrderNo }}">
                    <div class="input-group">
                        <select class="form-control" name="searchStatus">
                            <option value="" selected>Choose status...</option>
                            <option value="pending" <?php echo ($searchStatus == "pending") ? "selected" : "" ?>>Pending</option>
                            <option value="paid" <?php echo ($searchStatus == "paid") ? "selected" : "" ?>>Paid</option>
                            <option value="refund" <?php echo ($searchStatus == "refund") ? "selected" : "" ?>>Refund</option>
                            <option value="completed" <?php echo ($searchStatus == "completed") ? "selected" : "" ?>>Completed</option>
                            <option value="cancel" <?php echo ($searchStatus == "cancel") ? "selected" : "" ?>>Cancel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Order History
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-left">Order No</td>
                                    <td class="text-center">Customer</td>
                                    <td class="text-center">No. of Products</td>
                                    <td class="text-center">Status</td>
                                    <td class="text-center">Total</td>
                                    <td class="text-center">Date Added</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($model) == 0) { ?>
                                    <tr>
                                        <td colspan="7">Your wish list is empty.</td>
                                    </tr>
                                <?php } ?>
                                <?php foreach ($model as $item): ?>
                                    <tr>
                                        <td class="text-left" style="vertical-align: middle"><span class="label label-default">{{ $item->order_no }}</span></td>
                                        <td class="text-center" style="vertical-align: middle"><span class="label label-success">{{ $item->user->first_name }} {{ $item->user->last_name }}</span></td>
                                        <td class="text-center" style="vertical-align: middle">{{ $item->quantity_product }}</td>
                                        <td class="text-center" style="vertical-align: middle"><span class="label {{ ($item->payment_status == "completed") ? "label-primary" : "label-danger"}} ">{{ $item->payment_status }}</span></td>
                                        <td class="text-center" style="vertical-align: middle">${{ $item->total_price }}</td>
                                        <td class="text-center" style="vertical-align: middle"><span class="label label-default">{{ $item->created_at }}</span></td>
                                        <td class="text-center" style="vertical-align: middle">
                                            <a href="{{ URL::route('users.orderHistoryView', ["id" => $item->id , "order_no" => $item->order_no ]) }}" data-toggle="tooltip" title="View Detail" class="btn btn-primary" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php echo $model->render(); ?>



                <div class="buttons clearfix">
                    <div class="pull-right"><a href="{{ URL::route('users.getMyAccount') }}" class="btn btn-primary">Continue</a></div>
                </div>
            </div>

            @include('users::includes.my_account_column_right')

        </div>

    </div>
</div>
@stop
