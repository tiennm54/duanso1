@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild">
                <i class="fa fa-refresh"></i>
            </a>
        </div>
        <h1>Reviews Manager</h1>
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('admin.index')}}">Dashboard</a></li>
            <li><a>Reviews Manager</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Reviews List</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User name</th>
                            <th>Email</th>
                            <th>Description</th>
                            <th>Rate</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td> {{ $key + 1 }} </td>
                                <td> {{ $item->review_name }}</td>
                                <td>{{ $item->review_email }}</td>
                                <td>{{ $item->review_des }}</td>
                                <td><span class="<?php echo ($item->review_rate >= 4) ? "label label-primary" : "label label-danger"; ?> ">{{ $item->review_rate }}</span></td>
                                <th><span>{{ $item->review_status }}</span></th>
                                <td>
                                    <a class="btn btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this item?');"
                                       href="<?php echo URL::route('admin.userReviewsManager.delete', $item->id); ?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            {!! $model->render() !!}
        </div>
    </div>
</div>
@stop
