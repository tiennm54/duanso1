@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild">
                <i class="fa fa-refresh"></i>
            </a>
        </div>
        <h1>Feedback</h1>
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('admin.index')}}">Dashboard</a></li>
            <li><a>Feedback</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Feedback List</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User name</th>
                            <th>Image</th>
                            <th>Status fix</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td> {{ $key + 1 }} </td>
                                <td> {{ $item->user_name }}</td>
                                <td>{{ $item->image }}</td>
                                <td>
                                    <span class="label {{ ($item->status_fix == "OK") ? "label-primary" : "label-danger" }}">{{ $item->status_fix }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ URL::route('admin.feedback.view',['id'=>$item->id])}}" target="_blank">
                                        <i class="fa fa-eye"></i>
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
