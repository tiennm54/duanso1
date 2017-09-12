<div class="container">
    <nav id="menu" class="navbar">
        <div class="navbar-header">
            <span id="category" class="visible-xs">Categories</span>
            <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ URL::route('frontend.articles.index') }}">Home</a>
                </li>
                <li>
                    <a href="{{ URL::route('users.contact.getContact') }}">Contact</a>
                </li>

            </ul>
        </div>
    </nav>
</div>