@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">

        <div class="pull-right">

        </div>

        <h1>Customers</h1>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">List Customers</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> User Management</h3>
        </div>
        <div class="panel-body">
            @include('validator.flash-message')
            <div class="well">
                <div class="row">
                    <form action="" method="get">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-name">Customer Name</label>
                                <input type="text" name="filter_name" value="{{Request::get('filter_name')}}" placeholder="Customer Name" id="input-name" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-email">E-Mail</label>
                                <input type="text" name="filter_email" value="{{Request::get('filter_email')}}" placeholder="E-Mail" id="input-email" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-email">Status lock</label>
                                <select class="form-control" name="filter_status">
                                    <option value="">Select status</option>
                                    <option value="0" {{ (app('request')->input('filter_status') == "0") ? "selected" : "" }}>OKIE</option>
                                    <option value="1" {{ (app('request')->input('filter_status') == "1") ? "selected" : "" }}>LOCKED</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Search</label>
                                <div>
                                    <button type="submit" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Reset</label>
                                <div>
                                    <a type="submit" class="btn btn-default pull-right" href="<?php echo URL::route('admin.userManagement.index'); ?>">
                                        <i class="fa fa-filter"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left"><a>No</a></td>
                            <td class="text-left"><a>Email Login</a></td>
                            <td class="text-left"><a>Full Name</a></td>
                            <td class="text-left"><a>Money Account</a></td>
                            <td class="text-left"><a>Money Bonus</a></td>
                            <td class="text-left"><a>Status lock</a></td>
                            <td class="text-left"><a>Status delete</a></td>
                            <td class="text-right">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($model) == 0): ?> 
                            <tr>
                                <td colspan="8">Không có bản ghi nào</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td class="text-left">{{ $key + 1 }}</td>
                                <td class="text-left">{{ $item->email }}</td>
                                <td class="text-left">{{ $item->first_name." ".$item->last_name }} </td>
                                <td class="text-center">{{ ($item->getMoneyAccountCurrent()) ? $item->getMoneyAccountCurrent() : "0.00" }}$ </td>
                                <td class="text-center">{{ $item->getMoneyForUser() }}$</td>
                                <td class="text-center">
                                    <span class="label {{ ($item->status_lock == 0) ? "label-primary" : "label-danger" }}">{{ ($item->status_lock == 0) ? "OKIE" : "LOCKED" }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="label {{ ($item->status_delete != 1) ? "label-primary" : "label-danger" }}">{{ ($item->status_delete != 1) ? "OKIE" : "DELETED" }}</span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ URL::route('admin.userManagement.view', ["id" => $item->id]) }}" data-toggle="tooltip" title="" class="btn btn-primary"
                                       data-original-title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ URL::route('admin.userManagement.delete', ["id" => $item->id]) }}" data-toggle="confirmation" class="btn btn-danger">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

                <?php echo $model->appends(['filter_name' => Request::get('filter_name'), 'filter_email' => Request::get('filter_email')])->render(); ?>

            </div>
        </div>
    </div>
</div>



@stop