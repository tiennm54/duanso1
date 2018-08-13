@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="{{ URL::route('admin.paypal.getCreate') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
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
            @include('validator.flash-message')
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Email</th>
                        <th>Password</th>
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
                                <?php echo $key + 1; ?>
                            </td>
                            <td>
                                <b><?php echo $item->email; ?></b>
                                <hr>
                                <?php echo ($item->vps_ip) ? $item->vps_ip : "NONE"; ?>
                            </td>
                            <td><?php echo $item->password; ?></td>

                            <td><?php echo $item->money_activate . "$"; ?></td>
                            <td><?php echo $item->money_hold . "$"; ?></td>
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
