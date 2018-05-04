@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <a href="{{ URL::route('category.getCreate') }}" data-toggle="tooltip" title="Create"
               class="btn btn-primary" data-original-title="Add">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <h1>Category News</h1>
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('admin.index') }}">Home</a></li>
            <li><a>List category</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> List Category News</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr><th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>SEO Title</th>
                            <th>SEO Description</th>
                            <th>Action</th>
                        </tr></thead>
                    <tbody>


                        <?php foreach ($model as $key => $item): ?>

                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $item->name; ?></td>
                                <td><?php echo $item->description; ?></td>
                                <td><?php echo $item->seo_title; ?></td>
                                <td><?php echo $item->seo_description; ?></td>

                                <td>
                                    <a style="cursor: pointer" href="<?php echo URL::route('category.getEdit', $item->id); ?>">Edit | </a>
                                    <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo URL::route('category.delete', $item->id); ?>" style="cursor: pointer">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
