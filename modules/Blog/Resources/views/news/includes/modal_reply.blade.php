<div id="replyNews" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span id="header_email_comment" class="label label-default"></span> said: <span id="header_comment"></span></h4>

            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo URL::route('frontend.news.commentReply', ['id' => $model->id]); ?>">
                    <fieldset>
                        <input id="id_comment" name="id_comment" type="hidden"/>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Reply (<span class="count-characters-reply">0</span>)</label>
                            <div class="col-sm-9">
                                <textarea type="text" rows="5" name="comment_reply" class="form-control des-comment-reply" placeholder="The comment must be at least 10 characters."  onkeyup="countCharactersCommentReply()"  required>{{ old('comment_reply') }}</textarea>
                                {!! $errors->first('comment_reply','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-email">Your email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email_reply" placeholder="E-Mail Address" class="form-control" value="{{ old('email_reply',isset($model_user) ? $model_user->email : '') }}" required>
                                {!! $errors->first('email_reply','<span class="control-label color-red" style="color: red">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Captcha</label>
                            <div class="col-sm-9">
                                {!! Captcha::display($attributes) !!}
                                {!! $errors->first('g-recaptcha-response','<span class="control-label color-red" style="color: red">:message</span>') !!}
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
    function countCharactersCommentReply() {
        var des = $(".des-comment-reply").val();
        var count = des.length;
        $(".count-characters-reply").text(count)
    }
</script>