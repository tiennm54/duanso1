<ul class="media-list">
    <?php if (count($model_comment) == 0): ?>
        <h4>Let us know your opinion. Thanks you!</h4>
    <?php endif; ?>
    <?php foreach ($model_comment as $comment): ?>
        <li class="media <?php echo ($comment->reply_email) ? "class-reply" : ""; ?>">
            <a class="pull-left">
                <img class="media-object img-circle <?php echo ($comment->reply_email) ? "image-reply" : "image-comment"; ?>" src="{{url('images/avatar/'.$comment->avatar)}}" alt="Buy Premium Key">
            </a>
            <div class="media-body">
                <div class="well well-lg">

                    <h4 class="media-heading reviews">
                        <span class="label <?php echo ($comment->type == 1) ? "label-danger" : "label-default" ?>">
                            <?php echo $comment->email; ?>: <?php echo $comment->created_at; ?>
                        </span> 
                    </h4>

                    <p class="media-comment" style="font-size: 15px; margin: 10 0 10 0; font-weight: bold">
                        <span style="color: blue"><?php echo ($comment->reply_email) ? "@" . $comment->reply_email . ": " : ""; ?></span> 
                        <span><?php echo $comment->comment; ?></span>
                    </p>

                    <a style="cursor: pointer" data-toggle="modal" data-target="#replyNews" onclick="replyComment('<?php echo $comment->id; ?>', '<?php echo $comment->email; ?>', '<?php echo $comment->comment; ?>')">
                        <span class="glyphicon glyphicon-share-alt"></span> Reply
                    </a>
                    <?php if ($model_user && $model_user->email == $comment->email) { ?>
                        <a style="cursor: pointer" data-toggle="modal" data-target="#editComment" onclick="editComment('<?php echo $comment->id; ?>', '<?php echo $comment->comment; ?>')">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                    <?php } ?>

                </div>              
            </div>
        </li>          
    <?php endforeach; ?>
</ul> 

<style>
    .class-reply{
        margin-left: 8rem;
    }
    .image-comment{
        width: 140px; height: 140px;
    }
    .image-reply{
        width: 100px; height: 100px;
    }
</style>