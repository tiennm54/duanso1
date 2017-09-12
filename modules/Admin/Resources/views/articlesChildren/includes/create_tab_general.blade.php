<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control border-input" placeholder="Title..." name="txt_title" value="" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Code</label>
            <input type="text" class="form-control border-input" placeholder="Code..." name="txt_code" value="" required>
        </div>
    </div>


</div>

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label>Price Order</label>
            <input type="number" step="any" class="form-control border-input" placeholder="Price..." name="decimal_price_order" value="" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Stock</label>
            <select class="form-control border-input" name="int_instock">
                <option value="1">In Stock</option>
                <option value="0">Not In Stock</option>
            </select>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <textarea class="form-control border-input textarea" name="txt_description" id="txt_description"></textarea>
        </div>
    </div>
</div>
