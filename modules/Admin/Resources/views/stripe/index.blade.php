@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="{{ URL::route('admin.stripe.getCreate') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
            </a>

            <a href="{{ URL::route('admin.stripe.indexStripePay') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Stripe Pay">
                <i class="glyphicon glyphicon-circle-arrow-up"></i>
            </a>

        </div>
        <h1>Stripe Account Management</h1>
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
            <h3 class="panel-title"><i class="fa fa-list"></i>Stripe Account</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Website</th>
                            <th>Max Money/Order</th>
                            <th>Max Total Receive</th>
                            <th>Total hold</th>
                            <th>Total Money</th>
                            <th>Rút PO về (<?php echo '$'.$total_all_pay;?>)</th>
                            <th>Status Activate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($model != null) { ?>
                            <?php foreach ($model as $key => $item): ?>
                            <form method="post" action="<?php echo URL::route('admin.stripe.saveData', ['id' => $item->id]); ?>">
                                <tr>
                                    <td><?php echo $key; ?></td>
                                    <td><?php echo $item->url_web; ?></td>
                                    <td><?php echo $item->max_money; ?></td>
                                    <td><?php echo $item->max_receive; ?></td>
                                    <td>
                                        <input name="total_hold" value=" <?php echo $item->total_hold; ?>"/>
                                    </td>
                                    <td>
                                        <input name="total_money" value=" <?php echo $item->total_money; ?>"/>
                                    </td>
                                    
                                    <td>
                                        <?php echo $item->total_pay; ?>
                                    </td>
                                    
                                    <td>
                                        <select name="status_activate">
                                            <option value="1" <?php echo ($item->status_activate == 1) ? "selected" : ""; ?>>Activate</option>
                                            <option value="0" <?php echo ($item->status_activate == 0) ? "selected" : ""; ?>>Pause</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-circle" data-toggle="modal" data-target="#modal_sell_stripe" onclick="sellStripe('<?php echo $item->id; ?>', '<?php echo $item->url_web; ?>')">
                                            <i class="glyphicon glyphicon-shopping-cart"></i>
                                        </a>
                                        <button type="submit" class="btn btn-primary" data-toggle="confirmation">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a class="btn btn-primary" href="<?php echo URL::route('admin.stripe.getEdit', $item->id); ?>"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger" data-toggle="confirmation" href="<?php echo URL::route('admin.stripe.delete', $item->id); ?>"><i class="glyphicon glyphicon-trash"></i></a>
                                    </td>
                                </tr>
                            </form>
                        <?php endforeach; ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="modal_sell_stripe" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sell Stripe for website: <span id="header_sell_stripe"></span></h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo URL::route('admin.stripe.sellStripe'); ?>">
                    <fieldset>
                        <input id="stripe_account_id" name="stripe_account_id" type="hidden"/>
                        <input id="stripe_account_url" name="stripe_account_url" type="hidden"/>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Money</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" step="any" name="money" required/>
                            </div>

                        </div>
                        
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Date Pay</label>
                            
                            <div class='col-sm-9 datetimepicker'>
                                <input type='text' value="{{ app('request')->input('date_pay') }}" class="form-control" name="date_pay" placeholder="Date Pay..."/>
                                
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
    function sellStripe(id, url_web) {
        $("#stripe_account_id").val(id);
        $("#header_sell_stripe").html(url_web);
        $("#stripe_account_url").val(url_web);
    }
</script>

@stop
