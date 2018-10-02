<nav id="top">
    <script>

        function startTime() {
            var d = new Date();
            var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
            var today = new Date(utc + (3600000 * 7));
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('working_hour_id').innerHTML = h + ":" + m + ":" + s;
            setTimeout(startTime, 500);
            var checkWorking = $(".working_class").is(":hidden");
            var checkOutWorking = $(".out_business_class").is(":hidden");

            if (h >= 7 && h <= 22) {
                if (checkWorking == true) { // dang an
                    $(".working_class").show();
                }
                if (checkOutWorking != true) { // dang hien
                    $(".out_business_class").hide();
                }
            } else {
                if (checkWorking != true) { // dang hien
                    $(".working_class").hide();
                }
                if (checkOutWorking == true) { // dang an
                    $(".out_business_class").show();
                }
            }
        }
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }
            return i;
        }
        $(document).ready(function () {
            startTime();
        });
    </script>

    <div class="container">
        <div id="top-links" class="nav pull-left">
            <span style="font-weight: bold;"><i class="fa fa-clock-o"></i></span> <b id="working_hour_id"></b> <b>GTM +7</b>
            <span class="badge badge-pill badge-info working_class" style="background-color: #8cc152;display: none;" 
                  data-toggle="tooltip" data-placement="bottom" 
                  data-original-title="<?php echo NOTI_WORKING; ?>">
                <i class="fa fa-check-circle"></i> Working
            </span>
            <span class="badge badge-pill badge-info out_business_class" style="background-color: #8cc152;display: none;"
                  data-toggle="tooltip" data-placement="bottom" 
                  data-original-title="<?php echo NOTI_OUT_WORKING; ?>">
                <i class="fa fa-check-circle"></i> Delivery within 1-8 hours
            </span>
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