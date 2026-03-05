@extends('backend.master')
@section('content')
    <div class="page-header">

        <div class="container-fluid">
            <div class="pull-right">

                <a href="<?php echo URL::route('admin.paypal.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>

            </div>
            <h1>Import Account Paypal</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <a href="">Import account paypal</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        @include('validator.flash-message')
        <div class="panel panel-default">
            <div class="panel-heading">

                <h3 class="panel-title"><i class="fa fa-list"></i> Import account paypal</h3>
            </div>
            <div class="panel-body">

                <form action="{{ URL::route('import.postImportAccPaypal') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>Max Amount / Order</label>
                                <input class="form-control" name="max_amount" value="" required="" type="number">
                            </div>

                            <div class="col-md-4">
                                <label>Seller</label>
                                <input class="form-control" name="seller_name" value="" required="" type="text">
                            </div>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>File Import: </label>
                                <input type="file" name="import_file_acc" class="form-control"/>
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