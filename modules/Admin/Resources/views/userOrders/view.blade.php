@extends('backend.master')
@section('content')

    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <a href="<?php echo URL::route('adminUserOrders.listOrders'); ?>" data-toggle="tooltip"
                   class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>
            </div>

            <h1>Orders</h1>
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
        @include('validator.flash-message')
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td style="width: 1%;">
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Store"><i class="fa fa-shopping-cart fa-fw"></i>
                                </button>
                            </td>
                            <td><a href="{{ URL::route('frontend.articles.index') }}" target="_blank">Your Store</a></td>
                        </tr>
                        <tr>
                            <td>
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Date Added"><i class="fa fa-calendar fa-fw"></i>
                                </button>
                            </td>
                            <td>{{ $model->created_at }}</td>
                        </tr>
                        <tr>
                            <td>
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Payment Method"><i
                                            class="fa fa-credit-card fa-fw"></i></button>
                            </td>
                            <td>{{ $model->payment_type->title }}</td>
                        </tr>
                        <tr>
                            <td>
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Shipping Method"><i class="fa fa-truck fa-fw"></i>
                                </button>
                            </td>
                            <td>Send by mail</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user"></i> Customer Details</h3>
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td style="width: 1%;">
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Customer"><i class="fa fa-user fa-fw"></i></button>
                            </td>
                            <td>
                                <a href="#"
                                   target="_blank">{{ $model->first_name." ".$model->last_name }}</a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="E-Mail"><i class="fa fa-envelope-o fa-fw"></i>
                                </button>
                            </td>
                            <td><a href="mailto:{{ $model->email }}">{{ $model->email }}</a></td>
                        </tr>

                        <tr>
                            <td>
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Telephone"><i class="fa fa-phone fa-fw"></i>
                                </button>
                            </td>
                            <td>{{ $model->telephone }}</td>
                        </tr>

                        <tr>
                            <td>
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Import Key"><i class="glyphicon glyphicon-grain"></i>
                                </button>
                            </td>
                            <td><a class="btn btn-primary" href="{{URL::route('import.getImport')}}">Import</a></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-cog"></i> Options</h3>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Orders</td>
                                <td id="invoice" class="text-right">#{{ $model->id }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="text-right col-md-12">
                                    <form method="post" action="{{ URL::route('adminUserOrders.saveStatusPayment',['id'=>$model->id] ) }}">
                                        <div class="col-md-9">
                                            <select class="form-control" name="payment_status">
                                                <option value="pending" {{ ($model->payment_status == "pending") ? "selected" : "" }}>Pending</option>
                                                <option value="paid" {{ ($model->payment_status == "paid") ? "selected" : "" }}>Paid</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-xs" data-toggle="confirmation" data-placement="left">Save</button>
                                        </div>
                                    </form>

                                </td>
                            </tr>
                            <tr>
                                <td>Total price</td>
                                <td class="text-right">${{ $model->total_price }}</td>
                            </tr>

                            <tr>
                                <td>Send key</td>
                                <?php if($model->payment_status == "pending"){?>
                                    <td class="text-right">
                                        <form method="post" action="{{ URL::route('adminUserOrders.sendKey',['id'=>$model->id, 'email'=> $model->email]) }}">
                                            <button class="btn btn-warning" data-toggle="confirmation">Send Key</button>
                                        </form>
                                    </td>
                                <?php }else{?>
                                    <td class="text-right"><button class="btn btn-primary" disabled>Sent</button></td>
                                <?php }?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i>Order #{{ $model->id }}</h3>
            </div>
            <div class="panel-body">

                <!--THONG TIN ĐƠN HÀNG-->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td class="text-left">Product Name</td>
                            <td class="text-left">Model</td>
                            <td class="text-right">Quantity</td>
                            <td class="text-right">Price</td>
                            <td class="text-right">Total</td>

                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($model->orders_detail) == 0):?>
                        <tr>
                            <td class="text-left" colspan="6">Your shopping cart is empty!</td>
                        </tr>
                        <?php endif;?>
                        <?php if (count($model->orders_detail) > 0):?>
                        <?php foreach ($model->orders_detail as $item):?>
                        <tr>
                            <td class="text-left">
                                <a href="{{URL::route('articlesChildren.view',[ 'id' => $item->articles_type->id, 'url' => $item->articles_type->url_title.".html" ])}}" target="_blank">
                                    {{ $item->articles_type->title }}
                                </a>
                            </td>
                            <td class="text-left">{{ $item->articles_type->getArticles->title }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">${{ $item->price_order }}</td>
                            <td class="text-right">${{ $item->total_price }}</td>

                        </tr>
                        <?php endforeach;?>
                        <?php endif;?>
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
                                <td class="text-right"><b>Total</b></td>
                                <td class="text-right">${{ $model->total_price }}</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                <!--THONG TIN SHIPPING-->
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td class="text-left" style="width: 50%; vertical-align: top;">Billing Information</td>
                        <td class="text-left" style="width: 50%; vertical-align: top;">Shipping Address</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-left">
                            Full name: {{ $model->first_name }} {{ $model->last_name }} <br/>
                            Email: {{ $model->email }} <br/>
                            Telephone: {{ $model->telephone }} <br/>
                            Address: {{ $model->address }} <br/>
                            City: {{ $model->city }} <br/>
                            Zip code: {{ $model->zip_code }} <br/>
                            Country: {{ $model->country_name }} <br/>
                            State province: {{ $model->state_name }} <br/>
                        </td>
                        <td class="text-left">
                            Email: {{ $model->email }} <br/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@stop