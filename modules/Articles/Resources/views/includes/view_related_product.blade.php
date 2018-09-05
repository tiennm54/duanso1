<?php if ($model_related): ?>
    <hr/>
    <h2>Related Products</h2>
    <div class="row">
        <?php foreach ($model_related as $item): ?>
            <div class="col-xs-6 col-sm-3">
                <div class="product-thumb transition" style="border: 1px solid #ddd;">
                    <div class="image" style="margin: 10;">
                        <a href="{{ $item->getUrl() }}">
                            <img src="{{url('images/'.$item->getArticles->image)}}" alt="{{ $item->title }}"
                                 title="{{ $item->title }}" class="img-responsive">
                        </a>
                    </div>
                    <div class="caption" style="text-align: center">
                        <h4 style="min-height: 30px">
                            <a href="{{ $item->getUrl() }}">{{ $item->title }}</a>
                        </h4>
                        <p class="">
                            <span style="font-size: 30px">${{ $item->price_order }}</span>
                            <?php if ($item->status_stock == 1) { ?>
                            <div class="label label-primary badge">
                                <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> In Stock</span>
                            </div>
                        <?php } else { ?>
                            <div class="label label-primary badge">
                                <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Not In Stock</span>
                            </div>
                        <?php } ?>
                        </p>
                    </div>
                    <div class="button-group">

                        <button type="button" onclick="location.href = '<?php echo $item->getUrlBuyNow(); ?>';" <?php echo ($item->status_stock == 0) ? "disabled" : "" ?>>
                            <span class="hidden-xs hidden-sm hidden-md">Buy Now</span>
                        </button>

                        <button type="button" onclick="addToCart({{ $item->id }})" data-toggle="modal" data-target="#myModal"
                            <?php echo ($item->status_stock == 0) ? "disabled" : "" ?>>
                            <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span>
                        </button>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>