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
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" value="<?php echo ($model->code) ? $model->code : ''; ?>" class="form-control border-input" placeholder="Code..." name="txt_code" required>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="<?php echo ($model->email) ? $model->email : ''; ?>" class="form-control border-input" placeholder="Email..." name="txt_email" required>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Disable Việt Nam</label>
                                <select class="form-control border-input" name="disable_vn">
                                    <option value="0" <?php if($model->disable_vn == 0){ echo "selected"; } ?>>Show</option>
                                    <option value="1" <?php if($model->disable_vn == 1){ echo "selected"; } ?>>Hide</option>
                                </select>
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
                                    <option value="0" <?php if($model->status_disable == 0){ echo "selected"; } ?>>Show</option>
                                    <option value="1" <?php if($model->status_disable == 1){ echo "selected"; } ?>>Hide</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Selected</label>
                                <select class="form-control border-input" name="int_status_selected">
                                    <option value="1" <?php if($model->status_selected == 0){ echo "selected"; } ?>>ON</option>
                                    <option value="0" <?php if($model->status_selected == 0){ echo "selected"; } ?>>OFF</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fees</label>
                                <input type="number"  step="any" value="<?php echo ($model->fees) ? $model->fees : ''; ?>" class="form-control border-input" placeholder="Fees..." name="txt_fees" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Plus</label>
                                <input type="number"  step="any" value="<?php echo ($model->plus) ? $model->plus : ''; ?>" class="form-control border-input" placeholder="Plus..." name="txt_plus" required>
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
                        <div class="col-md-12">
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
