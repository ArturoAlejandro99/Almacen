@extends('layouts.formulario')

@section('title', 'Registrar Usuarios')

@section('imgUrl',  asset('images/usuario.svg'))

@section('namePage', 'Registrar Usuarios')

@section('form')
<form action="{{route('user.store')}}" method="POST">
    @csrf
    <div class="row">
           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Nombre</label>
                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
            </div>
           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Correo</label>
                <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
            </div>
           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Contraseña</label>
                <input type="password" class="form-control" name="password"  required >
            </div>

           <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Rol</label>
            <select class="form-control" name="role_id">
                <option selected value="" class="text-muted" disabled>--seleccione un rol--</option>
                @foreach($roles as $rol)
                    <option value={{ $rol->id }}>
                        {{ $rol->name }}
                    </option>
                @endforeach
            </select>
            </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 text-center">
            <a class="btn btn-danger mx-3" href="{{route('user.index')}}">Cancelar</a>
            <button type="submit" class="btn btn-success mx-3">Guardar</button>
        </div> 
    </div>
</form>
@endsection
