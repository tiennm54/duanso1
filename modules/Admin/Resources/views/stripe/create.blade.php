@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <button type="submit" form="form-create-stripe-account" data-toggle="tooltip" title="Save" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a href="<?php echo URL::route("admin.stripe.index"); ?>" data-toggle="tooltip" title="Back" class="btn btn-default" data-original-title="Back"><i class="fa fa-reply"></i></a>
        </div>
        <h1>Stripe Account Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ URL::route('admin.stripe.index') }}">List stripe account</a>
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
            <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit Stripe Account</h3>
        </div>
        
        <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-create-stripe-account">
            @include('validator.flash-message')
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Url Website</label>
                            <input type="text" value="{{ (isset($model)) ? $model->url_web : "" }}" class="form-control border-input" placeholder="Website..." name="url_web" required>
                            {!! $errors->first('url_web','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Money</label>
                            <input type="number" step="any" value="{{ (isset($model)) ? $model->total_money : 0 }}" class="form-control border-input" placeholder="Money Activate..." name="total_money">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Money hold</label>
                            <input type="number" step="any" value="{{ (isset($model)) ? $model->total_hold : 0 }}" class="form-control border-input" placeholder="Money hold..." name="total_hold">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Activate</label>
                            <select class="form-control" name="status_activate">
                                <option value="1" <?php echo (isset($model) && $model->status_activate == 1) ? "selected" : "" ?>>Activate</option>
                                <option value="0" <?php echo (isset($model) && $model->status_activate == 0) ? "selected" : "" ?>>Pause</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>MAX Money/Order</label>
                            <input value="{{ (isset($model)) ? $model->max_money : "" }}" class="form-control border-input" placeholder="Max money..." name="max_money">
                            {!! $errors->first('max_money','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>MAX Total Receive</label>
                            <input value="{{ (isset($model)) ? $model->max_receive : "" }}" class="form-control border-input" placeholder="Max receive..." name="max_receive">
                            {!! $errors->first('max_receive','<span class="control-label color-red" style="color: red">*:message</span>') !!}
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