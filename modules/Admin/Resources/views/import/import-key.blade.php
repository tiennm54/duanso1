@extends('backend.master')
@section('content')
    <div class="page-header">

        <div class="container-fluid">
            <div class="pull-right">

                <a href="<?php echo URL::route('articles.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>

            </div>
            <h1>Import Key</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <a href="">Import</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        @include('validator.flash-message')
        <div class="panel panel-default">
            <div class="panel-heading">

                <h3 class="panel-title"><i class="fa fa-list"></i> View Product</h3>
            </div>
            <div class="panel-body">

                <form action="{{ URL::route('import.postImport') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label >Select Product: (<span id="text_product_id">{{ $model != null ? $model->id : 0 }}</span>)</label>
                                <input class="typeahead form-control" type="text" value="{{ $model != null ? $model->title : "" }}" {{  $model != null ? "disabled" : "" }} >
                            </div>

                            <div class="col-md-4">
                                <input class="form-control" type="hidden" id="id_product" name="product_id" value="{{ $model != null ? $model->id : 0 }}">
                            </div>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>File Import: </label>
                                <input type="file" name="import_file" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <br/>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <button class="btn btn-primary">Import File</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@stop