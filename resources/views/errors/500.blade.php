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
    <link href="{{asset('/guest/css/theme.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{asset('/guest/css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/guest/css/custom-responsive.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('/guest/css/font-rubiklato.css')}}" rel="stylesheet" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,400i,500,600,700%7CMerriweather:300,300i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700%7CRubik:300,400,500" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="main-container">
        <section class="height-90 text-center" aria-labelledby="steps-uid-0-h-0" aria-hidden="false">
            <div class="pos-vertical-center">
                <img alt="pic" class="img-error" src="{{ URL::asset('guest/img/lib/500.png') }}">
                <h4>An unexpected error has occured preventing the page from loading.</h4>
                <a href="{{route('id.home')}}">Go back to home page</a>
            </div>
        </section>
    </div>

    <script src="{{asset('/guest/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('/guest/js/flickity.min.js')}}"></script>
    <script src="{{asset('/guest/js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('/guest/js/countdown.min.js')}}"></script>
    <script src="{{asset('/guest/js/smooth-scroll.min.js')}}"></script>
    <script src="{{asset('/guest/js/scripts.js')}}"></script>
    @yield('js')
</body>
</html>