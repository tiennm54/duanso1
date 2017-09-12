@extends('backend.master')
@section('content')
    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <button type="submit" form="form-create-seo" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save">
                    <i class="fa fa-save"></i>
                </button>
                <a href="{{ URL::route('config.seo.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
            </div>

            <h1>SEO</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <a href="">Create SEO</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit SEO</h3>
            </div>
            <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-create-seo">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="type">
                                <option value="index" {{ (isset($model) && $model->type == "index") ? "selected" : ""}}>SEO Page Index</option>
                                <option value="checkout" {{ (isset($model) && $model->type == "checkout") ? "selected" : ""}}>SEO Page Checkout</option>

                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Meta Tag Title (<span class="count-seo-title"></span>)/65-70</label>
                            <input type="text" value="{{ (isset($model)) ? $model->seo_title : "" }}" onkeyup="countCharactersSeoTitle()" class="form-control border-input seo-title" placeholder="Meta Tag Title..." name="seo_title" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta Tag Description (<span class="count-seo-des"></span>)/120-160</label>
                            <textarea class="form-control border-input seo-des" onkeyup="countCharactersSeoDescription()" name="seo_description" rows="5" required>{{ (isset($model)) ? $model->seo_description : "" }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta Tag Keyword (<span class="count-seo-keyword"></span>)</label>
                            <textarea class="form-control border-input seo-keyword" onkeyup="countCharactersSeoKeyword()" name="seo_keyword" rows="5" required>{{ (isset($model)) ? $model->seo_keyword : "" }}</textarea>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop