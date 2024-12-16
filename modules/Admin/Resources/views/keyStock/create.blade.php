@extends('backend.master')@section('content')
<div class="page-header">    
    <div class="container-fluid">    

        <div class="pull-right">

            <a href="{{URL::route('import.getImport', ['id' => $model_product->id ])}}" data-toggle="tooltip"
               class="btn btn-primary" data-original-title="Import Premium Key">
                <i class="glyphicon glyphicon-save"></i>
            </a>

            <a href="<?php echo URL::route('articles.view', ['id' => $model_product->getArticles->id, 'url' => $model_product->url_title . '.html']); ?>" data-toggle="tooltip"
               class="btn btn-default" data-original-title="Back">
                <i class="fa fa-reply"></i>
            </a>

        </div>

        <h1>STOCK: <?php echo $model_product->title; ?></h1>        
        <ul class="breadcrumb">            
            <li>                
                <a href="{{ URL::route('admin.index') }}">Home</a>            
            </li>            
            <li>                
                <a>Key stock manager</a>            
            </li>        
        </ul>    
    </div>
</div>
<div class="container-fluid">    
    @include('validator.flash-message')    
    <div class="alert alert-success" style="display: none">    
    </div>    
    <div class="panel panel-default">        
        <div class="panel-heading">            
            <h3 class="panel-title"><i class="fa fa-list"></i>Key Stock: <?php echo $model_product->title; ?></h3>  
            
            <div class="row pull-right">   
                  
                <div class="col-sm-6">
                    <a href="<?php echo URL::route('articles.view', ['id' => $model_product->getArticles->id, 'url' => $model_product->url_title . '.html']); ?>" class="btn btn-default btn-xs pull-right">Back Product</a>    
                </div>
                
                <div class="col-sm-4">
                    <div>                                    
                        <a href="<?php echo $model_product->getArticles->reseller_page; ?>" class="btn btn-primary btn-xs pull-left" target="_blank">Reseller Page</a>                                
                    </div>  
                </div>
            </div> 

        </div>        
        <div class="panel-body">            
            <div class="well">                
                <div class="row">                    
                    <form action="<?php echo URL::route('admin.keyStock.postCreate', ['id' => $model_product->id]); ?>" method="post" enctype="multipart/form-data">                        
                        <div class="col-sm-4">                            
                            <div class="form-group">                                
                                <label class="control-label">Premium Key</label>                                
                                <input type="text" class="form-control border-input" name="premiumKey" required>                            
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

                    <form action="<?php echo URL::route('admin.keyStock.saveUnPaid', ['id' => $model_product->id]); ?>" method="post" enctype="multipart/form-data">
                        <div class="pull-right">                            
                            <div class="form-group">    
                                <label class="control-label">Refund: <?php echo $count_unpaid_refund; ?> key</label>
                                <div>                                    
                                    <button type="submit" class="btn btn-danger pull-right btn-xs" data-toggle="confirmation">UnPaid <?php echo $count_unpaid; ?> Key </button>                                
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
                            <td width="20%">Premium Key</td>                            
                            <td>Premium Type</td>                            
                            <td>Status</td>                            
                            <td>Invoice ID</td>                            
                            <td>User Activated</td>   
                            <td>Status Paid</td>
                            <td width="12%">Action</td>                        
                        </tr>                        
                        <tr>                            
                    <form action="" method="get">                                
                        <td>                                    
                            <input class="form-control" name="searchKey" value="<?php echo (app('request')->input('searchKey')) ? app('request')->input('searchKey') : ""; ?>"/>                                
                        </td>                                
                        <td></td>                                
                        <td class="text-center">
                            <select name="searchStatus">                                        
                                <option value="Pending">Pending</option>                                        
                                <option value="Activated">Activated</option>                                    
                                <option value="Refund">Refund</option>                                    
                            </select>
                        </td>                                
                        <td>
                            <input class="form-control" name="searchInvoice" value="<?php echo (app('request')->input('searchInvoice')) ? app('request')->input('searchInvoice') : ""; ?>"/>
                        </td>                                
                        <td>
                            <input class="form-control" name="searchUser" value="<?php echo (app('request')->input('searchUser')) ? app('request')->input('searchUser') : ""; ?>"/>
                        </td>          

                        <td></td> 

                        <td>                                    
                            <button type="submit" class="btn btn-primary btn-xs">Search</button>                                    
                            <a href="<?php echo URL::route('admin.keyStock.getCreate', ['id' => $model_product->id]); ?>" class="btn btn-default pull-right btn-xs">Reset</a>                                
                        </td>                            
                    </form>                        
                    </tr>                    
                    </thead>                    
                    <tbody>                        
                        <?php if (count($model) == 0): ?>                             
                            <tr>                                
                                <td colspan="8">Không có bản ghi nào</td>                            
                            </tr>                      
                        <?php endif; ?>                        
                        <?php foreach ($model as $key => $item): ?>                                                
                        <form method="post" action="<?php echo URL::route('admin.keyStock.saveStatusKey', ['id' => $item->id]); ?>">                            
                            <tr>                                
                                <td>                                    
                                    <?php echo $item->premium_key; ?>                                
                                </td>                                
                                <td class="text-center">{{ $item->articles_type_title }}</td>                                
                                <td class="text-center">                                    
                                    <select name="statusKey">                                        
                                        <option value="Pending" <?php echo ($item->status == "Pending") ? "selected" : ""; ?>>Pending</option>                                        
                                        <option value="Activated" <?php echo ($item->status == "Activated") ? "selected" : ""; ?>>Activated</option>                                    
                                        <option value="Refund" <?php echo ($item->status == "Refund") ? "selected" : ""; ?>>Refund</option>                                    
                                    </select>                                
                                </td>                                
                                <td class="text-center"><?php echo ($item->invoice != "" || $item->invoice != null) ? $item->invoice : "None" ?></td>                                
                                <td class="text-center"><?php echo ($item->user_activated_email != "" || $item->user_activated_email != null) ? $item->user_activated_email : "None" ?></td>                                

                                <td class="text-center">                                    
                                    <select name="statusPaid">                                        
                                        <option value="0" <?php echo ($item->status_paid == "0") ? "selected" : ""; ?>>UnPaid</option>                                        
                                        <option value="1" <?php echo ($item->status_paid == "1") ? "selected" : ""; ?>>Paid</option>                                    
                                    </select>                                
                                </td>   

                                <td class="text-center">                                                                    
                                    <button type="submit" class="btn btn-primary" data-toggle="confirmation">                                        
                                        <i class="fa fa-save"></i>                                    
                                    </button>                                                                        
                                    <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo URL::route('admin.keyStock.delete', ['id' => $item->id]); ?>">                                        
                                        <i class="fa fa-trash-o"></i>                                    
                                    </a>                                
                                </td>                            
                            </tr>                        
                        </form>                                                
                    <?php endforeach; ?> 
                    </tbody>              
                </table>                
                <?php echo $model->appends(['searchKey' => Request::get('searchKey')])->render(); ?>            
            </div>        
        </div>    
    </div>
</div>
@stop