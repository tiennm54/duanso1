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
                        <td width="30%">Status</td>
                        <td class="text-right col-md-12">
                            <form method="post" action="{{ URL::route('adminUserOrders.saveStatusPayment',['id'=>$model->id] ) }}">
                                <div class="col-md-9">
                                    <select class="form-control" name="payment_status">
                                        <option value="pending" {{ ($model->payment_status == "pending") ? "selected" : "" }}>Pending</option>
                                        <option value="paid" {{ ($model->payment_status == "paid") ? "selected" : "" }}>Paid</option>
                                        <option value="completed" {{ ($model->payment_status == "completed") ? "selected" : "" }}>Completed</option>
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
                        <td class="text-right"><label class="label label-default">${{ $model->total_price }}</label></td>
                    </tr>
                    
                    <tr>
                        <td>Eligible sent mail</td>
                        <td class="text-right"><label class="label {{ ($model->check_send_key) ? "label-success" : "label-danger" }}">{{ ($model->check_send_key) ? "YES" : "NO" }}</label></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>