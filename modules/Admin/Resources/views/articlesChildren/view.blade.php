@extends('backend.master')
@section('content')


    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">

                <a href="<?php echo URL::route('articlesChildren.getEdit', ['id' => $model->id]); ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                    <i class="fa fa-edit"></i>
                </a>

                <a href="<?php echo URL::route('articles.view', ['id' => $model_articles->id]); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>
            </div>

            <h1>Product Children</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo URL::route('articles.index'); ?>">Home</a>
                </li>
                <li>
                    <a href="<?php echo URL::route('articles.view', ['id' => $model_articles->id]); ?>">{{ $model_articles->title }}</a>
                </li>

                <li>
                    <a href="">{{ $model->title }}</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> View Product: {{ $model->title }}</h3>
            </div>
            <div class="panel-body">

                <ul class="nav nav-tabs">

                    <li class="active"><a data-toggle="tab" href="#key_active">Key Active</a></li>
                    <li><a data-toggle="tab" href="#general">General</a></li>
                    <li><a data-toggle="tab" href="#seo">SEO</a></li>

                </ul>

                <div class="tab-content">

                    <div id="key_active" class="tab-pane fade in active">
                        @include('admin::articlesChildren.includes.view_tab_key_active',compact('model','model_key'))
                    </div>

                    <div id="general" class="tab-pane fade">
                        @include('admin::articlesChildren.includes.view_tab_general',compact('model'))
                    </div>
                    <div id="seo" class="tab-pane fade">
                        @include('admin::articlesChildren.includes.view_tab_seo',compact('model'))
                    </div>


                </div>

            </div>
        </div>

    </div>
@stop
