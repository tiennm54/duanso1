@extends('backend.master')
@section('content')

<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">
            <button type="submit" form="form-edit-product-reviews" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
            <a href="" target="_blank" data-toggle="tooltip" class="btn btn-primary" data-original-title="View Frontend"><i class="fa fa-eye"></i></a>
            <a href="<?php echo URL::route('admin.reviews.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
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
            <h3 class="panel-title"><i class="fa fa-list"></i> Edit Product Reviews</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <form method="POST"  action="<?php echo URL::route('admin.reviews.postEdit',["id"=>$model->id]);?>" enctype="multipart/form-data" id="form-edit-product-reviews">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                    <li><a data-toggle="tab" href="#seo">SEO</a></li>
                </ul>

                <div class="tab-content">
                    <div id="general" class="tab-pane fade  in active">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <img src="<?php echo url('images/' . $model->getArticles->image); ?>" width="200px">
                                </div>
                                <div class="form-group">
                                    <label>Product Name Reviews</label>
                                    <input type="text" class="form-control border-input" placeholder="Title..." name="title" value="<?php echo ($model->title) ? $model->title : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product Description Reviews</label>
                                    <textarea class="form-control border-input textarea" name="description"><?php echo ($model->description) ? $model->description : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="seo" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>URL Title</label>
                                    <input type="text" class="form-control border-input" placeholder="URL Title..." name="url_title" value="<?php echo ($model->url_title) ? $model->url_title : ''; ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">SEO Title (<span class="count-seo-title"></span>)/65-70</label>
                                    <input type="text" class="form-control border-input seo-title" maxlength="70" onkeyup="countCharactersSeoTitle()" placeholder="SEO Title..." name="seo_title" value="<?php echo ($model->seo_title) ? $model->seo_title : ''; ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">SEO Description (<span class="count-seo-des"></span>)/120-160</label>
                                    <textarea class="form-control border-input seo-des" maxlength="160" onkeyup="countCharactersSeoDescription()" name="seo_description" rows="5"><?php echo ($model->seo_description) ? $model->seo_description : ''; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">SEO Keyword (<span class="count-seo-keyword"></span>)</label>
                                    <textarea class="form-control border-input seo-keyword" onkeyup="countCharactersSeoKeyword()" name="seo_keyword" rows="5"><?php echo ($model->seo_keyword) ? $model->seo_keyword : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
