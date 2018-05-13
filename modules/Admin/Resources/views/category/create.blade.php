@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <button type="submit" form="form-category-news" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a href="{{ URL::route('category.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>
        <h1>Category News</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ URL::route('category.index') }}">Category News</a>
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
            <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit Category News</h3>
        </div>
        <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-category-news">

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
                                <label>Name</label>
                                <input type="text" value="{{ (isset($model)) ? $model->name : "" }}" class="form-control border-input" placeholder="Name..." name="txt_name" required>
                                {!! $errors->first('txt_name','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control border-input"
                                          name="txt_description"
                                          rows="5" required>{{ (isset($model)) ? $model->description : "" }}</textarea>
                                {!! $errors->first('txt_description','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                    </div>

                </div>

                <div id="seo" class="tab-pane fade">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control border-input" name="image">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Meta Tag Title (<span class="count-seo-title"></span>)/65-70</label>
                                <input type="text" style="width: 200%" value="{{ (isset($model)) ? $model->seo_title : "" }}"
                                       class="form-control border-input seo-title"
                                       onkeyup="countCharactersSeoTitle()"
                                       placeholder="Meta Tag Title..."
                                       name="txt_seo_title">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta Tag Description (<span class="count-seo-des"></span>)/120-160</label>
                                <textarea class="form-control border-input seo-des"
                                          name="txt_seo_description"
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
                                          name="txt_seo_keyword"
                                          onkeyup="countCharactersSeoKeyword()"
                                          rows="5">{{ (isset($model)) ? $model->seo_keyword : "" }}</textarea>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($model)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image Current</label>
                                    <?php if ($model->image != "") { ?>
                                        <img src="<?php echo url('images/news/' . $model->image); ?>" width="300px">
                                        <?php
                                    } else {
                                        echo "Chưa có IMAGE cho SEO";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </form>
    </div>
</div>
@stop