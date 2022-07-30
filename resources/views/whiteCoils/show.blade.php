@extends('layouts.formulario')

@section('title', 'Bobinas de cinta blanca')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Bobinas de cinta blanca')

@section('retornar')
<a href="{{route('whiteCoil.index')}}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection
    
@section('form')
    <div class="row">
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{$whiteCoil->nomenclatura}}" disabled>
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Fecha llegada</label>
            <input type="datetime" class="form-control" name="fArribo" value="{{$whiteCoil->fArribo}}" disabled>
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Tipo bobina</label>
            <input type="text" class="form-control" name="coil_type_id" value="{{(($coilType = $whiteCoil->coilType) != null) ? $coilType->alias : ''}}" disabled>
        </div>

       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Proveedor</label>
            <input type="text" class="form-control" name="provider_id" value="{{(($provider = $whiteCoil->provider) != null) ? $provider->nombreEmpresa : ''}}" disabled>
        </div>
        <div class="col-lg-4 px-2 disponible">
            <label>Status</label>
            <input type="datetime" class="form-control" name="status" value="{{$whiteCoil->status}}" disabled>
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Costo</label>
            <input type="number" step="0.0001" class="form-control" name="costo" value="{{$whiteCoil->costo}}" disabled>
        </div>

       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso (Kg)</label>
            <input type="text" class="form-control" name="peso" value="{{$whiteCoil->peso}}" disabled>
        </div>
       <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Utilizado (Kg)</label>
            <input type="text" class="form-control" name="pesoUtilizado" value="{{$whiteCoil->pesoUtilizado}}" disabled>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 px-2">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" disabled>{{$whiteCoil->observaciones}}</textarea>
        </div>
    <div class="col-12 mt-5 text-center">
        <form action="{{ route('whiteCoil.destroy', $whiteCoil) }}" method="POST" id="formularioDestroy">
            @csrf
            @method('delete')

            @can('whiteCoil.edit')
                <a class="btn btn-warning mx-3 mb-5" href="{{route('whiteCoil.edit', $whiteCoil->id)}}">Editar</a>
            @endcan
            @can('whiteCoil.destroy')
                <button class="btn btn-danger mx-3 mb-5" type="submit">Eliminar</button>
            @endcan
        </form>
    </div>
    <div class="col-lg-12 my-3">
    <h3><img src="{{ asset('images/cinta.svg') }}" class="iconoTitle"> Rollos de Cinta </h3>
    <a class="btn btn-success float-right mb-3"  data-toggle="modal" data-target="#createProduct">Nueva Cinta</a>
    <!--Tabla para rollos de cinta relacionados-->
    <div class="table-responsive">
    <table class="table table-striped my-4" >
        <thead class="bg-info">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nomenclatura</th>
        <th scope="col">Peso</th>
        <th scope="col">Fecha Adquisición</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
        @foreach ($whiteRibbons as $item)
        <tr>
            <th scope="row" class="align-middle">{{$item->id}}</th>
            <td class="align-middle">{{$item->nomenclatura}}</td>
            <td class="align-middle">{{$item->peso}}</td>
            <td class="align-middle">{{$item->fAdquisicion}}</td>
            <td class="align-middle">
                <label class="btn btn-outline-{{ ($item->status == 'DISPONIBLE') ? 'success' : 'danger' }} m-0">
                    {{$item->status}}
                </label>
            </td>
           <!--Realizamos if para validacion de adonde dirgir el show-->
        @if ($item->white_coil_product_type == 'App\Models\WhiteRibbon')
        <td><a href="{{route('whiteRibbon.show',$item->white_coil_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @elseif($item->white_coil_product_type == 'App\Models\WhiteWaste')
        <td><a href="{{route('whiteWaste.show',$item->white_coil_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @endif
        </tr>
      @endforeach
    </tbody>
    </table>
    </div>

<!--Tabla para bolsas relacionadas-->
<h3 class="mt-5"> <img src="{{ asset('images/bolsa-de-papel.svg') }}" class="iconoTitle"> Hueso, Merma o Rollo de Celofán </h3>
<div class="table-responsive">
<table class="table table-striped my-4" >
    <thead class="bg-info">
<tr>
    <th scope="col">#</th>
    <th scope="col">Nomenclatura</th>
    <th scope="col">Fecha Adquisición</th>
    <th scope="col">Status</th>
    <th scope="col"></th>
  </tr>
</thead>
<tbody>
    @foreach ($whiteRibbonProduct as $item)

    <tr>
        <th scope="row" class="align-middle">{{$item->id}}</th>
        <td class="align-middle">{{$item->nomenclatura}}</td>
        <td class="align-middle">{{$item->fAdquisicion}}</td>
        <td class="align-middle"><label class="btn btn-outline-{{ ($item->status == 'DISPONIBLE') ? 'success' : 'danger' }} m-0">{{$item->status}}</label></td>
       <!--Realizamos if para validacion de adonde dirgir el show-->
    @if ($item->white_ribbon_product_type == 'App\Models\Ribbon')
    <td><a href="{{route('ribbon.show',$item->white_ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    @elseif($item->white_ribbon_product_type == 'App\Models\WhiteWasteRibbon')
    <td><a href="{{route('whiteWasteRibbon.show',$item->white_ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    @elseif($item->white_ribbon_product_type == 'App\Models\WhiteRibbonReel')
    <td><a href="{{route('whiteRibbonReel.show',$item->white_ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    @endif
    </tr>
  @endforeach
</tbody>
</table>
</div>    
</div>
</div>
@include('whiteCoils.modalTypeSelection')

@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $('#formularioDestroy').submit(function(e){
            e.preventDefault();
            Swal.fire({
            title: '¿Está seguro?',
            text: "La bobina de cinta blanca se eliminará definitivamente.",
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
