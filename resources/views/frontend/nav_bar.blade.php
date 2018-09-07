<div class="container">
    <nav id="menu" class="navbar">
        <div class="navbar-header">
            <span id="category" class="visible-xs">Categories</span>
            <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ URL::route('frontend.articles.index') }}"><i class="glyphicon glyphicon-home"></i> Home</a>
                </li>

                <li class="dropdown"><a href="<?php echo URL::route('frontend.news.index'); ?>" class="dropdown-toggle" data-toggle="dropdown">News &amp; Bonus</a>
                    <div class="dropdown-menu" style="">
                        <div class="dropdown-inner">
                            <ul class="list-unstyled">
                                <?php foreach ($model_cate_menu as $menu): ?>
                                    <li><a href="<?php echo $menu->getUrl(); ?>"><?php echo $menu->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <a href="<?php echo URL::route('frontend.news.index'); ?>" class="see-all">Show All</a> 
                    </div>
                </li>

                <li class="dropdown"><a href="<?php echo URL::route('frontend.faq.index'); ?>" class="dropdown-toggle" data-toggle="dropdown">FAQ's</a>
                    <div class="dropdown-menu" style="">
                        <div class="dropdown-inner">
                            <ul class="list-unstyled">
                                <?php foreach ($model_cate_faq as $menu_faq): ?>
                                    <li><a href="<?php echo $menu_faq->getUrl(); ?>"><?php echo $menu_faq->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <a href="<?php echo URL::route('frontend.faq.index'); ?>" class="see-all">Show All</a> 
                    </div>
                </li>

                <?php if (!Auth::check()): ?>

                    <li>
                        <a href="{{ URL::route('users.guestOrder.guestGetKey') }}">Get Key</a>
                    </li>

                    <li>
                        <a href="{{ URL::route('users.getLogin') }}">Login</a>
                    </li>

                    <li>
                        <a href="{{ URL::route('users.getRegister') }}">Register</a>
                    </li>

                <?php endif; ?>

                <li>
                    <a href="{{ URL::route('users.contact.getContact') }}">Contact</a>
                </li>

                <li class="dropdown">
                    <a href="{{ URL::route('users.review.index') }}" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-star-empty"></i> Reviews
                    </a>
                    <div class="dropdown-menu" style="">
                        <div class="dropdown-inner">
                            <ul class="list-unstyled">
                                <li><a href="<?php echo URL::route('users.review.index') ?>">Reviews Website</a></li>
                                <li><a href="<?php echo URL::route('product.reviews.index') ?>">Reviews Product</a></li>
                            </ul>
                        </div>
                        <a href="<?php echo URL::route('product.reviews.index'); ?>" class="see-all">Show All</a> 
                    </div>
                </li>
                
                <?php if(count($model_product_top) > 0){?>
                <li class="dropdown">
                    <a href="#"><i class="glyphicon glyphicon-queen"></i> Top Filehosts</a>
                    <div class="dropdown-menu" style="margin-left: -250px">
                        <div class="dropdown-inner">
                            <?php for ($i = 0; $i < 20; $i = $i + 5) { ?>
                                <ul class="list-unstyled">
                                    <li>
                                        <?php foreach ($model_product_top as $key => $item) { ?>
                                            <?php if ($key >= $i && $key < $i + 5) { ?>
                                                <a href="<?php echo $item->getUrlPricing(); ?>"><?php echo $item->title ?></a>
                                            <?php } ?>
                                        <?php } ?>
                                    </li>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </li>
                <?php }?>

            </ul>
        </div>
    </nav>
</div>