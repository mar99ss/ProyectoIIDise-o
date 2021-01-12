<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Proyecto I Diseño</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @yield('hlinks')
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body>

@yield('hcontent')

@yield('hscripts')

</body>
</html>
