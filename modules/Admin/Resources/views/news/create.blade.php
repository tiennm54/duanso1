@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <button type="submit" form="form-news" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>

            <?php if (isset($model)): ?>
                <a href="{{ $model->getUrl() }}" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="View" target="_blank"><i class="fa fa-eye"></i></a>
            <?php endif; ?>

            <a href="{{ URL::route('admin.news.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
        </div>
        <h1>News</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">News</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit News</h3>
        </div>
        <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-news">
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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Category</label>
                                <select class="form-control" name="category_id">
                                    <option value="">Select category</option>
                                    <?php foreach ($model_cate as $item): ?>
                                        <option value="<?php echo $item->id; ?>" <?php echo (isset($model) && $model->category_id == $item->id) ? "selected" : "" ?>><?php echo $item->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Select Product</label>
                                <input class="typeahead-product form-control" type="text" value="{{ (isset($model->getProduct)) ? $model->getProduct->title : 0 }}">
                                <input class="form-control" type="hidden" id="id_product_select" name="product_id" value="{{ (isset($model)) ? $model->product_id : 0 }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
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
                                <label>Image</label>
                                <input type="file" class="form-control border-input" name="image">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>SEO Title (<span class="count-seo-title"></span>)/65-70</label>
                                <input type="text" value="{{ (isset($model)) ? $model->seo_title : "" }}" class="form-control border-input seo-title" onkeyup="countCharactersSeoTitle()" placeholder="Meta Tag Title..." name="seo_title">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">SEO Description (<span class="count-seo-des"></span>)/120-160</label>
                                <textarea class="form-control border-input seo-des" onkeyup="countCharactersSeoDescription()" name="seo_description" rows="5">{{ (isset($model)) ? $model->seo_description : "" }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">SEP Keyword (<span class="count-seo-keyword"></span>)</label>
                                <textarea class="form-control border-input seo-keyword" onkeyup="countCharactersSeoKeyword()" name="seo_keyword" rows="5">{{ (isset($model)) ? $model->seo_keyword : "" }}</textarea>
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