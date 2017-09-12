@include('validator.flash-message')
<form action="{{ URL::route('articlesChildren.addKeyToProduct',['id' => $model->id ]) }}" method="POST">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control border-input" placeholder="Điền key vào đây" name="product_key" required/>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-original-title="Add Product Key"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Key</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($model_key) == 0):?>
        <tr>
            <td colspan="5">Không có key nào cho sản phẩm này!</td>
        </tr>
        <?php endif;?>
        <?php foreach ($model_key as $item):?>
        <tr>
            <td>{{ $model->title }}</td>
            <td>{{ $item->key }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->created_at }}</td>
            <td>#</td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>