<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control border-input" placeholder="Title..." name="txt_title" value="{{ ($model->title) ? $model->title : "" }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>URL Title</label>
            <input type="text" class="form-control border-input" placeholder="Title..." name="txt_url_title" value="{{ ($model->url_title) ? $model->url_title : "" }}" disabled>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Code</label>
            <input type="text" class="form-control border-input" placeholder="Code..." name="txt_code" value="{{ ($model->code) ? $model->code : "" }}">
        </div>
    </div>


</div>

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label>Price Order</label>
            <input type="number" step="any" class="form-control border-input" placeholder="Price..." name="decimal_price_order" value="{{ ($model->price_order) ? $model->price_order : 0 }}">
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label>Price Reseller</label>
            <input type="number" step="any" class="form-control border-input" placeholder="Price Reseller..." name="price_reseller" value="{{ ($model->price_reseller) ? $model->price_reseller : 0 }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Stock</label>
            <select class="form-control border-input" name="int_instock">
                <option value="1" {{ ($model->status_stock == 1) ? "selected" : "" }}>In Stock</option>
                <option value="0" {{ ($model->status_stock == 0) ? "selected" : "" }}>Not In Stock</option>
            </select>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <textarea class="form-control border-input textarea" name="txt_description" id="txt_description">{!! ($model->description) ? $model->description : "" !!}</textarea>
        </div>
    </div>
</div>
