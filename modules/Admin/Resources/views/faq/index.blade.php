@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <a href="{{ URL::route('admin.faq.getCreate') }}" data-toggle="tooltip" title="Create"
               class="btn btn-primary" data-original-title="Add">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <h1>Articles FAQ</h1>
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('articles.index') }}">Home</a></li>
            <li><a href="#">List Articles FAQ</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> List Articles FAQ</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="row">
                <form method="GET"  action="" enctype="multipart/form-data" id="form-search-faq">
                    <?php if (count($model_cate) != 0): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control border-input" name="category">
                                    <option value="0">All</option>
                                    <?php foreach ($model_cate as $item): ?>
                                        <option value="<?php echo $item->id; ?>" <?php echo (app('request')->input('category') ? "selected" : "" ) ?>><?php echo $item->title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>


                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" form="form-search-faq" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Search">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left">No</td>
                            <td class="text-left">Category FAQ</td>
                            <td class="text-left">Title</td>
                            <td class="text-left">URL Title</td>
                            <td class="text-right" width="10%">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td class="text-left">{{ $key + 1 }}</td>
                                <td class="text-left"><?php echo ($item->getCategoryFaq) ? $item->getCategoryFaq->title : ""; ?></td>
                                <td class="text-left">{{ $item->title }}</td>
                                <td class="text-left">{{ $item->url_title }}</td>
                                <td class="text-right">
                                    <a href="{{ URL::route('admin.faq.getEdit', ['id' => $item->id, 'url' => $item->url_title.'.html']) }}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{ URL::route('admin.faq.delete', ['id' => $item->id]) }}" data-toggle="confirmation" class="btn btn-danger" data-original-title="Delete">
                                        <i class="fa fa-trash"></i>
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