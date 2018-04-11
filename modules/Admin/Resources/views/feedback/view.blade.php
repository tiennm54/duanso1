@extends('backend.master')
@section('content')

<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <form method="post" action="{{ URL::route('admin.feedback.saveFinish',['id'=>$model->id])}}" enctype="multipart/form-data">
                <button type="submit" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save Finish">
                    <i class="fa fa-save"></i>
                </button>     

                <a href="<?php echo URL::route('admin.feedback.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>
            </form>
        </div>

        <h1>View Feedback #{{$model->id}}</h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route('admin.feedback.index'); ?>">Home</a>
            </li>
            <li>
                <a>Feedback</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-list"></i> 
                View Feedback <span class="label {{ ($model->status_fix == "OK") ? "label-primary" : "label-danger" }}">STATUS: {{ $model->status_fix }}</span>
            </h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <p>User feedback: {{ $model->user_name }}</p>
            <?php if ($model->image != ""): ?>
                <div>
                    <h2>Image</h2>
                    <img src="<?php echo url('images/feedback/' . $model->image); ?>" width="100%">
                </div>
            <?php endif; ?>
            <div>
                <h2>Description</h2>
                <p>
                    {!! $model->description !!}
                </p>
            </div>

        </div>
    </div>
</div>
@stop
