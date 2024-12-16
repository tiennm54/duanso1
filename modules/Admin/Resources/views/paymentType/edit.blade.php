@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <button type="submit" form="form-payment-type" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a href="{{ URL::route('paymentType.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>
        <h1>Edit Payment Type</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('articles.index') }}">Home</a>
            </li>
            <li>
                <a href="">Payment</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>EDIT PAYMENT</h3>
        </div>
        <div class="panel-body">
            @include('validator.validator-input')
            @include('validator.flash-message')
            <form method="POST"  action="" enctype="multipart/form-data" id="form-payment-type">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control border-input" name="txt_image">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" value="<?php echo ($model->title) ? $model->title : ''; ?>" class="form-control border-input" placeholder="Title..." name="txt_title" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" value="<?php echo ($model->code) ? $model->code : ''; ?>" class="form-control border-input" placeholder="Code..." name="txt_code" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo ($model->email) ? $model->email : ''; ?>" class="form-control border-input" placeholder="Email..." name="txt_email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Position</label>
                            <input type="number" value="<?php echo ($model->position) ? $model->position : ''; ?>" class="form-control border-input" placeholder="Position..." name="txt_position" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Disable</label>
                            <select class="form-control border-input" name="int_status_disable">
                                <option value="0" <?php
                                if ($model->status_disable == 0) {
                                    echo "selected";
                                }
                                ?>>Show</option>
                                <option value="1" <?php
                                if ($model->status_disable == 1) {
                                    echo "selected";
                                }
                                ?>>Hide</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Selected</label>
                            <select class="form-control border-input" name="int_status_selected">
                                <option value="1" <?php
                                if ($model->status_selected == 0) {
                                    echo "selected";
                                }
                                ?>>ON</option>
                                <option value="0" <?php
                                if ($model->status_selected == 0) {
                                    echo "selected";
                                }
                                ?>>OFF</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fees</label>
                            <input type="number"  step="any" value="<?php echo ($model->fees) ? $model->fees : 0; ?>" class="form-control border-input" placeholder="Fees..." name="txt_fees" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Plus</label>
                            <input type="number"  step="any" value="<?php echo ($model->plus) ? $model->plus : 0; ?>" class="form-control border-input" placeholder="Plus..." name="txt_plus" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Payment ID</label>
                            <input type="text"  value="<?php echo ($model->payment_id) ? $model->payment_id : ''; ?>" class="form-control border-input" placeholder="Payment ID..." name="txt_payment_id">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Disable Country</label>
                            <select class="form-control border-input" name="disable_vn">
                                <option value="0" <?php
                                if ($model->disable_vn == 0) {
                                    echo "selected";
                                }
                                ?>>Show</option>
                                <option value="1" <?php
                                if ($model->disable_vn == 1) {
                                    echo "selected";
                                }
                                ?>>Hide</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>List Country Disable</label>
                            <input type="text" value="<?php echo ($model->disable_country) ? $model->disable_country : ''; ?>" class="form-control border-input" placeholder="List Country Disable..." name="txt_disable_country">
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Check Proxy/VPN</label>
                            <select class="form-control border-input" name="check_proxy">
                                <option value="0" <?php
                                if ($model->check_proxy == 0) {
                                    echo "selected";
                                }
                                ?>>No</option>
                                <option value="1" <?php
                                if ($model->check_proxy == 1) {
                                    echo "selected";
                                }
                                ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    
                    

                    <div class="col-md-2" hidden="">
                        <div class="form-group">
                            <label>Fees Service (Phí dịch vụ)</label>
                            <input type="number"  step="any" value="<?php echo ($model->fees_service) ? $model->fees_service : 0; ?>" class="form-control border-input" placeholder="Fees Service..." name="fees_service">
                        </div>
                    </div>

                    <div class="col-md-2" hidden="">
                        <div class="form-group">
                            <label>Plus Service</label>
                            <input type="number"  step="any" value="<?php echo ($model->plus_service) ? $model->plus_service : 0; ?>" class="form-control border-input" placeholder="Plus Service..." name="plus_service">
                        </div>
                    </div>
                    
                    <div class="col-md-2" hidden="">
                        <div class="form-group">
                            <label>Total Money</label>
                            <input type="number"  step="any" value="<?php echo ($model->money_total) ? $model->money_total : 0; ?>" class="form-control border-input">
                        </div>
                    </div>
                    
                    <div class="col-md-2" hidden="">
                        <div class="form-group">
                            <label>Total Current</label>
                            <input type="number"  step="any" value="<?php echo ($model->money_current) ? $model->money_current : 0; ?>" class="form-control border-input" name="txt_money_current">
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>MAX Payment</label>
                            <input type="number"  step="any" value="<?php echo ($model->max_payment) ? $model->max_payment : 0; ?>" class="form-control border-input" name="max_payment">
                        </div>
                    </div>
                    
                </div>




                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Disable to guests</label>
                            <select class="form-control border-input" name="disable_guests">
                                <option value="0" <?php
                                if ($model->disable_guests == 0) {
                                    echo "selected";
                                }
                                ?>>Show</option>
                                <option value="1" <?php
                                if ($model->disable_guests == 1) {
                                    echo "selected";
                                }
                                ?>>Hide</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Total Order Completed</label>
                            <input type="number"  step="any" value="<?php echo ($model->total_completed) ? $model->total_completed : 0; ?>" class="form-control border-input" placeholder="Số đơn completed để được hiển thị payment method" name="total_completed">
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea class="form-control border-input" name="txt_description"><?php echo ($model->description) ? $model->description : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
