<div id="editComment" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit your comment</h4>
                
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo URL::route('frontend.news.editComment'); ?>">
                    <fieldset>
                        <input id="id_comment_edit" name="id_comment_edit" type="hidden"/>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label">Comment (<span class="count-characters-edit">0</span>)</label>
                            <div class="col-sm-9">
                                <textarea type="text" rows="5" name="comment_edit" id="comment_edit" class="form-control des-comment-edit" placeholder="The comment must be at least 10 characters."  onkeyup="countCharactersEditComment()" required>{{ old('comment_reply') }}</textarea>
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
    function countCharactersEditComment() {
        var des = $(".des-comment-edit").val();
        var count = des.length;
        $(".count-characters-edit").text(count)
    }
</script>