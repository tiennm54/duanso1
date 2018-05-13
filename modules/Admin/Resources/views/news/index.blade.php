@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <a href="{{ URL::route('admin.news.getCreate') }}" data-toggle="tooltip" title="Create News"
               class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <h1>News</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">List News</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> List News</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="well">
                <div class="row">
                    <form action="" method="get">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" name="filter_title" value="{{Request::get('filter_title')}}" placeholder="Title" id="input-name" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Category</label>
                                <select class="form-control" name="filter_category">
                                    <option value="">Select status</option>
                                    <?php foreach ($model_cate as $item): ?>
                                        <option value="<?php echo $item->id; ?>" <?php echo (Request::get('filter_category') == $item->id) ? "selected" : ""; ?>><?php echo $item->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Search</label>
                                <div>
                                    <button type="submit" id="button-filter" class="btn btn-primary"><i class="fa fa-filter"></i> Search</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Reset</label>
                                <div>
                                    <a type="submit" class="btn btn-default" href="<?php echo URL::route('admin.news.index'); ?>">
                                        <i class="fa fa-filter"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Title</td>
                            <td>Category</td>
                            <td>Product</td>
                            <td>Created at</td>
                            <td width="10%">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ ($item->getCategory) ?  $item->getCategory->name : "N/A" }}</td>
                                <td>{{ ($item->getProduct) ?  $item->getProduct->title : "N/A" }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="{{ URL::route('admin.news.getEdit', ['id' => $item->id]) }}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <a href="{{ URL::route('admin.news.delete', ['id' => $item->id]) }}" class="btn btn-danger" data-toggle="confirmation">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
                <?php echo $model->appends(['filter_title' => Request::get('filter_title'), 'filter_category' => Request::get('filter_category')])->render(); ?>
            </div>
        </div>
    </div>
</div>


@stop