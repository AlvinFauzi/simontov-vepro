<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo_sedang.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ env('MIX_URL') }}">
    <title>{{ str_replace('-', ' ', config('app.name', 'Laravel')) }}</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/colors/color1.css') }}" />
</head>

<body>
    <div class="login-img">
        <div id="global-loader">
            <img src="{{ asset('assets') }}/images/loader.svg" class="loader-img" alt="Loader">
        </div>
        <div class="page">
            <div class="">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('js/auth.js') }}"></script>

</body>

</html>
