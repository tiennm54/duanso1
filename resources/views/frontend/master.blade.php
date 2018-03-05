<html dir="ltr" lang="en"><!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google-site-verification" content="-U8WB9cqAFZnl0N7bWVPff2hfjW_RvYUrbfPgHpirJA" />
	<meta name = "msvalidate.01" content = "F824635A4D2F592644FCC928B8FAAE1C" />

    {!! SEO::generate() !!}
    <base href="{{ URL::route('frontend.articles.index') }}">
    <meta name="robots" content="INDEX,FOLLOW">
    <script src="{{url('theme_frontend/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
    <link href="{{url('theme_frontend/css/bootstrap.css')}}" rel="stylesheet" media="screen">
    <link href="{{url('theme_frontend/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('theme_frontend/css/stylesheet.css')}}" rel="stylesheet">
    <link href="{{url('theme_frontend/css/style_pricing.css')}}" rel="stylesheet">
    <link href="{{url('theme_frontend/css/my-account.css')}}" rel="stylesheet">
    <link href="{{url('theme_frontend/image/favicon.png')}}" rel="icon">
    <link rel="alternate" hreflang="en" href="{{ URL::route('frontend.articles.index') }}" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css">

    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106635648-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments)};
        gtag('js', new Date());

        gtag('config', 'UA-106635648-1');
    </script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '360509441070327'); // Insert your pixel ID here.
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=360509441070327&ev=PageView&noscript=1"/>
    </noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->


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