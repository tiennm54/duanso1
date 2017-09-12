<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php if($model->image){ ?>
            <img src="<?php echo url('images/'.$model->image); ?>" width="200px">
            <?php }?>
        </div>
    </div>
</div>