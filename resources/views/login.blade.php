<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<!-- Shortcut icon -->
    <link rel="shortcut icon" href="{{ asset('images/logotipo.png') }}">
<!-- Título -->
    <title> MINABI </title>
<!-- Bootstrap -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- HTML -->
    <link rel="stylesheet" href="{{ asset('css/general.css') }}"/>
</head>
<body>
    <div class="m-5" href="/">
        <img src={{ asset('images/logotipo.png') }} width="30" height="43" class="d-inline-block align-center" alt="">
        <b> MINABI </b>
    <div class="container">
        <div class=" justify-content-center mt-5 row">
            <div class="col-lg-9">
                <h3 class="text-info font-weight-bold">BIENVENID@</h3>
                <h4 class="font-weight-bold">POR FAVOR INICIA SESIÓN</h4>
                <form method="POST">
                @csrf
                <div class="row mt-4">
                    <div class="col-lg-1 d-flex">
                        <img src={{ asset('images/usuario.svg') }}  class="iconosLogin" style="width: 45px; height: 45px; align-self: center;" alt="">
                    </div>
                    <div class="col-lg-8">
                        <h6 class="text-info font-weight-bold">Usuario</h6>
                        <input class="form-control" type="text" placeholder="Usuario" name="email" value="{{old('email')}}" >
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-1 d-flex">
                        <img src={{ asset('images/bloquear.svg') }}  class="iconosLogin" style="width: 45px; height: 45px; align-self: center;" alt="">
                    </div>
                    <div class="col-lg-8">
                        <h6 class="text-info font-weight-bold">Contraseña</h6>
                        <input class="form-control" type="password" placeholder="Contraseña" name="password">
                    </div>
                </div>
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Recordar Usuario
                    </label>
                  </div>
                <div class="float-right">
                <button class="btn btn-info mr-5">Iniciar sesion</button>
                </div>
                @foreach ($errors->all() as $error)
                <div class="mt-3 text-center">
                    <br>
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                        <br>
                </div>
                @endforeach
            </form>
            </div>
            
            <div class="col-lg-3 bg-info text-center">
                <img src={{ asset('images/logotipo.png') }} width="170" height="300" class="my-5" alt="">
            </div>
        </div>
    </div>
    </div>
</body>
</html>