@extends('layouts.formulario')

@section('title', 'Rol')

@section('imgUrl',  asset('images/usuario.svg'))

@section('namePage', 'Rol')

@section('retornar')
<a href="{{route('rol.index')}}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection
    
@section('form')
<form action="{{ route('rol.update', $rol->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden"  name="id" value="{{$rol->id}}">
<div class="row">
    <div class="col-lg-12 d-flex mt-2">
        <div class="col-lg-8 px-2">
            <label>Nombre del permiso</label>
            <input type="text" class="form-control" name="name" value="{{$rol->name}}">
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
            <input class="form-check-input" type="checkbox" name="permisos[]" value="{{$permiso->id}}" id="{{$permiso->id}}" {{(in_array($permiso->id, $arreglo, false)? 'checked' : '')}}>
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
@endsection