@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('frontend.checkout.index') }}">Checkout</a></li>
            <li><a>Invoice</a></li>
        </ul>
        @include('validator.flash-message')
        <div class="row">
            <div id="content" class="col-sm-12">
                <div class="page-title">
                    <h1>Invoice #{{ $model->order_no }}</h1>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left" colspan="2">
                                Order Details
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left" style="width: 50%;">
                                <p>Invoice: <span style="font-weight: bold">#{{ $model->order_no }}</span></p>
                                <p>Order ID: <span style="font-weight: bold">#{{ $model->id }}</span></p>
                                <p>Created at: <span style="font-weight: bold">{{ $model->created_at }}</span></p>
                            </td>
                            <td class="text-left" style="width: 50%;">
                                <p>Orders Status: 
                                    <span class="label  <?php echo ($model->payment_status == "completed") ? "label-primary" : "label-danger"; ?>">
                                        {{ $model->payment_status }}
                                    </span>
                                </p>
                                <p>Payment Method: <span style="font-weight: bold">{{ $model->payment_type->title }}</span></p>
                                <p>Shipping Method: <span style="font-weight: bold">We will send the premium key to your order email.</span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left" style="width: 50%; vertical-align: top;">Billing Information</td>
                            <td class="text-left" style="width: 50%; vertical-align: top;">Check out with {{ $model->payment_type->title }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">
                                <p>Full name: <span style="font-weight: bold">{{ $model->first_name }} {{ $model->last_name }}</span></p>
                                <p>Email: <span style="font-weight: bold">{{ $model->email }}</span></p>
                            </td>
                            <td class="text-left">

                                <?php if ($model->payment_type->code == "PAYPAL") { ?>
                                    @include('articles::invoice.includes.checkout_paypal')
                                <?php } ?>

                                <?php if ($model->payment_type->code == "AMAZON") { ?>
                                    @include('articles::invoice.includes.checkout_amazon')
                                <?php } ?>

                                <?php if ($model->payment_type->code == "WEBMONEY") { ?>
                                    @include('articles::invoice.includes.checkout_wmz')
                                <?php } ?>

                                <?php if ($model->payment_type->code == "PERFECT_MO") { ?>
                                    @include('articles::invoice.includes.checkout_perfect')
                                <?php } ?>

                                <?php if ($model->payment_type->code == "BONUS") { ?>
                                    @include('articles::invoice.includes.checkout_perfect')
                                <?php } ?>

                                <?php if ($model->payment_type->code == "BANK-TRANSFER") { ?>
                                    @include('articles::invoice.includes.checkout_banktransfer')
                                <?php } ?>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="page-title">
                    <h1>Your Products</h1>
                </div>
                <div class="tab-content">
                    <div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-left">Product Name</td>
                                        <td class="text-left">Model</td>
                                        <td class="text-right">Quantity</td>
                                        <td class="text-right">Unit Price</td>
                                        <td class="text-right">Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($model_order) == 0): ?>
                                        <tr>
                                            <td class="text-left" colspan="5">Your shopping cart is empty!</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if (count($model_order) > 0): ?>
                                        <?php foreach ($model_order as $item): ?>
                                            <tr>
                                                <td class="text-left">{{ $item->articles_type->title }}</td>
                                                <td class="text-left">{{ $item->articles_type->getArticles->title }}</td>
                                                <td class="text-right">{{ $item->quantity }}</td>
                                                <td class="text-right">${{ $item->price_order }}</td>
                                                <td class="text-right">${{ $item->total_price }}</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right"><b>Sub-Total</b></td>
                                        <td class="text-right">${{ $model->sub_total }}</td>

                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right"><b>Chargers {{ $model->payment_type->title }}</b></td>
                                        <td class="text-right">${{ $model->payment_charges }}</td>

                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right"><b>Used bonus</b></td>
                                        <td class="text-right">${{ $model->used_bonus }}</td>

                                    </tr>

                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-right"><b>Total</b></td>
                                        <td class="text-right">${{ $model->total_price }}</td>

                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop