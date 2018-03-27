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
        <li id="menu-dashboard">
            <a href="#">
                <i class="fa fa-dashboard fw"></i> <span>Dashboard</span></a>
        </li>

        <li id="menu-sale">
            <a class="parent"><i class="fa fa-shopping-cart fw"></i> <span>Sales</span></a>
            <ul class="collapse">
                <li><a href="{{ URL::route('adminUserOrders.listOrders') }}">Orders</a></li>
                <li><a href="#">RecurringProfiles</a></li>
                <li><a href="#">Returns</a></li>
                <li>
                    <a class="parent">Gift Vouchers</a>
                    <ul class="collapse">
                        <li><a href="#">Gift Vouchers</a></li>
                        <li><a href="#">Voucher Themes</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li id="menu-catalog">
            <a class="parent"><i class="fa fa-tags fw"></i> <span>Catalog</span></a>
            <ul class="collapse">
                <li>
                    <a href="{{ URL::route('articles.index') }}">Products</a>
                </li>
                <li>
                    <a href="{{ URL::route('paymentType.index') }}">Payment Type</a>
                </li>
                <li>
                    <a href="{{ URL::route('admin.information.index') }}">Information</a>
                </li>
                <li>
                    <!--Review comment hoặc review đánh giá sản phẩm của khách hàng-->
                    <a href="#">Reviews</a>
                </li>

                <li>
                    <!--Review comment hoặc review đánh giá sản phẩm của khách hàng-->
                    <a href="{{ URL::route('config.seo.index') }}">SEO</a>
                </li>
            </ul>
        </li>
        
         <li id="menu-customer">
            <a class="parent"><i class="fa fa-user fw"></i> <span>Customers</span></a>
            <ul class="collapse">
                <li><a href="{{ URL::route('admin.userManagement.index') }}">List User</a></li>
            </ul>
        </li>


        <li id="menu-category">
            <a class="parent"><i class="fa fa-tags fw"></i> <span>Category</span></a>
            <ul class="collapse">
                <li>
                    <a href="{{ URL::route('admin.categoryFaq.index') }}">Category FAQ</a>
                </li>

            </ul>
        </li>

        <li id="menu-articles">
            <a class="parent"><i class="fa fa-tags fw"></i> <span>Articles</span></a>
            <ul class="collapse">
                <li>
                    <a href="{{ URL::route('admin.faq.index') }}">FAQs</a>
                </li>
                <li>
                    <a href="{{ URL::route('admin.news.index') }}">News</a>
                </li>
            </ul>
        </li>

        <li id="menu-marketing">
            <a class="parent"><i class="fa fa-share-alt fw"></i> <span>Marketing</span></a>
            <ul class="collapse">
                <li><a href="#">Marketing</a></li>
                <li><a href="#">Affiliates</a></li>
                <li><a href="#">Coupons</a></li>
                <li><a href="#">Mail</a></li>
            </ul>
        </li>

        <li id="menu-report">
            <a class="parent"><i class="fa fa-bar-chart-o fw"></i> <span>Reports</span></a>
            <ul class="collapse">
                <li>
                    <a class="parent">Sales</a>
                    <ul class="collapse">
                        <li><a href="">Orders</a></li>
                        <li><a href="">Tax</a></li>
                        <li><a href="">Shipping</a></li>
                        <li><a href="">Returns</a></li>
                        <li><a href="">Coupons</a></li>
                    </ul>
                </li>
                <li>
                    <a class="parent">Products</a>
                    <ul class="collapse">
                        <li><a href="">Viewed</a></li>
                        <li><a href="">Purchased</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    <div id="stats">
        <ul>
            <li>
                <div>Orders Completed <span class="pull-right">100%</span></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100"
                         aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100%</span>
                    </div>
                </div>
            </li>
            <li>
                <div>Orders Processing <span class="pull-right">100%</span></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="100"
                         aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100%</span>
                    </div>
                </div>
            </li>
            <li>
                <div>Other Statuses <span class="pull-right">0%</span></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0"
                         aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">0%</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>