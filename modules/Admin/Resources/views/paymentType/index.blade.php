@extends('backend.master')
@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="{{ URL::route('paymentType.getCreate') }}" data-toggle="tooltip" title=""
                   class="btn btn-primary" data-original-title="Add New">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <h1>Payment Type</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <a href="">List Payment</a>
                </li>
            </ul>
        </div>
    </div>


    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i>Payment Type</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Position</th>
                                    <th>Fees</th>
                                    <th>Disabled</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($model as $key=>$item):?>

                            <tr>
                                <td><?php echo $key+1;?></td>
                                <td><img src="{{ url('images/'.$item->image) }}"></td>
                                <td><?php echo $item->title;?></td>
                                <td><?php echo $item->description;?></td>
                                <td><?php echo $item->position;?></td>
                                <td><?php echo $item->fees;?></td>
                                <td>
                                    <?php
                                    switch ($item->status_disable){
                                        case 0: echo "No disable"; break;
                                        case 1: echo "Disabled"; break;
                                    }
                                    ?>
                                </td>

                                <td>
                                    <a class="btn btn-primary" href="<?php echo URL::route('paymentType.getEdit', $item->id); ?>"><i class="fa fa-edit"></i></a>
                                    <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo URL::route('paymentType.delete', $item->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>

                            <?php endforeach; ?>


                            </tbody>
                        </table>

            </div>
        </div>
    </div>
@stop
