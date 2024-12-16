<!--
    --------------------------Report page----------------------------
-->

@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="<?php echo URL::route('admin.index'); ?>" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Back">
                <i class="fa fa-reply"></i>
            </a>
        </div>
        <h1>REPORT</h1>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo URL::route("admin.index"); ?>">Home</a>
            </li>
            <li>
                <a href="">LIST IP SCAM</a>
            </li>
        </ul>
    </div>
</div>


<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>LIST IP BANNED</h3>
        </div>
        <div class="panel-body">



            <div class="well">
                <div class="row">                    
                    <form action="<?php echo URL::route('admin.blackListIp.create');?>" method="post" enctype="multipart/form-data">                        
                        <div class="col-sm-4">                            
                            <div class="form-group">                                
                                <label class="control-label">IP Ban</label>                                
                                <input type="text" class="form-control border-input" name="ip_ban" required>                            
                            </div>                        
                        </div>                       
                        <div class="col-sm-1">                            
                            <div class="form-group">                                
                                <label class="control-label">Create</label>                                
                                <div>                                    
                                    <button type="submit" class="btn btn-primary">Create</button>                                
                                </div>                            
                            </div>                        
                        </div>                 
                    </form>                
                </div>      
            </div>

        </div>

        <div class="panel-body">
            @include('validator.flash-message')
            <div class="table-responsive">
                <form action="" method="get" enctype="multipart/form-data" id="form-category">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">IP Ban</th>
                                <th class="text-center">Sort IP</th>
                                <th class="text-center">Action</th>
                            </tr>
                            
                            <tr>
                                <th></th>
                                <th class="text-center">
                                    <input class="form-control border-input" 
                                           placeholder="Search IP"
                                           name="user_ip"
                                           value="<?php echo (app('request')->input('user_ip')) ? app('request')->input('user_ip') : ""; ?>"
                                           />
                                </th>
                                <th></th>
                                <th class="text-center">
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">Search</button>
                                </th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <?php foreach ($model as $key => $item): ?>

                                <tr>
                                    <td class="text-center"><?php echo $key + 1; ?></td>
                                    <td class="text-center"><?php echo $item->user_ip; ?></td>
                                    <td class="text-center"><?php echo $item->short_ip; ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this item?');"
                                           href="<?php echo URL::route('admin.blackListIp.delete', $item->id); ?>">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <?php
        echo $model->appends([
            'user_ip' => Request::get('user_ip'),
        ])->render();
        ?>
    </div>
</div>
</div>

@stop

