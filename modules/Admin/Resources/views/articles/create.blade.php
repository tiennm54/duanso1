@extends('backend.master')
@section('content')

    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <button type="submit" form="form-create-product" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
                <a href="<?php echo URL::route('articles.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
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
                <h3 class="panel-title"><i class="fa fa-list"></i> Create Product</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                <div class="col-lg-12 col-md-7">
                    <div class="card">
                        <div class="content">
                            @include('validator.validator-input')
                            <form method="POST"  action="" enctype="multipart/form-data" id="form-create-product">
                                {{ csrf_field() }}

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                                    <li><a data-toggle="tab" href="#seo">SEO</a></li>
                                    <li><a data-toggle="tab" href="#image">Image</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="general" class="tab-pane fade  in active">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Category</label>
                                                    <select class="form-control border-input" name="int_category">
                                                        <?php foreach ($model_cate as $item):?>
                                                        <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Stock</label>
                                                    <select class="form-control border-input" name="int_instock">
                                                        <option value="1" selected>In Stock</option>
                                                        <option value="0">Not In Stock</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control border-input" placeholder="Title..." name="txt_title">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Code</label>
                                                    <input type="text" class="form-control border-input" placeholder="Code..." name="txt_code">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Brand</label>
                                                    <input type="text" class="form-control border-input" placeholder="Nhãn hiệu..." name="txt_brand">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Description</label>
                                                    <textarea class="form-control border-input textarea" name="txt_description"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="seo" class="tab-pane fade">

                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">SEO Title</label>
                                                    <input type="text" class="form-control border-input" placeholder="SEO Title..." name="txt_seo_title">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">SEO Description</label>
                                                    <textarea class="form-control border-input" name="txt_seo_description" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>SEO Keyword</label>
                                                    <textarea class="form-control border-input" name="txt_seo_keyword" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="image" class="tab-pane fade">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" class="form-control border-input" name="txt_image">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@stop
