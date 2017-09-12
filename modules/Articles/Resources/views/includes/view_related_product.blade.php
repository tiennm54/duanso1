<?php if ($model_related):?>
<h3>Related Products</h3>
<div class="row">
    <?php foreach ($model_related as $item):?>
    <div class="col-xs-6 col-sm-3">
        <div class="product-thumb transition" style="border: 1px solid #ddd;">
            <div class="image" style="margin: 10;">
                <a href="{{ URL::route('frontend.articles.view', [ 'id'=>$item->id, 'url'=>$item->url_title.".html" ]) }}">
                    <img src="{{url('images/'.$item->getArticles->image)}}" alt="{{ $item->title }}"
                         title="{{ $item->title }}" class="img-responsive">
                </a>
            </div>
            <div class="caption">
                <h4>
                    <a href="{{ URL::route('frontend.articles.view', [ 'id'=>$item->id, 'url'=>$item->url_title.".html" ]) }}">{{ $item->title }}</a>
                </h4>
                <p class="">
                        <span style="font-size: 30px">${{ $item->price_order }}</span>
                        <?php if ($item->status_stock == 1){?>
                        <div class="label label-primary badge">
                            <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> In Stock</span>
                        </div>
                        <?php }else{?>
                        <div class="label label-primary badge">
                            <span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Not In Stock</span>
                        </div>
                        <?php }?>
                </p>
            </div>
            <div class="button-group">

                <button type="button" onclick="addToCart({{ $item->id }})" data-toggle="modal" data-target="#myModal"
                        style="height: 40px">
                    <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span>
                    <i class="fa fa-shopping-cart"></i>
                </button>

                <button type="button" data-toggle="tooltip" title="" onclick="addWishlist({{ $item->id }});"
                        data-original-title="Add to Wish List" style="height: 40px">
                    <i class="fa fa-heart"></i>
                </button>

            </div>
        </div>
    </div>
    <?php endforeach;?>

</div>
<?php endif; ?>