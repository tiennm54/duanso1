<aside id="column-right" class="col-sm-3 hidden-xs">
    <div class="list-group">
        <a href="{{ URL::route('users.getMyAccount') }}" class="list-group-item">My Account</a>
        <a href="{{ URL::route('users.getEditProfile') }}" class="list-group-item">Edit Account</a>
        <a href="{{ URL::route('users.getChangePassword') }}" class="list-group-item">Password</a>
        <a href="{{ URL::route('users.getWishList') }}" class="list-group-item">Wish List</a>
        <a href="{{ URL::route('users.orderHistory') }}" class="list-group-item">Order History</a>
        <a href="{{URL::route('users.feedback.getFeedBack')}}" class="list-group-item">Comments about this website</a>
        <a href="{{ URL::route('users.getLogout') }}" class="list-group-item">Logout</a>
    </div>

</aside>