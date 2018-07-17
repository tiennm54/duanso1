@extends('backend.master')
@section('content')

<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild">
                <i class="fa fa-refresh"></i>
            </a>
        </div>
        <h1>Product</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">Product</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Product Reviews List</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="well">
                <form action="" method="get"
                      enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <input type="text" name="title" placeholder="Title" class="form-control"
                                       value="{{ app('request')->input('title') }}">
                            </div>

                        </div>
                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Search</label>
                                <button type="submit" class="btn btn-primary form-control">Search</button>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Reset</label>
                                <a href="{{ URL::route('admin.reviews.index') }}" class="btn btn-primary form-control">Reset</a>
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group ">
                                <label class="control-label">Update</label>
                                <a href="{{ URL::route('admin.reviews.insertDb') }}" class="btn btn-primary form-control">Update list reviews</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>

                            <tr>
                                <td>
                                    <img src="<?php echo url('images/' . $item->getArticles->image); ?>" width="150px">
                                </td>
                                <td><?php echo $item->title; ?></td>
                                <td>
                                    <a class="btn btn-primary"
                                       href="<?php echo URL::route('admin.reviews.getEdit', ['id' => $item->id, 'url' => $item->url_title . '.html']); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

            <?php
            echo $model->appends([
                'title' => Request::get('title'),
            ])->render();
            ?>
        </div>
    </div>
</div>

@stop
