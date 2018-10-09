<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pandu">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ URL::asset('guest/img/lib/unhi.png') }}" />

    <link href="{{asset('/guest/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/stack-interface.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/socicon.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/lightbox.min.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/flickity.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/iconsmind.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/jquery.steps.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/theme.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/guest/css/custom-responsive.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/guest/css/font-rubiklato.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700%7CMerriweather:300,300i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700%7CRubik:300,400,500" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    @yield('content')
    
    <a class="back-to-top inner-link" href="#start" data-scroll-class="100vh:active">
        <i class="stack-interface stack-up-open-big"></i>
    </a>
    <script src="{{asset('/guest/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('/guest/js/flickity.min.js')}}"></script>
    <script src="{{asset('/guest/js/easypiechart.min.js')}}"></script>
    <script src="{{asset('/guest/js/parallax.js')}}"></script>
    <script src="{{asset('/guest/js/typed.min.js')}}"></script>
    <script src="{{asset('/guest/js/datepicker.js')}}"></script>
    <script src="{{asset('/guest/js/isotope.min.js')}}"></script>
    <script src="{{asset('/guest/js/ytplayer.min.js')}}"></script>
    <script src="{{asset('/guest/js/lightbox.min.js')}}"></script>
    <script src="{{asset('/guest/js/granim.min.js')}}"></script>
    <script src="{{asset('/guest/js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('/guest/js/countdown.min.js')}}"></script>
    <script src="{{asset('/guest/js/smooth-scroll.min.js')}}"></script>
    <script src="{{asset('/guest/js/scripts.js')}}"></script>
    @yield('js')
</body>
</html>