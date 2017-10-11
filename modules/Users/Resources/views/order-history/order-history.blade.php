@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
            <li><a href="#">Order History</a></li>
        </ul>


        <div class="row">
            <div id="content" class="col-sm-9">
                <h1>Order History</h1>

                <?php
                if (count($model) == 0) {
                    echo "You have not made any previous orders!";
                } else {
                    ?>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <td class="text-left">Order ID</td>
                                    <td class="text-left">Order No</td>
                                    <td class="text-center">Customer</td>
                                    <td class="text-center">No. of Products</td>
                                    <td class="text-center">Status</td>
                                    <td class="text-center">Total</td>
                                    <td class="text-center">Date Added</td>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($model as $item): ?>
                                    <tr>
                                        <td class="text-left" style="vertical-align: middle">#{{ $item->id }}</td>
                                        <td class="text-left" style="vertical-align: middle"><span class="label label-default">{{ $item->order_no }}</span></td>
                                        <td class="text-center" style="vertical-align: middle"><span class="label label-success">{{ $item->user->first_name }} {{ $item->user->last_name }}</span></td>
                                        <td class="text-center" style="vertical-align: middle">{{ $item->quantity_product }}</td>
                                        <td class="text-center" style="vertical-align: middle"><span class="label label-primary">{{ $item->payment_status }}</span></td>
                                        <td class="text-center" style="vertical-align: middle">${{ $item->total_price }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $item->created_at }}</td>
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

                    <?php echo $model->render(); ?>

                <?php }//end else?>

                <div class="buttons clearfix">
                    <div class="pull-right"><a href="{{ URL::route('users.getMyAccount') }}" class="btn btn-primary">Continue</a></div>
                </div>
            </div>

            @include('users::includes.my_account_column_right')

        </div>

    </div>
</div>
@stop
