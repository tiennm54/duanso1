<aside id="column-right" class="col-sm-3 hidden-xs">
    <div class="list-group">
        <a href="{{ URL::route('users.getMyAccount') }}" class="list-group-item">My Account</a>
        <a href="{{ URL::route('users.getEditProfile') }}" class="list-group-item">Edit Account</a>
        <a href="{{ URL::route('users.getChangePassword') }}" class="list-group-item">Password</a>
        <a href="{{ URL::route('users.shippingAddress.getShippingAddress') }}" class="list-group-item">Shipping Address</a>

        <a href="{{ URL::route('users.getWishList') }}" class="list-group-item">Wish List</a>
        <a href="{{ URL::route('users.orderHistory') }}" class="list-group-item">Order History</a>
        {{--<a href="#" class="list-group-item">Downloads</a>
        <a href="#" class="list-group-item">Recurring payments</a>
        <a href="#" class="list-group-item">Reward Points</a>
        <a href="#" class="list-group-item">Returns</a>
        <a href="#" class="list-group-item">Transactions</a>--}}
        <a href="#" class="list-group-item">Newsletter</a>
        <a href="{{ URL::route('users.getLogout') }}" class="list-group-item">Logout</a>
    </div>
</aside>