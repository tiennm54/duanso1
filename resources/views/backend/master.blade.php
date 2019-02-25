<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Website</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <script type="text/javascript" src="{{url('theme_backend/js/jquery-2.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{url('theme_backend/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{url('theme_backend/js/bootstrap3-typeahead.min.js')}}"></script>
    <script type="text/javascript" src="{{url('theme_backend/js/bootstrap-confirmation.min.js')}}"></script>

    <link href="{{url('theme_backend/css/bootstrap.css')}}" type="text/css" rel="stylesheet">
    <link href="{{url('theme_backend/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet">
    <script src="{{url('theme_backend/js/moment.js')}}" type="text/javascript"></script>
    <script src="{{url('theme_backend/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
    <link href="{{url('theme_backend/css/bootstrap-datetimepicker.min.css')}}" type="text/css" rel="stylesheet" media="screen">
    <link type="text/css" href="{{url('theme_backend/css/stylesheet.css')}}" rel="stylesheet" media="screen">
    <script src="{{url('theme_backend/js/common.js')}}" type="text/javascript"></script>
    <link href="{{url('theme_frontend/image/cart.png')}}" rel="icon">

    <script type="text/javascript">

        function goBack() {
            window.history.back();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('.datetimepicker').datetimepicker({
                locale: 'en',
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });
    </script>

</head>
    <body>
        <div id="container">
            @include('backend.header')
            @include('backend.navbar')

            <div id="content">
                @yield('content')
            </div>

            @include('backend.footer')
        </div>
    </body>

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script>
        $('.textarea').ckeditor();
        // $('.textarea').ckeditor(); // if class is prefered.
    </script>

</html>