@extends('backend.master')
@section('content')
    <div class="container-fluid">


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">List Category</h4>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped">
                            <thead>
                            <tr><th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>SEO Title</th>
                                <th>SEO Description</th>
                                <th>Action</th>
                            </tr></thead>
                            <tbody>


                            <?php foreach($model as $key=>$item):?>

                            <tr>
                                <td><?php echo $key+1;?></td>
                                <td><?php echo $item->name;?></td>
                                <td><?php echo $item->description;?></td>
                                <td><?php echo $item->seo_title;?></td>
                                <td><?php echo $item->seo_description;?></td>

                                <td>
                                    <a style="cursor: pointer" href="<?php echo URL::route('category.getEdit', $item->id); ?>">Edit | </a>
                                    <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo URL::route('category.delete', $item->id); ?>" style="cursor: pointer">Delete</a>
                                </td>
                            </tr>

                            <?php endforeach; ?>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
