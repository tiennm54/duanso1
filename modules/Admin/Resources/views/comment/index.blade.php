@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="pull-right">
            <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild">
                <i class="fa fa-refresh"></i>
            </a>
        </div>
        <h1>Comment Manager</h1>
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('admin.index')}}">Dashboard</a></li>
            <li><a>Comment</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Comment List</h3>
        </div>
        <div class="panel-body">
            @include('validator.validator-input')
            @include('validator.flash-message')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>News title</th>
                            <th>User Comment</th>
                            <th>Comment</th>
                            <th>Disable</th>
                            <th>Status reply</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $key => $item): ?>
                        <form method="post" action="<?php echo URL::route('admin.comment.disableComment', ['id' => $item->id]); ?>">
                            <tr>
                                <td>
                                    <a href="<?php echo $item->getNews->getUrl(); ?>">
                                           <?php echo substr($item->getNews->title, 0, 30) . "..."; ?>
                                    </a>
                                </td>
                                <td><?php echo $item->email; ?></td>
                                <td><?php echo $item->comment; ?></td>
                                <td>
                                    <select class="form-control" name="status_disable">
                                        <option value="0" <?php echo ($item->status_disable == 0) ? "selected" : ""; ?> >Show</option>
                                        <option value="1" <?php echo ($item->status_disable == 1) ? "selected" : ""; ?> >Disable</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <?php if ($item->status_admin_reply == 1) { ?>
                                        <span class="label label-primary">OK</span>
                                    <?php } else { ?>
                                        <span class="label label-danger">NO</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i>
                                    </button>
                                    <a class="btn btn-primary" href="<?php echo URL::route('admin.comment.view', ['id' => $item->id]); ?>" target="_blank">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-danger btn-circle" href="<?php echo URL::route('admin.comment.delete', ['id' => $item->id]); ?>" data-toggle="confirmation">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>

                            </tr>
                        </form>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            {!! $model->render() !!}
        </div>
    </div>
</div>

@stop
