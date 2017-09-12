@extends('backend.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-7">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Create Payment Type</h4>
                    </div>
                    <div class="content">
                        @include('validator.validator-input')
                        <form method="POST"  action="" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control border-input" name="txt_image">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control border-input" placeholder="Title..." name="txt_title" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input type="number" class="form-control border-input" placeholder="Position..." name="txt_position" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Disable</label>
                                        <select class="form-control border-input" name="int_status_disable">
                                            <option value="0" selected>No disable</option>
                                            <option value="1">Disable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Fees</label>
                                        <input type="number"  step="any" class="form-control border-input" placeholder="Fees..." name="txt_fees" required>
                                    </div>
                                </div>

                            </div>




                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control border-input" name="txt_description"></textarea>
                                    </div>
                                </div>
                            </div>





                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill btn-wd">Create</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
