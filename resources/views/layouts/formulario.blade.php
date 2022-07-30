@extends('layouts.plantilla')

@section('content')
    <div class="container">
        @yield('retornar')
        
        <h1 class="mt-5"> <img src="@yield('imgUrl')" class="iconoTitle"> @yield('namePage') </h1>
        <h3> Información General </h3>
    <!-- Formulario -->
        @yield('form')
    </div>
@endsection

    