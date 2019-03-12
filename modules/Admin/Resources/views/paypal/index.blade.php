@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="{{ URL::route('admin.paypal.getCreate') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
            </a>
            <a href="{{ URL::route('admin.paypalReceive.index') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Paypal Receive">
                <i class="glyphicon glyphicon-circle-arrow-down"></i>
            </a>
            <a href="{{ URL::route('admin.sellPaypal.index') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Paypal Sell">
                <i class="glyphicon glyphicon-circle-arrow-up"></i>
            </a>
        </div>
        <h1>Paypal Account Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="">List Account</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Paypal Account</h3>
        </div>
        <div class="panel-body">
            <div class="well">
                <form action="{{ URL::route('admin.paypal.index') }}" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="text" name="email" placeholder="Email" class="form-control" value="{{ app('request')->input('email') }}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">VPS</label>
                                <input type="text" name="vps" placeholder="VPS" class="form-control" value="{{ app('request')->input('vps') }}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <input type="text" name="phone" placeholder="Phone" class="form-control" value="{{ app('request')->input('phone') }}">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Status Limit</label>
                                <select name="status_limit" class="form-control">
                                    <option value="">Status limit</option>
                                    <option value="Work" {{ (app('request')->input('status_limit') == "Work") ? "selected" : "" }} >
                                        Work
                                    </option>
                                    <option value="Pending" {{ (app('request')->input('status_limit') == "Pending") ? "selected" : "" }}>
                                        Pending
                                    </option>
                                    <option value="Limit" {{ (app('request')->input('status_limit') == "Limit") ? "selected" : "" }}>
                                        Limit
                                    </option>
                                    <option value="Restore" {{ (app('request')->input('status_limit') == "Restore") ? "selected" : "" }}>
                                        Restore
                                    </option>
                                    <option value="UnLimit" {{ (app('request')->input('status_limit') == "UnLimit") ? "selected" : "" }}>
                                        UnLimit
                                    </option>
                                    <option value="Banked" {{ (app('request')->input('status_limit') == "Banked") ? "selected" : "" }}>
                                        Banked
                                    </option>
                                    <option value="Cancel" {{ (app('request')->input('status_limit') == "Cancel") ? "selected" : "" }}>
                                        Cancel
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Status Activate</label>
                                <select name="status_activate" class="form-control">
                                    <option value="">Status activate</option>
                                    <option value="No_Activate" {{ (app('request')->input('status_activate') == "No_Activate") ? "selected" : "" }} >
                                        No Activate
                                    </option>
                                    <option value="Activate" {{ (app('request')->input('status_activate') == "Activate") ? "selected" : "" }}>
                                        Activate
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group ">
                                <label class="control-label">Search</label>
                                <button type="submit" class="btn btn-primary form-control">Search</button>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group ">
                                <label class="control-label">Reset</label>
                                <a href="<?php echo URL::route('admin.paypal.index'); ?>" class="btn btn-primary form-control">Reset</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Prefix</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Website</th>
                            <th>Money activate</th>
                            <th>Money hold</th>
                            <th>Status Limit</th>
                            <th>Status Activate</th>
                            <th>End date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $date_now = strtotime(date("Y-m-d H:i:s")); ?>
                        <?php foreach ($model as $key => $item): ?>
                            <?php $end_date = ($item->end_date) ? strtotime($item->end_date) : strtotime(date("Y-m-d H:i:s")); ?>
                            <?php $secs = $date_now - $end_date; ?>

                            <tr>
                                <td>
                                    <span class="label label-primary"><?php echo ($item->prefix != "") ? $item->prefix : "BPK"; ?></span>
                                </td>
                                <td>
                                    <b>
                                        <a href="<?php echo URL::route("admin.sellPaypal.index", ["id" => $item->id]); ?>">
                                            <?php echo $item->email; ?>
                                        </a>
                                    </b>

                                    <hr>
                                    <?php echo ($item->vps_ip) ? $item->vps_ip : "NONE"; ?> | 
                                    <?php echo ($item->phone) ? $item->phone : "NONE"; ?>

                                </td>
                                <td><?php echo $item->password; ?></td>
                                <td>
                                    <?php
                                    if ($item->website != "") {
                                        if ($item->status_website == 1) {
                                            ?>
                                            <a class="label label-success" href="<?php echo $item->website; ?>" target="_blank">SITE ON</a>
                                        <?php } else { ?>
                                            <a class="label label-danger" href="<?php echo $item->website; ?>" target="_blank">SITE OFF</a>
                                            <?php
                                        }
                                    }else{
                                        echo "N/A";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $item->money_activate . "$"; ?></td>
                                <td>
                                    <a href="<?php echo URL::route("admin.paypalReceive.index", ["id" => $item->id]) . "?status_receive=pending"; ?>"><?php echo $item->money_hold . "$"; ?></a>
                                </td>
                                <td>
                                    <span class="label {{ ($item->status != "Limit") ? "label-primary" : "label-danger"}}">
                                        <?php echo $item->status; ?>
                                    </span>
                                </td>
                                <td> 
                                    <span class="label {{ ($item->status_activate == "Activate") ? "label-primary" : "label-danger"}}"> 
                                        <?php echo $item->status_activate; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php echo round($secs / 86400); ?> days
                                </td>

                                <td>
                                    <a class="btn btn-info btn-circle" data-toggle="modal" data-target="#modal_sell_paypal" onclick="sellPaypal('<?php echo $item->id; ?>', '<?php echo $item->email; ?>')">
                                        <i class="glyphicon glyphicon-shopping-cart"></i>
                                    </a>
                                    <a class="btn btn-primary" href="<?php echo URL::route('admin.paypal.getEdit', $item->id); ?>"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-primary" title="Bạn có muốn nhận tiền từ tài khoản này không?" data-toggle="confirmation" href="<?php echo URL::route('admin.paypal.changeStatusActivate', $item->id); ?>"><i class="glyphicon glyphicon-repeat"></i></a>
                                    <a class="btn btn-danger" data-toggle="confirmation" href="<?php echo URL::route('admin.paypal.delete', $item->id); ?>"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>


                    </tbody>
                </table>
            </div>
            <?php
            echo $model->appends([
                'email' => Request::get('email'),
                'vps' => Request::get('vps'),
                'status_limit' => Request::get('status_limit'),
                'status_activate' => Request::get('status_activate')
            ])->render();
            ?>
        </div>

    </div>
</div>



<div id="modal_sell_paypal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sell paypal for email: <span id="header_sell_paypal"></span></h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo URL::route('admin.paypal.sellPaypal'); ?>">
                    <fieldset>
                        <input id="paypal_account_id" name="paypal_account_id" type="hidden"/>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Money</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" step="any" name="money" required/>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Email Buyer</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="email_buyer" required/>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Name Buyer</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="name_buyer" required/>
                            </div>
                        </div>
                    </fieldset>
                    <div class="buttons clearfix">
                        <div class="pull-right">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function sellPaypal(id, email) {
        $("#paypal_account_id").val(id);
        $("#header_sell_paypal").html(email);
    }
</script>

@stop
