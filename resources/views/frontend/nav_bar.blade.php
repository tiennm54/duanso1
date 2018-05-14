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
                    <a href="{{ URL::route('frontend.articles.index') }}">Home</a>
                </li>

                <li class="dropdown"><a href="<?php echo URL::route('frontend.news.index');?>" class="dropdown-toggle" data-toggle="dropdown">News &amp; Bonus</a>
                    <div class="dropdown-menu" style="">
                        <div class="dropdown-inner">
                            <ul class="list-unstyled">
                                <?php foreach ($model_cate_menu as $menu):?>
                                    <li><a href="<?php echo $menu->getUrl(); ?>"><?php echo $menu->name; ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <a href="<?php echo URL::route('frontend.news.index');?>" class="see-all">Show All</a> 
                    </div>
                </li>

                <li>
                    <a href="{{ URL::route('users.contact.getContact') }}">Contact</a>
                </li>

                <li>
                    <a href="{{ URL::route('users.feedback.getFeedBack') }}">Feedback</a>
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
            </ul>
        </div>
    </nav>
</div>