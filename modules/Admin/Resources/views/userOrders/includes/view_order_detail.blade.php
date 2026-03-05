<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Payment Method">
                                <i class="fa fa-credit-card fa-fw"></i>
                            </button>
                        </td>
                        <td>

                            {{ $model->payment_type->title }} 

                            <?php
                            
                            if ($model->payment_type->code == "VISA_STRIPE" && $model->stripeAccount != null) {
                                ?>
                                <a class="label label-primary" href="<?php echo URL::route('admin.stripe.getEdit', $model->stripeAccount->id); ?>"> 
                                    <?php echo ($model->stripeAccount != null) ? $model->stripeAccount->url_web : "N.A"; ?>
                                </a>
                                <?php
                            } else if ($model->paypalAccount != null) {
                                ?>
                                <a class="label label-primary" href="<?php echo URL::route('admin.paypal.getEdit', $model->paypalAccount->id); ?>"> 
                                    <?php echo ($model->paypalAccount != null) ? $model->paypalAccount->email : "N.A"; ?>
                                </a>
                                <?php
                            }
                            ?>

                        </td>
                    </tr>

                    <tr>
                        <td style="width: 1%;">
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Store"><i class="fa fa-shopping-cart fa-fw"></i>
                            </button>
                        </td>
                        <td>{{ $model->user_info }}</td>
                    </tr>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Date Added"><i class="fa fa-calendar fa-fw"></i>
                            </button>
                        </td>
                        <td>{{ $model->created_at->timezone('Asia/Ho_Chi_Minh') }}</td>
                    </tr>

                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="User IP"><i class="fa fa-server"></i>
                            </button>
                        </td>
                        <td><b><?php echo ($model->user_ip != "") ? $model->user_ip : "N/A"; ?></b></td>
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
                        <td><a href="<?php echo URL::route('admin.userManagement.view', $model->users_id); ?>">{{ $model->email }}</a></td>
                    </tr>

                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Import Key"><i class="glyphicon glyphicon-grain"></i>
                            </button>
                        </td>
                        <td>Invoice: <b><a href="<?php echo URL::route("frontend.invoice.view", ['id' => $model->id, 'email' => $model->email]); ?>">{{ $model->order_no }}</a></b></td>
                    </tr>

                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs">
                                <i class="glyphicon glyphicon-grain"></i>
                            </button>
                        </td>
                        <td>
                            Order ID: <b>#{{ $model->id }}</b>
                            <?php
                                if($model->payment_type->code == "PREMIUM_PAYPAL"){
                                    $url_platform = URL_PLATFORM_SEARCH_ORDER . $model->id;
                            ?>
                                    <a class="label label-danger" href="<?php echo $url_platform; ?>" target="blank"> 
                                        <span>Update On Platform</span>
                                    </a>
                            <?php
                                }
                            ?>
                        </td>
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
                        <td class="col-md-5">Status</td>
                        <td class="text-right col-md-5">
                            <form method="post" action="{{ URL::route('adminUserOrders.saveStatusPayment',['id'=>$model->id] ) }}">
                                <div class="col-md-8">
                                    <select class="form-control" name="payment_status" style="width: 120px">
                                        <option value="pending" {{ ($model->payment_status == "pending") ? "selected" : "" }}>Pending</option>
                                        <option value="paid" {{ ($model->payment_status == "paid") ? "selected" : "" }}>Paid</option>
                                        <option value="refund" {{ ($model->payment_status == "refund") ? "selected" : "" }}>Refund</option>
                                        <option value="completed" {{ ($model->payment_status == "completed") ? "selected" :"" }}>Completed</option>
                                        <option value="cancel" {{ ($model->payment_status == "cancel") ? "selected" :"" }}>Canceled</option>
                                        <option value="dispute" {{ ($model->payment_status == "dispute") ? "selected" :"" }}>Dispute</option>
                                        <option value="echeck" {{ ($model->payment_status == "echeck") ? "selected" :"" }}>eCheck</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary" data-toggle="confirmation" data-placement="left">Save</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-5">Total</td>
                        <td class="text-right"><label class="label label-default">${{ $model->total_price }}</label></td>
                    </tr>

                    <tr>
                        <td class="col-md-5">Date Completed (VN)</td>
                        <td class="text-right">
                            <label class="label {{ ($model->check_send_key) ? "label-success" : "label-danger" }}">
                                 {{ \Carbon\Carbon::parse($model->payment_date)
                                            ->timezone('Asia/Ho_Chi_Minh')
                                            ->format('Y-m-d H:i:s') }}
                            </label>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="col-md-5">Date Completed (US)</td>
                        <td class="text-right">
                            <label class="label {{ ($model->check_send_key) ? "label-success" : "label-danger" }}">
                                {{ \Carbon\Carbon::parse($model->payment_date)->format('Y-m-d H:i:s') }}
                            </label>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>