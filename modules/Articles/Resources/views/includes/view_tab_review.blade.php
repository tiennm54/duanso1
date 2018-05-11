<form action="{{ URL::route('frontend.articles.reviewProduct') }}" method="post"  enctype="multipart/form-data" class="form-horizontal">

    <div id="review">

        <?php if (count($model->getReview) == 0) { ?>
            <p>There are no reviews for this product.</p>
        <?php } else { ?>

            <?php foreach ($model->getReview as $item): ?>
                <div class="well">
                    <p>
                        <b>{{ $item->full_name }}: </b><span> {{ $item->created_at }} </span>
                    </p>
                    <p>
                        <span>{{ $item->description }}</span>
                    </p>
                    <div class="rating">

                        <span>
                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
                            <span class="fa fa-stack"><i class="fa {{ ($item->rate >= 2) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                            <span class="fa fa-stack"><i class="fa {{ ($item->rate >= 3) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                            <span class="fa fa-stack"><i class="fa {{ ($item->rate >= 4) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                            <span class="fa fa-stack"><i class="fa {{ ($item->rate >= 5) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php } ?>



    </div>
    <h2>Write a review</h2>
    <div class="form-group required">
        <div class="col-sm-12">
            <input name="product_id" value="{{  $model->id }}" hidden>
            <label class="control-label" for="input-name">Your Name</label>
            <input type="text" name="name" class="form-control" placeholder="The name must be at least 3 characters" value="{{  old('name', ($model_user) ? $model_user->first_name." ".$model_user->last_name : "") }}" required>
            {!! $errors->first('name','<span class="control-label color-red" style="color: red">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required">
        <div class="col-sm-12">
            <label class="control-label" for="input-name">Your Email</label>
            <input type="email" name="email" class="form-control" placeholder="Your email" value="{{  old('email', ($model_user) ? $model_user->email : "") }}" required>
            {!! $errors->first('email','<span class="control-label color-red" style="color: red">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required">
        <div class="col-sm-12">
            <label class="control-label" for="input-review">Your Review (<span id="count-characters">0</span> characters)</label>
            <textarea type="text" name="description" rows="5" class="form-control" placeholder="The description must be at least 20 characters." onkeyup="countCharacters()" id="desReviewId" required>{{ old('description') }}</textarea>
            <div class="help-block"><span class="text-danger">Note:</span> HTML is not translated!</div>
            {!! $errors->first('description','<span class="control-label color-red" style="color: red">:message</span>') !!}
        </div>
    </div>
    <div class="form-group required">
        <div class="col-sm-12">
            <label class="control-label">Rating</label>
            &nbsp;&nbsp;&nbsp; Bad&nbsp;
            <input type="radio" name="rating" value="1" required >
            &nbsp;
            <input type="radio" name="rating" value="2">
            &nbsp;
            <input type="radio" name="rating" value="3">
            &nbsp;
            <input type="radio" name="rating" value="4">
            &nbsp;
            <input type="radio" name="rating" value="5" checked>
            &nbsp;  Good

            {!! $errors->first('rating','<span class="control-label color-red" style="color: red">:message</span>') !!}
        </div>
    </div>

    <div class="form-group required">
        <div class="col-sm-12">
            <label class="control-label">Captcha</label>

            {!! Captcha::display($attributes) !!}
            {!! $errors->first('g-recaptcha-response','<span class="control-label color-red" style="color: red">:message</span>') !!}

        </div>
    </div>

    <div class="buttons clearfix">
        <div class="pull-right">
            <button type="submit" data-loading-text="Loading..."  class="btn btn-primary">Continue</button>
        </div>
    </div>
</form>

<script>
    function countCharacters() {
        var des = $("#desReviewId").val();
        var count = des.length;
        $("#count-characters").text(count)
    }
</script>