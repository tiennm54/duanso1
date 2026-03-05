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
                    <h1>Invoice #{{ $model->id }}</h1>
                </div>
                <div class="tab-content">
                    <div>
                        <div class="table-responsive">
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
                                            <p>Invoice: <span style="font-weight: bold">#{{ $model->id }}</span></p>
                                            <p>Order ID: <span style="font-weight: bold">#{{ $model->id }}</span></p>
                                            <p>Created at: <span style="font-weight: bold">{{ $model->created_at }}</span></p>
                                        </td>
                                        <td class="text-left" style="width: 50%;">
                                            <p>Orders Status: 
                                                <span class="label  <?php echo ($model->payment_status == "completed" || $model->payment_status == "paid") ? "label-success" : "label-danger"; ?>">
                                                    {{ $model->payment_status }}
                                                </span>
                                            </p>
                                            <p>Payment Method: <span style="font-weight: bold">{{ $model->payment_type->title }}</span></p>
                                            <p>Shipping Method: <span style="font-weight: bold">We will send the product to your order email or get it here: </span> </p>

                                            <a href="{{ URL::route('users.orderHistoryView', ["id" => $model->id , "order_no" => $model->order_no ]) }}" data-toggle="tooltip" title="Get your premium key" class="btn btn-primary" target="_blank">
                                                <i class="fa" style="font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;"> Get your premium key</i>
                                            </a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-content">
                    <div>
                        <div class="table-responsive">
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
                                            <?php if($model->payment_type->code == "PAYPAL") { ?>
                                                @include('articles::invoice.includes.checkout_paypal')
                                            <?php }else if($model->payment_type->code == "AMAZON"){ ?>
                                                 @include('articles::invoice.includes.checkout_amazon')
                                            <?php }else if($model->payment_type->code == "WEBMONEY"){ ?>
                                                @include('articles::invoice.includes.checkout_wmz')
                                            <?php }else if($model->payment_type->code == "PERFECT_MO"){ ?>
                                                @include('articles::invoice.includes.checkout_perfect')
                                            <?php }else if($model->payment_type->code == "BONUS"){ ?>
                                                @include('articles::invoice.includes.checkout_bonus')
                                            <?php }else if($model->payment_type->code == "BANK-TRANSFER"){?>
                                                @include('articles::invoice.includes.checkout_banktransfer')
                                            <?php }else if($model->payment_type->code == "VISA_STRIPE"){ ?>
                                                @include('articles::invoice.includes.checkout_visaStripe')
                                            <?php }else if($model->payment_type->code == "PREMIUM_PAYPAL"){ ?>
                                                @include('articles::invoice.includes.checkout_platformInvoice')
                                            <?php }else{ ?>
                                                @include('articles::invoice.includes.checkout_platformVisa')
                                            <?php } ?>
                                            
                                           
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <div class="page-title">
                    <h1>Your Products</h1>
                </div>
                <?php if (count($model_key) > 0 && $model->payment_status == "completed") { ///DA CO KEY ?>
                    <div class="tab-content">
                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-center">Product Name</td>
                                            <td class="text-center">Your Premium Key</td>
                                            <td class="text-center">How to activate</td>
                                            <td class="text-center">Date sent</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($model_key as $item): ?>
                                            <tr>
                                                <td class="text-center">{{ $item->articles_type_title }}</td>
                                                <td class="text-center"><strong style="color: #0000EE">{{ $item->key }}</strong></td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($item->getLinkActivate()) {
                                                        $model_activate = $item->getLinkActivate();
                                                        ?>
                                                        <a href="<?php echo $model_activate->getUrl(); ?>" target="_blank"><?php echo $model_activate->title; ?></a>
                                                    <?php } else { ?>
                                                        <p>N/A</p>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center" style="vertical-align: middle"><span class="label {{ ($item->date_sent) ? "label-primary" : "label-default" }}">{{ ($item->date_sent) ? $item->date_sent : "N/A" }}</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } else { // CHUA CO KEY  ?>
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
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
if ($model->payment_status != "completed") {
    header("refresh: 30;");
}
?>
@stop