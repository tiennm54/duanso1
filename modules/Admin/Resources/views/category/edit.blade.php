@extends('backend.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-7">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Category</h4>
                    </div>
                    <div class="content">
                        @include('validator.validator-input')
                        <form method="POST"  action="{!! route('category.postEdit',["id"=> $id]) !!}" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control border-input" placeholder="Name" name="txt_name" value="{!! old('txt_name',isset($model->name) ? $model->name : null) !!}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">SEO Title</label>
                                        <input type="text" class="form-control border-input" placeholder="SEO Title" name="txt_url_title" value="<?php echo ($model->seo_title) ? $model->seo_title : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea type="text" class="form-control border-input" placeholder="Description" name="txt_description" required><?php echo ($model->description) ? $model->description : null; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>SEO Description</label>
                                        <textarea type="text" class="form-control border-input" placeholder="Description" name="txt_seo_description"><?php echo ($model->seo_description) ? $model->seo_description : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill btn-wd">Edit Category</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
