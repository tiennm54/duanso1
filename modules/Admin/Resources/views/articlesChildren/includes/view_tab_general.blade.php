<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php if($model_articles->image){ ?>
            <img src="<?php echo url('images/'.$model_articles->image); ?>" width="200px">
            <?php }?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Category: </label>
            <span>{{ $model_articles->getCategory->name }}</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Stock: </label>
            <?php if ($model->status_stock == 1){ ?>
            <span style="color: blue">In Stock</span>
            <?php }else{ ?>
            <span style="color: red">Not In Stock</span>
            <?php }?>
        </div>
    </div>



    <div class="col-md-4">
        <div class="form-group">
            <label>Title: </label>
            <span>{{ $model->title }}</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Code: </label>
            <span>{{ $model->code }}</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Brand: </label>
            <span>{{ $model_articles->brand }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Price: </label>
            <span style="font-weight: bolder">{{ $model->price_order }}$</span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Description: </label>
            <span>{!! $model->description !!}</span>
        </div>
    </div>


</div>