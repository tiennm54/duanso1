<form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo URL::route('frontend.news.comment', ['id' => $model->id]); ?>">
    <fieldset>
        <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email">E-Mail Address</label>
            <div class="col-sm-10">
                <input type="email" name="email" placeholder="E-Mail Address" class="form-control" value="{{ old('email', isset($model_user) ? $model_user->email : '') }}" required>
                {!! $errors->first('email','<span class="control-label color-red" style="color: red">:message</span>') !!}
            </div>
        </div>

        <div class="form-group required">
            <label class="col-sm-2 control-label">Comment (<span class="count-characters">0</span>)</label>
            <div class="col-sm-10">
                <textarea type="text" rows="5" name="comment" class="form-control des-comment" placeholder="The comment must be at least 10 characters."  onkeyup="countCharactersComment()" required>{{ old('comment') }}</textarea>
                {!! $errors->first('comment','<span class="control-label color-red" style="color: red">:message</span>') !!}
            </div>
        </div>

        <div class="form-group required">
            <label class="col-sm-2 control-label">Captcha</label>
            <div class="col-sm-10">
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
