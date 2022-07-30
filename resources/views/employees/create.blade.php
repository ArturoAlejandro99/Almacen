@extends('layouts.formulario')

@section('title', 'Registrar Empleado')

@section('imgUrl',  asset('images/empleado.svg'))

@section('namePage', 'Registrar Empleado')

@section('form')
<form action="{{ route('employee.store') }}" method="POST">
    @csrf
    <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                @error('nombre')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12  px-2 mt-2">
                <label><span class="required">*</span> Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fNacimiento" value="{{ old('fNacimiento') }}">
                @error('fNacimiento')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Fecha de Ingreso</label>
                <input type="date" class="form-control" name="fIngreso" value="{{ old('fIngreso') }}">
                @error('fIngreso')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Años de Antigüedad</label>
                <input type="number" class="form-control" name="antiguedad" value="{{ old('antiguedad') }}">
                @error('antiguedad')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Sueldo por Hora</label>
                <input type="number" step="0.0001" class="form-control" name="sueldoHora" value="{{ old('sueldoHora') }}">
                @error('sueldoHora')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Teléfono</label>
                <input type="number" class="form-control" name="telefono" value="{{ old('telefono') }}">
                @error('telefono')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Status</label>
                <input type="text" class="form-control" name="status" value="ACTIVO" readonly>
                @error('status')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3 text-center">
            <a class="btn btn-danger mx-3" href={{ route('employee.index') }}>Cancelar</a>
            <button type="submit" class="btn btn-success mx-3">Guardar</button>
        </div>    
    </div>
</form>
@endsection


