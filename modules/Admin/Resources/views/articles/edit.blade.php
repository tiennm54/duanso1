@extends('backend.master')
@section('content')

    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <button type="submit" form="form-edit-product" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
                <a href="<?php echo $model->getUrlPricing(); ?>" target="_blank" data-toggle="tooltip" class="btn btn-primary" data-original-title="View Frontend"><i class="fa fa-eye"></i></a>
                <a href="<?php echo URL::route('articles.view', ['id' => $model->id, 'url' => $model->url_title.'.html']); ?>" target="_blank" data-toggle="tooltip" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
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
                <h3 class="panel-title"><i class="fa fa-list"></i> Edit Product</h3>
            </div>
            <div class="panel-body">
                @include('validator.flash-message')
                <form method="POST"  action="" enctype="multipart/form-data" id="form-edit-product">

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
                                        <label>Disable</label>
                                        <select class="form-control border-input" name="status_disable">
                                            <option value="0" <?php if($model->status_disable == 0){ echo "selected"; } ?>>Show</option>
                                            <option value="1" <?php if($model->status_disable == 1){ echo "selected"; } ?>>Hide</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Stock</label>
                                        <select class="form-control border-input" name="int_instock">
                                            <option value="1" <?php if($model->status_stock == 1){ echo "selected"; } ?>>In Stock</option>
                                            <option value="0" <?php if($model->status_stock == 0){ echo "selected"; } ?>>Not In Stock</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Site official</label>
                                        <input type="text" class="form-control border-input" placeholder="Site official..." name="site_official" value="<?php echo ($model->site_official) ? $model->site_official : ''; ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control border-input" placeholder="Title..." name="txt_title" value="<?php echo ($model->title) ? $model->title : ''; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" class="form-control border-input" placeholder="Code..." name="txt_code" value="<?php echo ($model->code) ? $model->code : ''; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Brand</label>
                                        <input type="text" class="form-control border-input" placeholder="Nhãn hiệu..." name="txt_brand" value="<?php echo ($model->brand) ? $model->brand : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control border-input textarea" name="txt_description"><?php echo ($model->description) ? $model->description : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="seo" class="tab-pane fade">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">URL Title</label>
                                        <input type="text" class="form-control border-input" placeholder="URL Title..." name="txt_url_title" value="<?php echo ($model->url_title) ? $model->url_title : ''; ?>" disabled>
                                    </div>
                                </div>




                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SEO Title (<span class="count-seo-title"></span>)/65-70</label>
                                        <input type="text" class="form-control border-input seo-title" onkeyup="countCharactersSeoTitle()" placeholder="SEO Title..." name="txt_seo_title" value="<?php echo ($model->seo_title) ? $model->seo_title : ''; ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SEO Description (<span class="count-seo-des"></span>)/120-160</label>
                                        <textarea class="form-control border-input seo-des"  onkeyup="countCharactersSeoDescription()" name="txt_seo_description" rows="5"><?php echo ($model->seo_description) ? $model->seo_description : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SEO Keyword (<span class="count-seo-keyword"></span>)</label>
                                        <textarea class="form-control border-input seo-keyword" onkeyup="countCharactersSeoKeyword()" name="txt_seo_keyword" rows="5"><?php echo ($model->seo_keyword) ? $model->seo_keyword : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="image" class="tab-pane fade">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <img src="<?php echo url('images/' . $model->image); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control border-input" name="txt_image">
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
