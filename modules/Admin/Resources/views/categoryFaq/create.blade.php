@extends('backend.master')
@section('content')
    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <button type="submit" form="form-category-faq" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
                <a href="{{ URL::route('admin.categoryFaq.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
            </div>
            <h1>Category FAQ</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ URL::route('articles.index') }}">Home</a>
                </li>
                <li>
                    <a href="{{ URL::route('admin.categoryFaq.index') }}">Category FAQ</a>
                </li>
                <li>
                    <a href="#">Create</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit Category FAQ</h3>
            </div>
            <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-category-faq">
                @include('validator.flash-message')
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#general">General</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#seo">SEO</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div id="general" class="tab-pane fade  in active">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" value="{{ (isset($model)) ? $model->title : "" }}" class="form-control border-input" placeholder="Title..." name="title" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Description</label>
                                    <textarea class="form-control border-input textarea" name="description">{{ (isset($model)) ? $model->description : "" }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="seo" class="tab-pane fade">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Meta Tag Title (<span class="count-seo-title"></span>)/65-70</label>
                                    <input type="text" value="{{ (isset($model)) ? $model->seo_title : "" }}"
                                           class="form-control border-input seo-title"
                                           onkeyup="countCharactersSeoTitle()"
                                           placeholder="Meta Tag Title..."
                                           name="seo_title">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta Tag Description (<span class="count-seo-des"></span>)/120-160</label>
                                    <textarea class="form-control border-input seo-des"
                                              name="seo_description"
                                              onkeyup="countCharactersSeoDescription()"
                                              rows="5">{{ (isset($model)) ? $model->seo_description : "" }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta Tag Keyword (<span class="count-seo-keyword"></span>)</label>
                                    <textarea class="form-control border-input seo-keyword"
                                              name="seo_keyword"
                                              onkeyup="countCharactersSeoKeyword()"
                                              rows="5">{{ (isset($model)) ? $model->seo_keyword : "" }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop