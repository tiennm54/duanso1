
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label>Category: </label>
            <span>{{ $model->getCategory->name }}</span>
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
            <span>{{ $model->brand }}</span>
        </div>
    </div>


    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Description: </label>
            <span>{!! $model->description !!}</span>
        </div>
    </div>

</div>

