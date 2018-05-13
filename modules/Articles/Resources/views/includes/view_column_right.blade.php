<div class="col-sm-3">
    <div class="list-group">
        <a href="" class="list-group-item active">Product ({{ count($model_list_product) }})</a>
        <?php foreach ($model_list_product as $item):?>
            <a href="{{ $item->getUrlPricing() }}" class="list-group-item">&nbsp;&nbsp;&nbsp;- {{ $item->title }}</a>
        <?php endforeach;?>
    </div>
</div>