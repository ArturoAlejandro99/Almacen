@extends('layouts.formulario')

@section('title', 'Editar Empleado')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Editar Empleado')

@section('form')
<form action="{{ route('employee.update', $employee) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $employee->nombre) }}">
                @error('nombre')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="fNacimiento" value="{{ old('fNacimiento', $employee->fNacimiento) }}">
                @error('fNacimiento')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Fecha de Ingreso</label>
                <input type="date" class="form-control" name="fIngreso" value="{{ old('fIngreso', $employee->fIngreso) }}">
                @error('fIngreso')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Años de Antigüedad</label>
                <input type="number" class="form-control" name="antiguedad" value="{{ old('antiguedad', $employee->antiguedad) }}">
                @error('antiguedad')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Sueldo por Hora</label>
                <input type="number" step="0.0001" class="form-control" name="sueldoHora" value="{{  old('sueldoHora', $employee->sueldoHora) }}">
                @error('sueldoHora')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Teléfono</label>
                <input type="number" class="form-control" name="telefono" value="{{ old('telefono', $employee->telefono) }}">
                @error('telefono')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option {{ ( (old('status', $employee->status)) === 'ACTIVO') ? 'selected' : '' }} value="ACTIVO">
                        ACTIVO
                    </option>
                    <option {{ ( (old('status', $employee->status)) === 'DE BAJA') ? 'selected' : '' }} value="DE BAJA">
                        DE BAJA
                    </option>
                </select>
                @error('status')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3 text-center">
            <a class="btn btn-danger mx-3" href="{{ route('employee.show', $employee) }}">Cancelar</a>
            <button type="submit" class="btn btn-success mx-3">Guardar</button>
        </div>    
    </div>
</form>
@endsection


