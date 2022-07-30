<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<!-- Shortcut icon -->
    <link rel="shortcut icon" href="{{ asset('images/logotipo.png') }}">

<!-- Título -->
    <title> @yield('title') </title>

<!-- Bootstrap -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- HTML -->
    <link rel="stylesheet" href="{{ asset('css/general.css') }}"/>

<!--JS-->    
    <script src="{{ asset('js/app.js') }}" defer></script>
<!--Daterangepicker-->     
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
</head>
<body>
<!-- Navbar -->
    @include('layouts.partials.header')
<!-- Contenido -->
    @yield('content')
<!-- Scripts -->       
    @yield('scripts')
</body>
</html>