@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <button type="submit" form="form-create-coupons" data-toggle="tooltip" title="Save" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a href="<?php echo URL::route("admin.coupons.index"); ?>" data-toggle="tooltip" title="Back" class="btn btn-default" data-original-title="Back"><i class="fa fa-reply"></i></a>
        </div>
        <h1>Coupons Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ URL::route('admin.coupons.index') }}">List coupons</a>
            </li>
            <li>
                <a href="#">Create</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit Coupon</h3>
        </div>
        <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-create-coupons">
            @include('validator.flash-message')
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Coupon Type</label>
                            <select name="coupons_type_id" class="form-control">
                                <option value="0">Select coupon type...</option>

                                <?php
                                if (isset($model_type) && $model_type != null) {
                                    foreach ($model_type as $coupon_type) {
                                        ?>
                                        <option value="<?php echo $coupon_type->id; ?>"
                                        <?php
                                        if (isset($model) && $model->coupons_type_id == $coupon_type->id) {
                                            echo "selected";
                                        }
                                        ?>>
                                                    <?php echo $coupon_type->title; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Coupon Code</label>
                            <input type="coupon_code" value="{{ (isset($model)) ? $model->coupon_code : "" }}" class="form-control border-input" placeholder="Coupon code..." name="coupon_code" required>
                            {!! $errors->first('title','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <div class='input-group datetimepicker'>
                                <input type='text' value="{{ (isset($model)) ? $model->expiry_date : "" }}" class="form-control" name="expiry_date" placeholder="Expiry Date..."/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control border-input textarea" name="description" required>{{ (isset($model)) ? $model->description : "" }}</textarea>
                        </div>
                    </div>
                </div>


            </div>
        </form>
    </div>
</div>
@stop