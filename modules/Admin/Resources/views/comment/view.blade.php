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
            <li><a href="{{ URL::route('admin.comment.index')}}">List Comment</a></li>
            <li><a>Reply Comment</a></li>
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="2">Comment Detail</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>News title</td>
                            <td>
                                <a href="<?php echo $model->getNews->getUrl(); ?>">
                                       <?php echo $model->getNews->title; ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>User Comment</td>
                            <td><?php echo $model->email; ?></td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td><?php echo $model->comment; ?></td>
                        </tr>
                        <tr>
                            <td>Status reply</td>
                            <td>
                                <?php if ($model->status_admin_reply == 1) { ?>
                                    <span class="label label-primary">OK</span>
                                <?php } else { ?>
                                    <span class="label label-danger">NO</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Created at</td>
                            <td><?php echo $model->created_at; ?></td>
                        </tr>
                        <tr>
                            <td>Disable</td>
                            <td>
                                <form method="post" action="<?php echo URL::route('admin.comment.disableComment', ['id' => $model->id]); ?>">
                                    <div class="col-md-6">
                                        <select class="form-control" name="status_disable" style="margin-left: -15px">
                                            <option value="0" <?php echo ($model->status_disable == 0) ? "selected" : ""; ?> >Show</option>
                                            <option value="1" <?php echo ($model->status_disable == 1) ? "selected" : ""; ?> >Disable</option>
                                        </select>    
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>Reply</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <form method="post" action="<?php echo URL::route('admin.comment.reply', ['id' => $model->id]); ?>">
                    <div class="col-md-8">
                        <textarea class="form-control" name="reply_comment"></textarea>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i>List Reply</h3>
        </div>
        <div class="panel-body">
            <ul class="media-list">
                <?php if (count($model_reply) == 0): ?>
                    <h4>Let us know your opinion. Thanks you!</h4>
                <?php endif; ?>
                <?php foreach ($model_reply as $comment): ?>
                    <li class="media">
                        <a class="pull-left">
                            <img class="media-object img-circle" src="{{url('images/avatar/'.$comment->avatar)}}" alt="Buy Premium Key" style="width: 100px; height: 100px;">
                        </a>
                        <div class="media-body">
                            <div class="well well-lg">

                                <h4 class="media-heading reviews">
                                    <span class="label label-default">
                                        <?php echo $comment->email; ?>: <?php echo $comment->created_at; ?>
                                    </span> 
                                </h4>

                                <p class="media-comment" style="font-size: 15px; margin: 10 0 10 0; font-weight: bold">
                                    <span style="color: blue"><?php echo ($comment->reply_email) ? "@" . $comment->reply_email . ": " : ""; ?></span> 
                                    <span><?php echo $comment->comment; ?></span>
                                </p>

                                <a class="btn btn-info btn-circle" data-toggle="modal" data-target="#editComment" onclick="editComment('<?php echo $comment->id; ?>', '<?php echo $comment->comment; ?>')">
                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                </a>

                                <a class="btn btn-danger btn-circle" href="<?php echo URL::route('admin.comment.delete',['id'=>$comment->id]); ?>" data-toggle="confirmation">
                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                </a>

                            </div>              
                        </div>
                    </li>          
                <?php endforeach; ?>
            </ul> 
        </div>
    </div>
</div>


<div id="editComment" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Comment: <span id="header_comment_edit"></span></h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo URL::route('admin.comment.editComment'); ?>">
                    <fieldset>
                        <input id="id_comment_edit" name="id_comment_edit" type="hidden"/>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Comment (<span id="count-characters-reply">0</span>)</label>
                            <div class="col-sm-9">
                                <textarea type="text" rows="5" name="comment_edit" id="comment_edit" class="form-control" onkeyup="countCharactersReply()" required>{{ old('comment_edit') }}</textarea>
                                {!! $errors->first('comment_edit','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>
                    </fieldset>
                    <div class="buttons clearfix">
                        <div class="pull-right">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function countCharactersReply() {
        var des = $("#comment_edit").val();
        var count = des.length;
        $("#count-characters-reply").text(count)
    }
    function editComment(id, comment) {
        $("#id_comment_edit").val(id);
        $("#comment_edit").val(comment);
        $("#header_comment_edit").html(comment);
    }
</script>

@stop
