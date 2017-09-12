@extends('backend.master')
@section('content')

    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">

                <a href="<?php echo URL::route('articlesChildren.getCreate', $model->id); ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Children">
                    <i class="fa fa-plus"></i>
                </a>

                <a href="<?php echo URL::route('articles.getEdit', ['id' => $model->id]); ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                    <i class="fa fa-edit"></i>
                </a>

                <a href="<?php echo URL::route('articles.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
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
                <h3 class="panel-title"><i class="fa fa-list"></i> View Product</h3>
            </div>
            <div class="panel-body">
                @include('validator.flash-message')
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#listProduct">List Product</a></li>
                    <li><a data-toggle="tab" href="#general">General</a></li>
                    <li><a data-toggle="tab" href="#seo">SEO</a></li>
                    <li><a data-toggle="tab" href="#image">Image</a></li>
                </ul>

                <div class="tab-content">

                    <div id="listProduct" class="tab-pane fade  in active">
                        @include('admin::articles.includes.view_tab_list_product',compact('model'))
                    </div>

                    <div id="general" class="tab-pane fade">
                        @include('admin::articles.includes.view_tab_general',compact('model'))
                    </div>
                    <div id="seo" class="tab-pane fade">
                        @include('admin::articles.includes.view_tab_seo',compact('model'))
                    </div>
                    <div id="image" class="tab-pane fade">
                        @include('admin::articles.includes.view_tab_image',compact('model'))
                    </div>

                </div>

            </div>
        </div>
    </div>
@stop
