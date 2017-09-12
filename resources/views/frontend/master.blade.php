<html dir="ltr" lang="en"><!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google-site-verification" content="-U8WB9cqAFZnl0N7bWVPff2hfjW_RvYUrbfPgHpirJA" />
	<meta name = "msvalidate.01" content = "F824635A4D2F592644FCC928B8FAAE1C" />

    {!! SEO::generate() !!}
    <script src="{{url('theme_frontend/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
    <link href="{{url('theme_frontend/css/bootstrap.css')}}" rel="stylesheet" media="screen">
    <link href="{{url('theme_frontend/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('theme_frontend/css/stylesheet.css')}}" rel="stylesheet">
    <link href="{{url('theme_frontend/css/style_pricing.css')}}" rel="stylesheet">
    <link href="{{url('theme_frontend/image/cart.png')}}" rel="icon">
    <link rel="alternate" hreflang="us" href="{{ URL::route('frontend.articles.index') }}" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css">


</head>
<body class="common-home">
    <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('articles::modal.shoppingCart')
    @include('frontend.nav_top')
    @include('frontend.header')
    @include('frontend.nav_bar')
    @yield('content')
    @include('frontend.footer')

</body>
</html>