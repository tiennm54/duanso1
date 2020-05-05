@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <button type="submit" form="form-create-coupons-type" data-toggle="tooltip" title="Save" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a href="<?php echo URL::route("admin.couponsType.index"); ?>" data-toggle="tooltip" title="Back" class="btn btn-default" data-original-title="Back"><i class="fa fa-reply"></i></a>
        </div>
        <h1>Coupons Type Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ URL::route('admin.couponsType.index') }}">List coupons type</a>
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
            <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit Coupon Type</h3>
        </div>
        <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-create-coupons-type">
            @include('validator.flash-message')
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="title" value="{{ (isset($model)) ? $model->title : "" }}" class="form-control border-input" placeholder="Title..." name="title" required>
                            {!! $errors->first('title','<span class="control-label color-red" style="color: red">*:message</span>') !!}
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