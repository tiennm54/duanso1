<aside id="column-right" class="col-sm-3 hidden-xs">
    <div class="list-group">
        <a href="{{ URL::route('users.getLogin') }}" class="list-group-item">Login</a>
        <a href="{{ URL::route('users.getRegister') }}" class="list-group-item">Register</a>
        <a href="{{ URL::route('users.getForgotten') }}" class="list-group-item">Forgotten Password</a>

        <a href="{{ URL::route('users.getMyAccount') }}" class="list-group-item">My Account</a>
        <a href="{{ URL::route('users.shippingAddress.getShippingAddress') }}" class="list-group-item">Address Book</a>
        <a href="{{ URL::route('users.getWishList') }}" class="list-group-item">Wish List</a>
        <a href="{{ URL::route('users.orderHistory') }}" class="list-group-item">Order History</a>
        <a href="{{URL::route('users.feedback.getFeedBack')}}" class="list-group-item">Feedback</a>
        
    {{-- <a href="" class="list-group-item">Recurring payments</a>
        <a href="" class="list-group-item">Reward Points</a>
        <a href="" class="list-group-item">Returns</a>
        <a href="" class="list-group-item">Transactions</a>
        <a href="" class="list-group-item">Newsletter</a>--}}
    </div>
    <div class="fb-page" data-href="https://www.facebook.com/buypremiumkey/" data-tabs="timeline" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/buypremiumkey/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/buypremiumkey/">Buy Premium Key</a></blockquote></div>
</aside>