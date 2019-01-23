@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <button type="submit" form="form-create-paypal-account" data-toggle="tooltip" title="Save" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a href="<?php echo URL::route("admin.paypal.index"); ?>" data-toggle="tooltip" title="Back" class="btn btn-default" data-original-title="Back"><i class="fa fa-reply"></i></a>
        </div>
        <h1>Paypal Account Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ URL::route('admin.paypal.index') }}">List paypal account</a>
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
            <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit Paypal Account</h3>
        </div>
        <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-create-paypal-account">
            @include('validator.flash-message')
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ (isset($model)) ? $model->email : "" }}" class="form-control border-input" placeholder="Email..." name="email" required>
                            {!! $errors->first('email','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" value="{{ (isset($model)) ? $model->password : "" }}" class="form-control border-input" placeholder="Password..." name="password" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" value="{{ (isset($model)) ? $model->full_name : "" }}" class="form-control border-input" placeholder="Full Name..." name="full_name" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>VPS IP</label>
                            <input type="text" value="{{ (isset($model)) ? $model->vps_ip : "" }}" class="form-control border-input" placeholder="VPS IP..." name="vps_ip">
                            {!! $errors->first('vps_ip','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Money Activate</label>
                            <input type="number" step="any" value="{{ (isset($model)) ? $model->money_activate : 0 }}" class="form-control border-input" placeholder="Money Activate..." name="money_activate">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Money hold</label>
                            <input type="number" step="any" value="{{ (isset($model)) ? $model->money_hold : 0 }}" class="form-control border-input" placeholder="Money hold..." name="money_hold">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Activate</label>
                            <select class="form-control" name="status_activate">
                                <option value="No_Activate" <?php echo (isset($model) && $model->status_activate == "No_Activate") ? "selected" : "" ?>>No Activate</option>
                                <option value="Activate" <?php echo (isset($model) && $model->status_activate == "Activate") ? "selected" : "" ?>>Activate</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Limit</label>
                            <select class="form-control" name="status">
                                <option value="Work" <?php echo (isset($model) && $model->status == "Work") ? "selected" : "" ?>>Work</option>
                                <option value="Pending" <?php echo (isset($model) && $model->status == "Pending") ? "selected" : "" ?>>Pending</option>
                                <option value="Limit" <?php echo (isset($model) && $model->status == "Limit") ? "selected" : "" ?>>Limit</option>
                                <option value="Restore" <?php echo (isset($model) && $model->status == "Restore") ? "selected" : "" ?>>Restore</option>
                                <option value="UnLimit" <?php echo (isset($model) && $model->status == "UnLimit") ? "selected" : "" ?>>UnLimit</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone</label>
                            <input value="{{ (isset($model)) ? $model->phone : "" }}" class="form-control border-input" placeholder="Phone..." name="phone">
                            {!! $errors->first('phone','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Website</label>
                            <input value="{{ (isset($model)) ? $model->website : "" }}" class="form-control border-input" placeholder="Website..." name="website">
                            {!! $errors->first('website','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Website</label>
                            <select class="form-control" name="status_website">
                                <option value="0" <?php echo (isset($model) && $model->status_website == "0") ? "selected" : "" ?>>OFF</option>
                                <option value="1" <?php echo (isset($model) && $model->status_website == "1") ? "selected" : "" ?>>ON</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Document</label>
                            <input type="file" name="document" class="form-control border-input">
                            {!! $errors->first('document','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Người gỡ</label>
                            <input value="{{ (isset($model)) ? $model->user_verify : "" }}" class="form-control border-input" placeholder="User verify..." name="user_verify">
                            {!! $errors->first('user_verify','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                        </div>
                    </div>
                    <?php if (isset($model) && $model->document != "" && $model->document != null): ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Download document</label><br>
                                <a class="btn btn-primary" href="<?php echo url('documents//' . $model->document); ?>" download>Download</a>
                            </div>
                        </div>
                    <?php endif; ?>

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