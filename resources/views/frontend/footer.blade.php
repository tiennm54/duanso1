<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h5>Information</h5>
                <ul class="list-unstyled">
                    <?php foreach ($model_inform as $inform):?>
                    <li><a href="{{ $inform->getUrl() }}"><?php echo $inform->title; ?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ URL::route('users.contact.getContact') }}">Contact Us</a></li>
                    <li><a href="{{ URL::route('users.guestOrder.guestGetKey') }}">Get Key</a></li>
                    <li><a href="{{ URL::route('frontend.faq.index') }}">FAQ's</a></li>
                    <li><a href="{{ URL::route('frontend.sitemap.index') }}">Site Map</a></li>
                </ul>
            </div>

            <div class="col-sm-3">
                <h5>My Account</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ URL::route('users.getMyAccount') }}">My Account</a></li>
                    <li><a href="{{ URL::route('users.orderHistory') }}">Order History</a></li>
                    <li><a href="{{ URL::route('users.getWishList') }}">Wish List</a></li>
                    <li><a href="{{ URL::route('users.shippingAddress.getShippingAddress') }}">Shipping Address</a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-3">
                <h5>Contact Information</h5>
                <ul class="list-unstyled">
                    <li><span style="color: #ccc">Address: Ha Noi - Viet Nam</span></li>
                    <li><span style="color: #ccc">Email: <a href="mailto:buypremiumkey.com@gmail.com">buypremiumkey.com@gmail.com</a></span></li>
                    <li><span style="color: #ccc">Working Days/Hours: Mon - Sun / 8:00AM - 10:00PM GTM + 7</span></li>
                    <li><span style="color: #ccc">Skype: <a href="skype:tiennm54?chat">
                                <i class="fa fa-skype"></i>
                                <span class="hidden-xs hidden-sm hidden-md">tiennm54</span>
                            </a></span></li>
                </ul>
            </div>

        </div>
        <hr>
        <p>Powered By <a href="{{ URL::route('frontend.articles.index') }}">BuyPremiumKey</a><br> buypremiumkey.com © 2017</p>

    </div>


    <script src="{{url('theme_frontend/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{url('theme_frontend/js/bootstrap-confirmation.min.js')}}" type="text/javascript" ></script>
    <script src="{{url('theme_frontend/js/star-rating.js')}}" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            getSubTotal();
            getMoneyBonus();
        });

        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            // other options
        });

        function goBack() {
            window.history.back();
        }

        function confirmDelete() {
            if (confirm("Are you sure you want to delete?")) {
                return true;
            }
            return false;
        }

        function getSubTotal() {
            var subTotal = "<?php echo Session::get('sub_total'); ?>";
            var quantity = "<?php echo Session::get('quantity_item'); ?>";
            if (subTotal) {
                $("#sub-total-order").html("$" + subTotal);
                $("#quantity_item").html(quantity);
            } else {
                $("#sub-total-order").html("$0.00");
            }
        }

        function getMoneyBonus() {
           
            var moneyBonus = "<?php echo Session::get('user_money'); ?>";
            var emailLogin = "<?php echo Session::get('user_email_login'); ?>";
            if (emailLogin) {
                console.log("GET MONEY BONUS");
                console.log(moneyBonus);
                $(".my_money_bonus").html(moneyBonus);
            }
        }


        function addToCart(id) {
            var token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.shoppingCart.addToCart') ?>",
                data: {"product_id": id, "_token": token},
                success: function (data) {
                    $("#list_order").html(data);
                },
                error: function (ex) {

                }
            });
        }

        function addWishlist(id) {
            var token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('users.addWishlist') ?>",
                data: {"product_id": id, "_token": token},
                success: function (data) {
                    location.href = location.href;
                },
                error: function (ex) {

                }
            });
        }

        function deleteWishList(id) {
            var token = $("#_token").val();

            console.log(token);

            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('users.deleteWishList') ?>",
                data: {"product_id": id, "_token": token},
                success: function (data) {
                    console.log(data);
                },
                error: function (ex) {

                }
            });
        }
    </script>

    <script>
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script src="https://apis.google.com/js/platform.js" async defer>
        {
            lang: 'en-GB'
        }
    </script>

    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5974dc1fb28b9513"></script>


</footer>