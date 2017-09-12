<header id="header" class="navbar navbar-static-top">
    <div class="navbar-header">
        <a type="button" id="button-menu" class="pull-left"><i class="fa fa-dedent fa-lg"></i></a>
        <a href="{{ URL::route('articles.index') }}" class="navbar-brand">
            <img src="{{url('theme_backend/image/logo.png')}}" alt="Buy Premium Key" title="Buy Premium Key" width="150px">
        </a>
    </div>
    <ul class="nav pull-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">
                <span class="label label-danger pull-left">5</span>
                <i class="fa fa-bell fa-lg"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
                <li class="dropdown-header">Orders</li>
                <li>
                    <a href="" style="display: block; overflow: auto;">
                        <span class="label label-warning pull-right">5</span>Processing
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="label label-success pull-right">5</span>Completed
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="label label-danger pull-right">1</span>Returns
                    </a>
                </li>
                <li class="divider"></li>
                <li class="dropdown-header">Customers</li>
                <li>
                    <a href="">
                        <span class="label label-success pull-right">0</span>Customers Online
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="label label-danger pull-right">0</span>Pending approval
                    </a>
                </li>
                <li class="divider"></li>
                <li class="dropdown-header">Products</li>
                <li>
                    <a href="">
                        <span class="label label-danger pull-right">1</span>Out of stock</a>
                </li>
                <li>
                    <a href="">
                        <span class="label label-danger pull-right">3</span>Reviews
                    </a>
                </li>
                <li class="divider"></li>
                <li class="dropdown-header">Affiliates</li>
                <li>
                    <a href="">
                        <span class="label label-danger pull-right">0</span>Pending approval
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home fa-lg"></i></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">Stores</li>
                <li><a href="{{ URL::route('frontend.articles.index') }}" target="_blank">Your Store</a></li>
            </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-life-ring fa-lg"></i></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">Help</li>
                <li><a href="" target="_blank">OpenCart Homepage</a></li>
                <li><a href="" target="_blank">Documentation</a></li>
                <li><a href="" target="_blank">Support Forum</a></li>
            </ul>
        </li>
        <li>
            <a href="">
                <span class="hidden-xs hidden-sm hidden-md">Logout</span> <i class="fa fa-sign-out fa-lg"></i>
            </a>
        </li>
    </ul>
</header>