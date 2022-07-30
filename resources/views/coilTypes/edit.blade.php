@extends('layouts.formulario')

@section('title', 'Editar Medida de Bobina')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Editar Tipo de Bobina ' . $coilType->alias)

@section('form')
<form action="{{ route('coilType.update', $coilType) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Alias</label>
                <input type="text" class="form-control" name="alias" value="{{ old('alias', $coilType->alias) }}">
                @error('alias')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Ancho (cm)</label>
                <input type="number" step="0.0001" class="form-control" name="anchoCm" value="{{ old('anchoCm', $coilType->anchoCm) }}">
                @error('anchoCm')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Largo (m)</label>
                <input type="number" step="0.0001" class="form-control" name="largoM" value="{{ old('largoM', $coilType->largoM) }}">
                @error('largoM')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Densidad</label>
                <input type="number" step="0.0001" class="form-control" name="densidad" value="{{ old('densidad', $coilType->densidad) }}">
                @error('densidad')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Material</label>
                <input type="text" class="form-control" name="material" value="{{ old('material', $coilType->material) }}">
                @error('material')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Calibre</label>
                <input type="number" step="0.0001" class="form-control" name="calibre" value="{{ old('calibre', $coilType->calibre) }}">
                @error('calibre')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Tipo</label>
                <select class="form-control" name="tipo">
                    <option {{ (old('tipo', $coilType->tipo) == 'CELOFAN') ? 'selected' : '' }} value="CELOFAN">CELOFÁN</option>
                    <option {{ (old('tipo', $coilType->tipo) == 'CENEFA') ? 'selected' : '' }} value="CENEFA">CENEFA</option>
                </select>
                @error('tipo')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-12 d-flex mt-4">
            <div class="col-lg-12 px-2">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones" placeholder="Máximo 255 caracteres">{{ old('observaciones', $coilType->observaciones) }}</textarea>
                @error('observaciones')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-12 mt-4 mb-4 text-center">
            <a class="btn btn-danger mx-3" href="{{ route('coilType.show', $coilType) }}">Cancelar</a>
            <button type="submit" name="coilTypeForm" class="btn btn-success mx-3">Guardar</button>
        </div>
</form>
@endsection


