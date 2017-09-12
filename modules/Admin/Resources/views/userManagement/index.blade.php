@extends('backend.master')
@section('content')
    <div class="page-header">
        <div class="container-fluid">

            <div class="pull-right">
                <a href="{{ URL::route('admin.userManagement.getCreate') }}" data-toggle="tooltip" title="Add new"
                   class="btn btn-primary" data-original-title="Add New">
                    <i class="fa fa-plus"></i>
                </a>

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
                <h3 class="panel-title"><i class="fa fa-list"></i> Create Infomation</h3>
            </div>
            <div class="panel-body">

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

                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label class="control-label">Search</label>
                                    <div>
                                        <button type="submit" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Filter</button>
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
                            <td class="text-left"><a>Created At</a></td>
                            <td class="text-left"><a>Updated At</a></td>
                            <td class="text-right">Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model as $key => $item):?>
                        <tr>
                            <td class="text-left">{{ $key + 1 }}</td>
                            <td class="text-left">{{ $item->email }}</td>
                            <td class="text-left">{{ $item->first_name." ".$item->last_name }} </td>
                            <td class="text-left">{{ $item->created_at }}</td>
                            <td class="text-left">{{ $item->updated_at }}</td>
                            <td class="text-right">
                                <a href="" data-toggle="tooltip" title="" class="btn btn-primary"
                                   data-original-title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php echo $model->appends(['filter_name' => Request::get('filter_name') , 'filter_email' => Request::get('filter_email')])->render(); ?>

                </div>
            </div>
        </div>
    </div>



@stop