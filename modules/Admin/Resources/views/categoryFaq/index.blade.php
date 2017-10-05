@extends('backend.master')
@section('content')
    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <a href="{{ URL::route('admin.categoryFaq.getCreate') }}" data-toggle="tooltip" title="Create"
                   class="btn btn-primary" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <h1>Category FAQ</h1>
            <ul class="breadcrumb">
                <li><a href="{{ URL::route('articles.index') }}">Home</a></li>
                <li><a href="#">List category FAQ</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> List Category FAQ</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td class="text-left"><a class="asc">No</a></td>
                                <td class="text-left"><a class="asc">Title</a></td>
                                <td class="text-left"><a class="asc">Description</a></td>
                                <td class="text-right">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model as $key => $item):?>
                            <tr>
                                <td class="text-left">{{ $key + 1 }}</td>
                                <td class="text-left">{{ $item->title }}</td>
                                <td class="text-left">{!! $item->description !!}</td>
                                <td class="text-right">
                                    <a href="{{ URL::route('admin.categoryFaq.getEdit', ['id' => $item->id, 'url' => $item->url_title.'.html']) }}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
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