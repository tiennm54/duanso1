<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div id="logo">
                    <a href="{{ URL::route('frontend.articles.index') }}">
                        <img src="{{url('theme_frontend/image/logo.png')}}" title="Buy Premium Key" alt="Buy Premium Key" class="img-responsive">
                    </a>

                </div>
            </div>
            <div class="col-sm-5">
                <?php
                $type = Route::getCurrentRoute()->getName();
                if (app('request')->input('type') != "") {
                    $type = app('request')->input('type');
                } else {
                    if ($type == "frontend.news.index" || $type == "frontend.news.cate") {
                        $type = "news";
                    } else if ($type == "frontend.faq.index" || $type == "frontend.faq.cate") {
                        $type = "faq";
                    } else {
                        $type = "product";
                    }
                }
                ?>
                <form action="{{ URL::route('frontend.articles.getSearch') }}" method="get">
                    <div id="search" class="input-group">
                        <input class="form-control" type="hidden" name="type" value="<?php echo $type ?>">
                        <input type="text" name="keyword" value="{{ app('request')->input('keyword') }}" placeholder="Search Product or News or FAQ's" class="form-control input-lg">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="col-sm-3">
                <div id="cart" class="btn-group btn-block">
                    <button type="button" data-toggle="modal" data-target="#myModal" onclick="viewCartModal()"
                            class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-cart"></i>
                        <span id="cart-total"><span id="quantity_item">0</span> item(s) - <span id="sub-total-order"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('articles::modal.shoppingCart')--}}
</header>

<script>
    function viewCartModal() {
        var token = $("#_token").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.shoppingCart.viewCartModal') ?>",
            data: {"_token": token},
            success: function (data) {
                $("#list_order").html(data);
            },
            error: function (ex) {

            }
        });
    }

    function emptyCart() {
        if (confirm("Are you sure you want to empty your shopping cart?")) {
            var token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.shoppingCart.emptyCart') ?>",
                data: {"_token": token},
                success: function (data) {
                    $("#sub-total-order").text("$0.00")
                    window.location.replace('<?php echo URL::route('frontend.articles.index') ?>');
                },
                error: function (ex) {

                }
            });
        }
    }


</script>