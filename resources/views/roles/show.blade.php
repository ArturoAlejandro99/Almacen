@extends('layouts.formulario')

@section('title', 'Rol')

@section('imgUrl',  asset('images/usuario.svg'))

@section('namePage', 'Rol')

@section('retornar')
<a href="{{route('rol.index')}}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection
    
@section('form')
<div class="row">
    <div class="col-lg-12 d-flex mt-2">
        <div class="col-lg-8 px-2">
            <label>Nombre del permiso</label>
            <input type="text" class="form-control" name="name" value="{{$rol->name}}" readonly>
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
            <input class="form-check-input" type="checkbox" readonly checked>
            <label class="form-check-label" for="flexCheckDefault">
            {{$permiso->description}}
            </label>
          </div>
        @endforeach
    </div>
    <div class="col-12 mt-4 mb-4 text-center">
        <form action="{{ route('rol.destroy', $rol) }}" method="POST" id="formularioDestroy">
            @csrf
            @method('delete')

            @can('rol.edit')
                <a class="btn btn-warning mx-3" href="{{route('rol.edit', $rol)}}">Editar</a>
            @endcan
            @can('rol.destroy')
                <button class="btn btn-danger mx-3" type="submit">Eliminar</button>
            @endcan
        </form>
    </div>       
</div>
@endsection

@section('scripts')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $('#formularioDestroy').submit(function(e){
            e.preventDefault();
            Swal.fire({
            title: '¿Está seguro?',
            text: "El rol se eliminará definitivamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
            })
        });        
    </script>
@endsection