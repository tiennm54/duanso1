@extends('backend.master')
@section('content')

    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="<?php echo URL::route('articles.getCreate'); ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add New">
                    <i class="fa fa-plus"></i>
                </a>
                <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild">
                    <i class="fa fa-refresh"></i>
                </a>

            </div>
            <h1>Product</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="">Home</a>
                </li>
                <li>
                    <a href="">Product</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> Product List</h3>
            </div>
            <div class="panel-body">
                <form action="" method="get" enctype="multipart/form-data" id="form-category">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>


                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Code</th>
                                <th>Brand</th>
                                <th>Status Stock</th>
                                <th width="15%">Action</th>
                            </tr>

                            <tr>
                                <th></th>
                                <th>
                                    <input class="form-control border-input" placeholder="Search Title"
                                           name="txt_title"/>
                                </th>
                                <th>
                                    <input class="form-control border-input" placeholder="Search Code"
                                           name="txt_code"/>
                                </th>
                                <th>
                                    <input class="form-control border-input" placeholder="Search Brand"
                                           name="txt_brand"/>
                                </th>

                                <th>
                                    <select class="form-control border-input" name="int_status_stock">
                                        <option value="">Select Status</option>
                                        <option value="1">In Stock</option>
                                        <option value="0">Not In Stock</option>
                                    </select>
                                </th>

                                <th>
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">Search</button>
                                </th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php foreach($model as $key=>$item):?>

                            <tr>
                                <td><img src="<?php echo url('images/' . $item->image); ?>" width="100px"></td>
                                <td><?php echo $item->title;?></td>
                                <td><?php echo $item->code;?></td>
                                <td><?php echo $item->brand;?></td>

                                <td><?php
                                    switch ($item->status_stock) {
                                        case 1:
                                            echo "In Stock";
                                            break;
                                        case 0:
                                            echo "Not In Stock";
                                            break;
                                    }
                                    ?></td>
                                <td>
                                    <a class="btn btn-primary"
                                       href="<?php echo URL::route('articles.getEdit', ['id' => $item->id, 'url'=> $item->url_title.'.html']); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a class="btn btn-primary"
                                       href="<?php echo URL::route('articles.view', ['id' => $item->id, 'url'=> $item->url_title.'.html']); ?>" target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a class="btn btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this item?');"
                                       href="<?php echo URL::route('category.delete', $item->id); ?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>

                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="row">

                </div>
            </div>
        </div>
    </div>

@stop
