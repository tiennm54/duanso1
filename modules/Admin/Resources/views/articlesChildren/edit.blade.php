@extends('backend.master')
@section('content')
    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <button type="submit" form="form-edit-product-detail" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
                <a href="<?php echo URL::route('articlesChildren.view', ['id' => $model->id]); ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="View">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="<?php echo URL::route('articles.view', ['id' => $model_articles->id]); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>

            </div>

            <h1>Edit Product Children</h1>
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
                <h3 class="panel-title"><i class="fa fa-list"></i> Edit Product</h3>
            </div>
            <div class="panel-body">
                @include('validator.flash-message')
                <form method="POST"  action="" enctype="multipart/form-data" id="form-edit-product-detail">
                {{ csrf_field() }}
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                        <li><a data-toggle="tab" href="#seo">SEO</a></li>
                        <li><a data-toggle="tab" href="#des">Specification</a></li>
                        <li><a data-toggle="tab" href="#image">Image</a></li>
                    </ul>

                    <div class="tab-content">

                        <div id="general" class="tab-pane fade in active">
                            @include('admin::articlesChildren.includes.edit_tab_general',compact('model'))
                        </div>

                        <div id="seo" class="tab-pane fade">
                            @include('admin::articlesChildren.includes.edit_tab_seo',compact('model'))
                        </div>

                        <div id="des" class="tab-pane fade">
                            @include('admin::articlesChildren.includes.edit_tab_des',compact('model'))
                        </div>

                        <div id="image" class="tab-pane fade">
                            @include('admin::articlesChildren.includes.edit_tab_image',compact('model_articles'))
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop

