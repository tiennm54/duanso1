@extends('backend.master')
@section('content')
    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <button type="submit" form="form-information" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Save"><i class="fa fa-save"></i></button>
                <a href="{{ URL::route('admin.information.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
            </div>
            <h1>Information</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <a href="">Information</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> Create/Edit Infomation</h3>
            </div>
            <form class="panel-body" method="POST"  action="" enctype="multipart/form-data" id="form-information">

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
                                    <label>Type</label>
                                    <select class="form-control" name="type">
                                        <option value="delivery_information" {{ (isset($model) && $model->type == "delivery_information") ? "selected" : ""}}>Delivery Information</option>
                                        <option value="privacy_policy" {{ (isset($model) && $model->type == "privacy_policy") ? "selected" : ""}}>Privacy Policy</option>
                                        <option value="cancellations_returns" {{ (isset($model) && $model->type == "cancellations_returns") ? "selected" : ""}}>Cancellations Returns</option>
                                        <option value="sercurity_information" {{ (isset($model) && $model->type == "sercurity_information") ? "selected" : ""}}>Sercurity Information</option>
                                        <option value="terms_condition" {{ (isset($model) && $model->type == "terms_condition") ? "selected" : ""}}>Terms Condition</option>
                                        <option value="about_us" {{ (isset($model) && $model->type == "about_us") ? "selected" : ""}}>About Us</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" value="{{ (isset($model)) ? $model->title : "" }}" class="form-control border-input" placeholder="Title..." name="title">
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
                                    <label>Meta Tag Title</label>
                                    <input type="text" value="{{ (isset($model)) ? $model->meta_tag_title : "" }}" class="form-control border-input" placeholder="Meta Tag Title..." name="meta_tag_title">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta Tag Description</label>
                                    <textarea class="form-control border-input" name="meta_tag_description">{{ (isset($model)) ? $model->meta_tag_description : "" }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta Tag Keyword</label>
                                    <textarea class="form-control border-input" name="meta_tag_keyword">{{ (isset($model)) ? $model->meta_tag_keyword : "" }}</textarea>
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