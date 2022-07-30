@extends('layouts.formulario')

@section('title', 'Bobinas')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Bobinas ' . $coil->nomenclatura)

@section('form')
<form action="{{route('coil.update', $coil)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{$coil->nomenclatura}}" id="nomenclaturas" readonly>
            @error('nomenclatura')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Fecha llegada</label>
            <input type="date" class="form-control" name="fArribo" value="{{old('fArribo', $coil->fArribo)}}" id="fArribo" readonly>
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
            <input class="form-control" name="coil_type_id" id="tipo" value="{{ $coilType->alias }}"  readonly>
            @error('coil_type_id')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Proveedor</label>
            <select class="form-control" name="provider_id">
                @foreach($providers as $provider)
                    <option {{ ($coil->provider->id == $provider->id)? 'selected': ''}} value={{ $provider->id }}>
                        {{ $provider->nombreEmpresa }}
                    </option>
                @endforeach
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
            <label>Status</label>
            <input type="datetime" class="form-control" name="status" value="{{$coil->status}}" readonly>
            @error('status')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Largo (metros)</label>
            <input type="number" step="0.0001" class="form-control" name="largoM" value="{{old('largoM', $coil->largoM)}}">
            @error('largoM')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Bruto (Kg)</label>
            <input type="number" step="0.0001" class="form-control" name="pesoBruto" value="{{old('pesoBruto', $coil->pesoBruto)}}">
            @error('pesoBruto')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Neto (Kg)</label>
            <input type="number" step="0.0001" class="form-control" name="pesoNeto" value="{{$coil->pesoNeto}}" readonly>
            @error('pesoNeto')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Utilizado (Kg)</label>
            <input type="number" step="0.0001"class="form-control" name="pesoUtilizado" value="{{$coil->pesoUtilizado}}" readonly>
        </div>
        
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Exterior</label>
            <input type="number" step="0.0001" class="form-control" name="diametroExterno" value="{{old('diametroExterno', $coil->diametroExterno)}}">
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Bobina</label>
            <input type="number" step="0.0001" class="form-control" name="diametroBobina"value="{{old('diametroBobina', $coil->diametroBobina)}}">
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Interior</label>
            <input type="number" step="0.0001" class="form-control" name="diametroInterno" value="{{old('diametroInterno', $coil->diametroInterno)}}">
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Costo</label>
            <input type="number" step="0.0001" class="form-control" name="costo" value="{{old('costo', $coil->costo)}}">
            @error('costo')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 pl-0 pr-0">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" placeholder="Máximo 255 caracteres">{{old('observaciones', $coil->observaciones)}}</textarea>
            @error('observaciones')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>

    <div class="col-12 mt-4 mb-4 text-center">
        <a class="btn btn-danger mx-3" href="{{route('coil.show', $coil->id)}}">Cancelar</a>
        <button type="submit" class="btn btn-success mx-3">Guardar</button>
    </div>
</div>
</form>
<script type="text/javascript">
    function llenaNomen(){
        var fecha = document.getElementById("fArribo");
        var tipo = document.getElementById("tipo");
        var seleccion = tipo.options[tipo.selectedIndex].text;
        var folio =  document.getElementById("nomenclaturas");
        fecha = fecha.value.replace(/-/g, "");
        folio.value = "MNB"+seleccion+fecha.substring(6,8)+fecha.substring(4,6)+fecha.substring(0,4);
    }
</script>
@endsection