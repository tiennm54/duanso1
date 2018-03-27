@extends('backend.master')
@section('content')

<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="<?php echo URL::route('admin.userManagement.index'); ?>" data-toggle="tooltip"
               class="btn btn-default" data-original-title="Cancel">
                <i class="fa fa-reply"></i>
            </a>
        </div>
        <ul class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="">User manager's</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    @include('validator.flash-message')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-usd"></i>Money</h3>
                </div>
                <table class="table">
                    <tbody>

                        <tr>
                            <td style="width: 1%;">
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Money bonus"><i
                                        class="fa fa-credit-card fa-fw"></i></button>
                            </td>
                            <td>
                                {{ ($model->getMoneyForUser()) ? $model->getMoneyForUser() : 0 }}$
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Money Account"><i class="fa fa-credit-card fa-fw"></i>
                                </button>
                            </td>
                            <td>
                                {{ ($model->getMoneyAccountCurrent()) ? $model->getMoneyAccountCurrent() : 0 }}$
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 1%;">
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Status lock"><i class="glyphicon glyphicon-phone"></i>
                                </button>
                            </td>
                            <td>
                                <span class="label {{ ($model->status_lock == 0) ? "label-primary" : "label-danger" }}">
                                    {{ ($model->status_lock == 0) ? "OKIE" : "LOCKED"  }}
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-dashboard"></i>Information</h3>
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="width: 1%;">
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Name"><i class="glyphicon glyphicon-user"></i>
                                </button>
                            </td>
                            <td>{{ $model->first_name }}  {{ $model->last_name }}</td>
                        </tr>

                        <tr>
                            <td style="width: 1%;">
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Email"><i class="glyphicon glyphicon-envelope"></i>
                                </button>
                            </td>
                            <td>{{ $model->email }}</td>
                        </tr>

                        <tr>
                            <td style="width: 1%;">
                                <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                        data-original-title="Update money"><i class="glyphicon glyphicon-save"></i>
                                </button>
                            </td>
                            <form method="post" action="{{ URL::route('admin.userManagement.updateMoney', ["id" => $model->id]) }}">
                                <td>
                                    <button class="btn btn-primary btn-xs" data-toggle="confirmation" data-title="Update money ?">
                                        Update money
                                    </button>    

                                </td>
                            </form>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Money for customer's</h3>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#total_bonus">Bonus</a></li>
                <li><a data-toggle="tab" href="#spending">Spending</a></li>
            </ul>

            <div class="tab-content">
                <div id="total_bonus" class="tab-pane fade  in active">
                    @include('admin::userManagement.includes.tab_admin_bonus')
                </div>
                <div id="spending" class="tab-pane fade">
                    @include('admin::userManagement.includes.tab_admin_spending')
                </div>
            </div>
        </div>
    </div>
</div>

@stop