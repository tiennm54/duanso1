@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <a href="{{ URL::route('config.seo.getCreate') }}" data-toggle="tooltip" title=""
               class="btn btn-primary" data-original-title="Add New">
                <i class="fa fa-plus"></i>
            </a>

            <a href="{{ URL::route('config.seo.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>

        <h1>SEO</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">Create SEO</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> List SEO</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left">Page</td>
                            <td class="text-left">Image</td>
                            <td class="text-left">SEO Title</td>
                            <td class="text-left">SEO Description</td>
                            <td class="text-right" width="10%">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td><?php echo $item->getPage->name; ?></td>
                                <td><img src="<?php echo url('images/seo/' . $item->image); ?>" width="100px"></td>
                                <td class="text-left">{{ $item->seo_title }}</td>
                                <td class="text-left">{{ $item->seo_description }}</td>
                                <td class="text-right">
                                    <a href="{{ URL::route('config.seo.getEdit', ['id'=>$item->id]) }}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <a
                                        onclick="return confirm('Are you sure you want to delete this item?');"
                                        href="{{ URL::route('config.seo.getDelete', ['id'=>$item->id]) }}"
                                        data-toggle="tooltip" title=""
                                        class="btn btn-danger"
                                        data-original-title="Delete"
                                        >
                                        <i class="fa fa-trash-o"></i>
                                    </a>
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