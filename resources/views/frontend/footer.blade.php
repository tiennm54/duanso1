<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h5>Information</h5>
                <ul class="list-unstyled">
                    <?php foreach ($model_inform as $inform): ?>
                        <li><a href="{{ $inform->getUrl() }}"><?php echo $inform->title; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="https://buypremiumkey.com/faq/category-2/how-to-activate-premium-key.html">How to
                            activate premium key</a></li>
                    <li><a href="{{ URL::route('users.contact.getContact') }}">Contact Us</a></li>
                    <li><a href="{{ URL::route('users.guestOrder.guestGetKey') }}">Order Lookup</a></li>
                    <li><a href="{{ URL::route('users.review.index') }}">Reviews</a></li>
                    <li><a href="{{ URL::route('frontend.sitemap.index') }}">Site Map</a></li>
                </ul>
            </div>

            <div class="col-sm-3">
                <h5>My Account</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ URL::route('users.getMyAccount') }}">My Account</a></li>
                    <li><a href="{{ URL::route('users.orderHistory') }}">Order History</a></li>
                    <li><a href="{{ URL::route('users.getWishList') }}">Wish List</a></li>
                </ul>
            </div>

            <div class="col-sm-3">
                <h5>Contact Information</h5>
                <ul class="list-unstyled">
                    <li><span style="color: #ccc">Address: 169874 Chinatown, Singapore</span></li>
                    <li><span style="color: #ccc">Email: <a
                                href="mailto:<?php echo EMAIL_BUYPREMIUMKEY; ?>"><?php echo EMAIL_BUYPREMIUMKEY; ?></a></span>
                    </li>
                    <li><span style="color: #ccc">Working Days/Hours: Mon - Sun / 8:00AM - 11:00PM GTM +8</span></li>
                </ul>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <p>Copyright © 2016 - <?php echo date("Y"); ?>, BuyPremiumKey.com, All Rights Reserved</p>
            </div>
            <div class="col-sm-6">
                <img class="pull-right" src="{{url('images/icon/payment.png')}}" alt="buy premium key via paypal"
                     width="50%">
            </div>

            <div id="fb-root"></div>
            <!-- Your customer chat code -->
            <div class="fb-customerchat"
                 greeting_dialog_display="hide"
                 attribution=setup_tool
                 page_id="212425975964390"
                 theme_color="#0084ff">
            </div>
        </div>
        <script src="{{url('theme_frontend/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{url('theme_frontend/js/bootstrap-confirmation.min.js')}}" type="text/javascript"></script>
        <script src="{{url('theme_frontend/js/star-rating.js')}}" type="text/javascript"></script>
        <script src="{{url('theme_frontend/js/loadingOverlay.js')}}" type="text/javascript"></script>
        <script src="{{url('theme_frontend/js/select2.min.js')}}" type="text/javascript"></script>
        
        <!--JS CODE-->
        <script type="text/javascript">

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            getSubTotal();
            getMoneyBonus();
            $('.js-example-basic-single').select2();
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
            var spinHandle = loadingOverlay().activate();
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.shoppingCart.addToCart') ?>",
                data: {"product_id": id, "_token": token},
                success: function (data) {
                    $("#list_order").html(data);
                    loadingOverlay().cancel(spinHandle);
                },
                error: function (ex) {
                    loadingOverlay().cancel(spinHandle);
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
        
        function quickFindFilehost(){
            var url = $("#quickFindFilehostId").val();
            if(url != "-1" && url != -1){
                window.location.href = url;
            }
        }
        
        </script>

        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    xfbml: true,
                    version: 'v3.2'
                });
            };
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
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