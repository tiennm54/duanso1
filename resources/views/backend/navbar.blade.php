<nav id="column-left" class="active">
    <div id="profile">
        <div>
            <i class="fa fa-opencart"></i>
        </div>
        <div>
            <h4>Buy Premium Key</h4>
            <small>Administrator</small>
        </div>
    </div>
    <ul id="menu">
        <?php if (!Auth::guest() && Auth::user()->role->alias == "admin") { ?>

            <li id="menu-dashboard">

                <a href="{{ URL::route('admin.index') }}">
                    <i class="fa fa-dashboard fw"></i><span>Dashboard</span>
                </a>
            </li>

            <li id="menu-sale">
                <a class="parent"><i class="fa fa-shopping-cart fw"></i> <span>Sales</span></a>
                <ul class="collapse">
                    <li><a href="{{ URL::route('adminUserOrders.listOrders') }}">Orders</a></li>
                </ul>
            </li>

            <li id="menu-catalog">
                <a class="parent"><i class="fa fa-tags fw"></i> <span>Product manager</span></a>
                <ul class="collapse">
                    <li>
                        <a href="{{ URL::route('articles.index') }}">Products</a>
                    </li>

                    <li>
                        <a href="{{ URL::route('admin.feedback.index') }}">Feedback</a>
                    </li>

                </ul>
            </li>

            <li id="menu-catalog">
                <a class="parent"><i class="fa fa-tags fw"></i> <span>Config</span></a>
                <ul class="collapse">
                    <li>
                        <a href="{{ URL::route('paymentType.index') }}">Payment Type</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('config.bonusConfig.getCreate') }}">Bonus Config</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('admin.information.index') }}">Information</a>
                    </li>
                </ul>
            </li>

            <li id="menu-catalog">
                <a class="parent"><i class="fa fa-tags fw"></i> <span>SEO Manager</span></a>
                <ul class="collapse">
                    <li>
                        <a href="{{ URL::route('config.seo.index') }}">SEO</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('config.seopage.getCreate') }}">Create Page</a>
                    </li>
                </ul>
            </li>

            <li id="menu-customer">
                <a class="parent"><i class="fa fa-user fw"></i> <span>Customers</span></a>
                <ul class="collapse">
                    <li><a href="{{ URL::route('admin.userManagement.index') }}">List User</a></li>
                </ul>
            </li>
        <?php } ?>

        <li id="menu-catalog">
            <a class="parent"><i class="fa fa-tags fw"></i> <span>News Manager</span></a>
            <ul class="collapse">
                <li>
                    <a href="{{ URL::route('admin.news.index') }}">News</a>
                </li>
                
                <li>
                    <a href="{{ URL::route('admin.faq.index') }}">FAQs</a>
                </li>
                
                <li>
                    <a href="{{ URL::route('admin.comment.index') }}">Comment</a>
                </li>

                <li>
                    <a href="{{ URL::route('config.image.getCreate') }}">Image</a>
                </li>

            </ul>
        </li>

        <li id="menu-category">
            <a class="parent"><i class="fa fa-tags fw"></i> <span>Category</span></a>
            <ul class="collapse">
                <li>
                    <a href="{{ URL::route('category.index') }}">Category News</a>
                </li>
                <li>
                    <a href="{{ URL::route('admin.categoryFaq.index') }}">Category FAQ</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>