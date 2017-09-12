<!DOCTYPE html>
<html>
    <head>
        <title>Error 404 | Buy Premium Key</title>
        <link href="{{url('theme_frontend/css/bootstrap.css')}}" rel="stylesheet" media="screen">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            body { background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);}
            .error-template {padding: 40px 15px;text-align: center;}
            .error-actions {margin-top:15px;margin-bottom:15px;}
            .error-actions .btn { margin-right:10px; }
            .image-center {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-template">
                        <div class="error-details">
                            <a href="{{ URL::route('frontend.articles.index') }}">
                                <img src="{{url('theme_frontend/image/logo.png')}}" title="Buy Premium Key" alt="Buy Premium Key" class="img-responsive image-center" >
                            </a>
                        </div>
                        <h1>Buy Premium Key | Premium Account Reseller</h1>
                        <h2>404 Not Found</h2>
                        <div class="error-details">
                            Sorry, an error has occured, Requested page not found!
                        </div>
                        <div class="error-actions">
                            <a href="{{ URL::route('frontend.articles.index') }}" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                                Take Me Home
                            </a>
                            <a href="{{ URL::route('users.contact.getContact') }}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-5">
                    <form action="{{ URL::route('frontend.articles.getSearch') }}" method="get">
                        <div id="search" class="input-group">
                            <input type="text" name="keyword" value="{{ app('request')->input('keyword') }}" placeholder="Search product at BuyPremiumKey.Com" class="form-control input-lg">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-lg">Search</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <h2 style="color: #1f90bb">Please re-select our product list</h2>
                </div>
                <?php $model_all_product = \App\Models\Articles::get(); ?>
                <?php if (count($model_all_product)) { ?>
                    <?php foreach ($model_all_product as $item_product): ?>
                        <div class="col-md-3">
                            <a href="{{ URL::route('frontend.articles.pricing', ['id' => $item_product->id, 'url' => $item_product->url_title.".html" ]) }}">{{ $item_product->title }}</a>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>

            </div>
        </div>
    </body>
</html>
