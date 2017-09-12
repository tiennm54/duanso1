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
                        if (count($model) == 0){
                            echo "You have not made any previous orders!";
                        }else{
                    ?>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <td class="text-right">Order ID</td>
                                    <td class="text-right">Order No</td>
                                    <td class="text-left">Customer</td>
                                    <td class="text-right">No. of Products</td>
                                    <td class="text-left">Status</td>
                                    <td class="text-right">Total</td>
                                    <td class="text-left">Date Added</td>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($model as $item):?>
                                    <tr>
                                        <td class="text-right">#{{ $item->id }}</td>
                                        <td class="text-right">{{ $item->order_no }}</td>
                                        <td class="text-left">{{ $item->user->first_name }} {{ $item->user->last_name }}</td>
                                        <td class="text-right">{{ $item->quantity_product }}</td>
                                        <td class="text-left">{{ $item->payment_status }}</td>
                                        <td class="text-right">${{ $item->total_price }}</td>
                                        <td class="text-left">{{ $item->created_at }}</td>
                                        <td class="text-right">
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
