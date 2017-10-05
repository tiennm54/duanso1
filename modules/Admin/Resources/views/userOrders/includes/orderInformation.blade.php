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
                    <td><a href="<?php  echo URL::route('adminUserOrders.viewOrders', ['id' => $model->id]); ?>">Back Order</a></td>
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
                                data-original-title="Import Key"><i class="glyphicon glyphicon-grain"></i>
                        </button>
                    </td>
                    <td>Order No: <b>{{ $model->order_no }}</b></td>
                </tr>

                <tr>
                    <td>
                        <button data-toggle="tooltip" title="" class="btn btn-info btn-xs">
                            <i class="glyphicon glyphicon-grain"></i>
                        </button>
                    </td>
                    <td>Order ID: <b>#{{ $model->id }}</b></td>
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
                    <td>Product</td>
                    <td class="text-left">
                        <b>{{ $model_product->title }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td class="text-left">
                        {{ $model_order_detail->quantity }}
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>