@extends('layouts.formulario')

@section('title', 'Registrar Medida de Bobina')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Registrar Medida de Bobina')

@section('form')
<form action="{{ route('coilType.store') }}" method="POST">
    @csrf
    <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Alias</label>
                <input type="text" class="form-control" name="alias" value="{{ old('alias') }}">
                @error('alias')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Ancho (cm)</label>
                <input type="number" step="0.0001" class="form-control" name="anchoCm" value="{{ old('anchoCm') }}">
                @error('anchoCm')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span> Largo (m)</label>
                <input type="number" step="0.0001" class="form-control" name="largoM" value="{{ old('largoM') }}">
                @error('largoM')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Densidad</label>
                <input type="number" step="0.0001" class="form-control" name="densidad" value="{{ old('densidad') }}">
                @error('densidad')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Material</label>
                <input type="text" class="form-control" name="material" value="{{ old('material') }}">
                @error('material')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Calibre</label>
                <input type="number" step="0.0001" class="form-control" name="calibre" value="{{ old('calibre') }}">
                @error('calibre')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span> Tipo</label>
                <select class="form-control" name="tipo">
                    <option value="" class="text-muted" selected disabled>--seleccione tipo--</option>
                    <option value="CELOFAN" {{ (old('tipo') == 'CELOFAN') ? 'selected' : '' }}>CELOFÁN</option>
                    <option value="CENEFA" {{ (old('tipo') == 'CENEFA') ? 'selected' : '' }}>CENEFA</option>
                </select>
                @error('tipo')
                    <div class="alert alert-danger mt-2">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        <div class="col-lg-12 d-flex mt-4">
            <div class="col-lg-12 px-2">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones" placeholder="Máximo 255 caracteres">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                        <div class="alert alert-danger mt-2">
                            <small>{{ $message }}</small>
                        </div>
                @enderror
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3 text-center">
            <a class="btn btn-danger mx-3" href="{{ route('coilType.index') }}">Cancelar</a>
            <button type="submit" name="coilTypeForm" class="btn btn-success mx-3">Guardar</button>
        </div>
    </div>
</form>
@endsection