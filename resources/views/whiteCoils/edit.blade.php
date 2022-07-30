@extends('layouts.formulario')

@section('title', 'Bobinas')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Bobinas ' . $whiteCoil->nomenclatura)

@section('form')
<form action="{{route('whiteCoil.update', $whiteCoil)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label><span class="required">*</span> Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{$whiteCoil->nomenclatura}}" readonly>
            @error('nomenclatura')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label><span class="required">*</span> Fecha llegada</label>
            <input type="datetime" class="form-control" name="fArribo" value="{{$whiteCoil->fArribo}}" readonly>
            @error('fArribo')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Tipo bobina</label>
            <select class="form-control" name="coil_type_id">
                @if($whiteCoil->coilType != null)
                    @foreach($coilTypes as $coilType)
                        <option {{ ($coilType->id == $whiteCoil->coilType->id) ? 'selected' : '' }} value="{{ $coilType->id }}" readonly>
                            {{ $coilType->alias }}
                        </option>
                    @endforeach
                @else
                    <option selected value="" class="text-muted" disabled>--seleccione tipo de bobina--</option> 
                    @foreach($coilTypes as $coilType)    
                        <option value={{ $coilType->id }}>
                            {{ $coilType->alias }}
                        </option>
                    @endforeach
                @endif
                <option value="">Ninguno</option>
            </select>
        </div>

       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Proveedor</label>
            <select class="form-control" name="provider_id">
                @if($whiteCoil->provider != null)
                    @foreach($providers as $provider)
                        <option {{ ($provider->id == $whiteCoil->provider->id) ? 'selected' : '' }} value={{ $provider->id }}>
                            {{ $provider->nombreEmpresa }}
                        </option>
                    @endforeach
                @else
                    <option selected value="" class="text-muted" disabled>--seleccione tipo de bobina--</option>
                    @foreach($providers as $provider)
                        <option value={{ $provider->id }}>
                            {{ $provider->nombreEmpresa }}
                        </option>
                    @endforeach
                @endif
                <option value="">Ninguno</option>
            </select>
            @error('provider_id')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span> Status</label>
            <input type="datetime" class="form-control" name="status" value="{{$whiteCoil->status}}" readonly>
            @error('status')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span> Costo</label>
            <input type="number" step="0.0001" class="form-control" name="costo" value="{{$whiteCoil->costo}}">
            @error('costo')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>

       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span> Peso (Kg)</label>
            <input type="number" step="0.0001" class="form-control" name="peso" value="{{$whiteCoil->peso}}">
            @error('peso')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span> Peso Utilizado (Kg)</label>
            <input type="number" step="0.0001"class="form-control" name="pesoUtilizado" value="{{$whiteCoil->pesoUtilizado}}" readonly>
        </div>

    <div class="col-lg-12 col-md-12 col-sm-12 d-flex mt-4">
        <div class="col-lg-12 px-2">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" placeholder="Máximo 255 caracteres">{{$whiteCoil->observaciones}}</textarea>
            @error('observaciones')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
    </div>

    <div class="col-12 mt-4 mb-4 text-center">
        <a class="btn btn-danger mx-3" href="{{route('whiteCoil.show', $whiteCoil->id)}}">Cancelar</a>
        <button type="submit" class="btn btn-success mx-3">Guardar</button>
    </div>
</div>
</form>
@endsection