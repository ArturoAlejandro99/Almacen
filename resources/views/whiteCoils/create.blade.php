@extends('layouts.formulario')

@section('title', 'Bobina cinta blanca')

@section('imgUrl',  asset('images/base-de-datos.svg'))

@section('namePage', 'Bobinas cinta blanca')

@section('form')
<form action="{{ route('whiteCoil.store') }}" method="POST">
    @csrf
    <div class="row">
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label><span class="required">*</span> Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{old('nomenclatura')}}" id="nomenclaturas">
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
            <input type="date" class="form-control" name="fArribo" value="{{old('fArribo')}}"  id="fArribo">
            @error('fArribo')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>
        <script type="text/javascript">
            function llenaNomen(){
                var fecha = document.getElementById("fArribo");
                var folio =  document.getElementById("nomenclaturas");
                fecha = fecha.value.replace(/-/g, "");
                folio.value = "MNB"+fecha.substring(6,8)+fecha.substring(4,6)+fecha.substring(0,4);
            }
        </script>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Tipo bobina</label>
            <select class="form-control" name="coil_type_id">
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
            <label>Proveedor</label>
            <select class="form-control" name="provider_id">
                <option selected value="" class="text-muted" disabled>--seleccione proveedor--</option>
                @foreach($providers as $provider)
                    <option value={{ $provider->id }} {{ ($provider->id == old('provider_id')) ? 'selected' : '' }}>
                        {{ $provider->nombreEmpresa }}
                    </option>
                @endforeach
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
            <label><span class="required">*</span> Costo</label>
            <input type="number" step="0.0001" class="form-control" name="costo" value="{{old('costo')}}">
            @error('costo')
                <br>
                <div class="alert alert-danger">
                <small>{{$message}}</small>
                </div>
                <br>
            @enderror
        </div>

       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label><span class="required">*</span> Peso( Kg)</label>
            <input type="number" step="0.0001" class="form-control" name="peso" value="{{old('peso')}}">
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
            <input type="number" step="0.0001" class="form-control" name="pesoUtilizado" value="0" readonly>
        </div>

    <div class="col-lg-12 col-md-12 col-sm-12 d-flex mt-4">
        <div class="col-lg-12 px-2">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones">{{old('observaciones')}}</textarea>
        </div>
    </div>
    
   {{-- @if( Route::is('coil.createFromProvider') )
        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
    @endif--}}

    <div class="col-12 mt-4 mb-4 text-center">
        <a class="btn btn-danger mx-3" href="{{route('whiteCoil.index')}}">Cancelar</a>
        <button type="submit" class="btn btn-success mx-3">Guardar</button>
    </div>
</div>

</form>
@endsection