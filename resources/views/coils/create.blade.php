@extends('layouts.formulario')

@section('title', 'Bobinas')

@section('imgUrl',  asset('images/base-de-datos.svg'))

@section('namePage', 'Bobinas')

@section('form')
<form action="{{ route('coil.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{old('nomenclatura')}}" id="nomenclaturas" >
            @error('nomenclatura')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label><span class="required">*</span>Fecha llegada</label>
            <input type="date" class="form-control" name="fArribo" value="{{old('fArribo')}}"  id="fArribo">
            @error('fArribo')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label><span class="required">*</span>Tipo bobina</label>
            <select class="form-control" name="coil_type_id" id="tipo" >
                <option selected value="" class="text-muted" disabled>--seleccione tipo de bobina--</option>
                @foreach($coilTypes as $coilType)
                    <option value={{ $coilType->id }} {{ ($coilType->id == old('coil_type_id')) ? 'selected' : '' }}>
                        {{ $coilType->alias }}
                    </option>
                @endforeach
            </select>
            @error('coil_type_id')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
    

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span>Proveedor</label>
            @if( Route::is('coil.createFromProvider') )
                <input type="text" class="form-control" value={{ $provider->nombreEmpresa }} readonly>    
            @else
                <select class="form-control" name="provider_id">
                    <option selected value="" class="text-muted" disabled>--seleccione proveedor--</option>
                    @foreach($providers as $provider)
                        <option value={{ $provider->id }} {{ ($provider->id == old('provider_id')) ? 'selected' : '' }}>
                            {{ $provider->nombreEmpresa }}
                        </option>
                    @endforeach
                </select>
            @endif
            
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
            <input type="datetime" class="form-control" name="status" value="DISPONIBLE" readonly>
            @error('status')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span>Largo (metros)</label>
            <input type="number" step="0.0001" class="form-control" name="largoM" value="{{old('largoM')}}">
            @error('largoM')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span>Peso Bruto (Kg)</label>
            <input type="number" step="0.0001" class="form-control" name="pesoBruto" value="{{old('pesoBruto')}}">
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
            <input type="number" step="0.0001" class="form-control" name="pesoNeto" value="0" readonly>
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
            <input type="number" step="0.0001" class="form-control" name="pesoUtilizado" value="0" readonly>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Exterior</label>
            <input type="number" step="0.0001" class="form-control" name="diametroExterno" value="{{old('diametroExterno')}}">
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Bobina</label>
            <input type="number" step="0.0001" class="form-control" name="diametroBobina" value="{{old('diametroBobina')}}">
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Interior</label>
            <input type="number" step="0.0001" class="form-control" name="diametroInterno" value="{{old('diametroInterno')}}">
        </div>
    

   
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span>Costo</label>
            <input type="number" step="0.0001" class="form-control" name="costo" value="{{old('costo')}}">
            @error('costo')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
  
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-2">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones">{{old('observaciones')}}</textarea>
        </div>
    
    @if( Route::is('coil.createFromProvider') )
        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
    @endif

    <div class="col-12 mt-4 mb-4 text-center">
        @if( Route::is('coil.createFromProvider') )
            <a class="btn btn-danger mx-3" href="{{route('provider.show', $provider)}}">Cancelar</a>
        @else
            <a class="btn btn-danger mx-3" href="{{route('coil.index')}}">Cancelar</a>
        @endif
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
if(seleccion == "--seleccione tipo de bobina--")
folio.value = "MNB"+fecha.substring(6,8)+fecha.substring(4,6)+fecha.substring(0,4);
else
folio.value = "MNB"+seleccion+fecha.substring(6,8)+fecha.substring(4,6)+fecha.substring(0,4);
}
</script>
@endsection