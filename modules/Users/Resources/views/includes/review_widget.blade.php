<div class="form-review">
    <span class="review-now">Review now</span>
    <input type="hidden" class="action-rating-review" value="" style="display: block; float: left"/>
</div>

<div id="review">
    <?php foreach ($model_reviews as $item): ?>
        <div class="well">
            <p>
                <b><?php echo $item->review_name; ?></b>
                <span class="rating">
                    <span class="fa fa-stack"><i class="fa {{ ($item->review_rate >= 0) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa {{ ($item->review_rate >= 1) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa {{ ($item->review_rate >= 2) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa {{ ($item->review_rate >= 3) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                    <span class="fa fa-stack"><i class="fa {{ ($item->review_rate >= 4) ? "fa-star" : "fa-star-o" }} fa-stack-1x"></i></span>
                </span>
                <span> <?php echo $item->created_at; ?> </span>
            </p>
            <p>
                <span><?php echo $item->review_des; ?></span>
            </p>
        </div>
    <?php endforeach; ?>
    
    <?php echo $model_reviews->render();?>
</div>

<!-- The Modal -->
<div class="modal fade" id="myModalReview">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Reviews</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="form-rate" method="post" action="{{ URL::route('users.review.rateWebsite') }}">
                    <input name="review_rate" type="hidden" class="rating-review-show" id="rating-review-show"/>
                    <hr>

                    <div class="form-group">
                        <label class="control-label">Your Name</label>
                        <input type="text" class="form-control" name="review_name"  minlength="3" maxlength="100" 
                               title="Please enter your name" placeholder="Your name" 
                               value="{{  old('review_name', ($model_user) ? $model_user->first_name." ".$model_user->last_name : "") }}"
                               required="">
                        <span class="help-block"></span>
                        {!! $errors->first('review_name','<span class="control-label color-red" style="color: red">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Your Email</label>
                        <input type="email" class="form-control" name="review_email" maxlength="100" 
                               title="Please enter your email" placeholder="example@gmail.com" 
                               value="{{  old('review_email', ($model_user) ? $model_user->email : "") }}"
                               required="">
                        <span class="help-block"></span>
                        {!! $errors->first('review_email','<span class="control-label color-red" style="color: red">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Your review</label>
                        <textarea class="form-control" name="review_des" rows="5" minlength="10" placeholder="Share your honest experience and help orthers make better choices." required></textarea>
                        <span class="help-block"></span>
                        {!! $errors->first('review_des','<span class="control-label color-red" style="color: red">:message</span>') !!}
                    </div>
                    <input name="review_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" type="hidden"/>

                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="form-rate">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        $(".action-rating-review").rating();
        $(".rating-review-show").rating();
    });

    $('.action-rating-review').on('change', function () {
        var rate = $(this).val();
        $("#myModalReview").modal();
        $("#rating-review-show").data('rating').update(rate);
    });
</script>