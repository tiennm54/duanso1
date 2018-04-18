@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <h1>CREATE BONUS CONFIG</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a>Bonus config</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    @include('validator.flash-message')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Create bonus config</h3>
        </div>
        <div class="panel-body">
            <div class="well">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Bonus for ref (%)</label>
                                <input type="number" value="{{ ($model) ? $model->bonus_reg : 0 }}" name="bonus_reg" placeholder="Bonus for ref (%)" class="form-control" required>
                                {!! $errors->first('bonus_ref','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Bonus for sponsor (%)</label>
                                <input type="number" value="{{ ($model) ? $model->bonus_sponsor : 0 }}" name="bonus_sponsor" placeholder="Bonus for sponsor (%)" class="form-control" required>
                                {!! $errors->first('bonus_sponsor','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Bonus basic (%)</label>
                                <input type="number" value="{{ ($model) ? $model->bonus_basic : 0 }}" name="bonus_basic" placeholder="Bonus basic (%)" class="form-control" required>
                                {!! $errors->first('bonus_basic','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Create</label>
                                <div>
                                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop