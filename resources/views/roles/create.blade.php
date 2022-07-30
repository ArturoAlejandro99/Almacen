@extends('layouts.formulario')

@section('title', 'Roles')

@section('imgUrl',  asset('images/usuario.svg'))

@section('namePage', 'Rol')

@section('form')
<form action="{{ route('rol.store') }}" method="POST">
    @csrf
    <div class="row">
    <div class="col-lg-12 d-flex mt-2">
        <div class="col-lg-8 px-2">
            <label>Nombre del permiso</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}">
            @error('name')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
    </div>
    <div class="col-lg-12 mt-2">
        @foreach ($permisos as $permiso)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="permisos[]" value="{{$permiso->id}}" id="{{$permiso->id}}}">
            <label class="form-check-label" for="flexCheckDefault">
            {{$permiso->description}}
            </label>
          </div>
        @endforeach
    </div>
    <div class="col-12 mt-4 mb-4 text-center">
        <a class="btn btn-danger mx-3" href="{{route('rol.index')}}">Cancelar</a>
        <button type="submit" class="btn btn-success mx-3">Guardar</button>
    </div>
</div>
</form>
@endsection