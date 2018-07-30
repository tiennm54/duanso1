<nav id="top">
    <div class="container">
        <div id="top-links" class="nav pull-left">
            <ul class="list-inline">
                <li>
                    <a style="color: red; font-weight: bold">Bonus 2% for sponsor and 2% for buyers per order is successfully transacted.</a>
                </li>
            </ul>
        </div>

        <div id="top-links" class="nav pull-right">
            <ul class="list-inline">
                <li>
                    <?php if (Auth::check()) { ?>
                        <a href="{{ URL::route('users.getMyAccount') }}">
                            <i class="fa fa-money"></i>
                            <span class="hidden-xs hidden-sm hidden-md">
                                <b>
                                    <span class="my_money_bonus"><?php echo (Session::get('user_money')) ? Session::get('user_money') : "0"; ?></span>$
                                </b>
                            </span>
                        </a>
                    <?php } ?>
                </li>

                <li class="dropdown">
                    <a href="#" title="My Account" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs hidden-sm hidden-md">
                            <?php
                            if (!Auth::check()) {
                                echo "My Account";
                            } else {
                                echo Session::get('user_email_login');
                            }
                            ?>
                        </span> <span class="caret"></span>
                    </a>
                    <?php if (!Auth::check()) { ?>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="{{ URL::route('users.getRegister') }}">Register</a>
                            </li>
                            <li>
                                <a href="{{ URL::route('users.getLogin') }}">Login</a>
                            </li>
                        </ul>
                    <?php } ?>
                    <?php if (Auth::check()) { ?>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="{{ URL::route('users.getMyAccount') }}">
                                    My account (<span class="my_money_bonus"><?php echo (Session::get('user_money')) ? Session::get('user_money') : "0"; ?></span>$)
                                </a>
                            </li>

                            <li>
                                <a href="{{ URL::route('users.orderHistory') }}">Order History</a>
                            </li>

                            <li>
                                <a href="{{ URL::route('users.getLogout') }}">Logout</a>
                            </li>

                        </ul>
                    <?php } ?>


                </li>
                <li>
                    <a href="{{ URL::route('users.getWishList') }}" id="wishlist-total" title="Wish List (0)">
                        <i class="fa fa-heart"></i>
                        <span class="hidden-xs hidden-sm hidden-md">Wish List (0)</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Shopping Cart" data-toggle="modal" data-target="#myModal" onclick="viewCartModal()">
                        <i class="fa fa-shopping-cart"></i> <span
                            class="hidden-xs hidden-sm hidden-md">Shopping Cart</span>
                    </a>
                </li>
                <li>
                    <a href="{{ URL::route('frontend.checkout.index') }}" title="Checkout">
                        <i class="fa fa-share"></i>
                        <span class="hidden-xs hidden-sm hidden-md">Checkout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>