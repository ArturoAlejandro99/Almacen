@extends('layouts.formulario')

@section('title', 'Bobinas')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Bobinas')

@section('retornar')
<a href="{{route('coil.index')}}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection
    
@section('form')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{$coil->nomenclatura}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Fecha llegada</label>
            <input type="datetime" class="form-control" name="fArribo" value="{{$coil->fArribo}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Tipo bobina</label>
            <input type="text" class="form-control" name="idTipoBobina" value="{{$coil->coilType->alias}}" disabled>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Proveedor</label>
            <input type="text" class="form-control" name="provider_id" value="{{$coil->provider->nombreEmpresa ?? ''}}" disabled>
        </div>
        <div class="col-lg-4 px-2 disponible">
            <label>Status</label>
            <input type="datetime" class="form-control" name="status" value="{{$coil->status}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Largo (metros)</label>
            <input type="text" class="form-control" name="largoM" value="{{$coil->largoM}}" disabled>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Bruto (Kg)</label>
            <input type="text" class="form-control" name="pesoBruto" value="{{$coil->pesoBruto}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Neto (Kg)</label>
            <input type="datetime" class="form-control" name="pesoNeto" value="{{$coil->pesoNeto}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Utilizado (Kg)</label>
            <input type="text" class="form-control" name="pesoUtilizado" value="{{$coil->pesoUtilizado}}" disabled>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Exterior</label>
            <input type="text" class="form-control" name="diametroExterno" value="{{$coil->diametroExterno}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Bobina</label>
            <input type="datetime" class="form-control" name="diametroBobina"value="{{$coil->diametroBobina}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Diametro Interior</label>
            <input type="text" class="form-control" name="diametroInterno" value="{{$coil->diametroInterno}}" disabled>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Costo</label>
            <input type="text" class="form-control" name="costo" value="{{$coil->costo}}" disabled>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 pl-0 pr-0">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" disabled>{{$coil->observaciones}}</textarea>
        </div>
    <div class="col-12 mt-5 text-center">
        <form action="{{ route('coil.destroy', $coil) }}" method="POST" id="formularioDestroy">
            @csrf
            @method('delete')
            
            @can('coil.edit', Model::class)
                <a class="btn btn-warning mx-3 mb-5" href="{{route('coil.edit', $coil->id)}}">Editar</a>
            @endcan

            @can('coil.terminar')
                <button class="btn btn-outline-danger mx-3 mb-5" >Terminar</button>
            @endcan

            @can('coil.destroy')
               <button class="btn btn-danger mx-3 mb-5" type="submit" >Eliminar</button>
            @endcan

            @if($errors->any())
            <div class="col-12 mt-3 text-center">
                <br>
                    <div class="alert alert-danger">
                        {{$errors->first()}}
                    </div>
                    <br>
            </div>
            @endif
        </form>
    </div>    

    <div class="col-lg-12 my-3">
    <h3><img src="{{ asset('images/rollo-de-papel.svg') }}" class="iconoTitle"> Rollos </h3>
    <a class="btn btn-success float-right mb-3"  data-toggle="modal" data-target="#createProduct">Nuevo Rollo</a>
    <!--Tabla para rollos relacionados-->
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
        @foreach ($ribbons as $item)
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
        @if ($item->coil_product_type == 'App\Models\Ribbon')
        <td><a href="{{route('ribbon.show',$item->coil_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @elseif($item->coil_product_type == 'App\Models\WasteRibbon')
        <td><a href="{{route('wasteRibbon.show',$item->coil_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @elseif($item->coil_product_type == 'App\Models\CoilReel')
        <td><a href="{{route('coilReel.show',$item->coil_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @endif
        </tr>
      @endforeach
    </tbody>
    </table>
    </div>
<!--Tabla para bolsas relacionadas-->
<h3 class="mt-5"> <img src="{{ asset('images/bolsa-de-papel.svg') }}" class="iconoTitle"> Bolsas </h3>
<div class="table-responsive">
<table class="table table-striped my-4" >
    <thead class="bg-info">
<tr>
    <th scope="col">#</th>
    <th scope="col">Nomenclatura</th>
    <th scope="col">Peso</th>
    <th scope="col">Medida</th>
    <th scope="col">Fecha Adquisición</th>
    <th scope="col">Status</th>
    <th scope="col"></th>
  </tr>
</thead>
<tbody>
    @foreach ($ribbonProduct as $item)

    <tr>
        <th scope="row" class="align-middle">{{$item->id}}</th>
        <td class="align-middle">{{$item->nomenclatura}}</td>
        <td class="align-middle">{{$item->peso}}</td>
        <td class="align-middle">{{$item->medidaBolsa}}</td>
        <td class="align-middle">{{$item->fAdquisicion}}</td>
        <td class="align-middle"><label class="btn btn-outline-{{ ($item->status == 'DISPONIBLE') ? 'success' : 'danger' }} m-0">{{$item->status}}</label></td>
       <!--Realizamos if para validacion de adonde dirgir el show-->
    @if ($item->ribbon_product_type == 'App\Models\Bag')
    <td><a href="{{route('bag.show',$item->ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    @elseif($item->ribbon_product_type == 'App\Models\WasteBag')
    <td><a href="{{route('wasteBag.show',$item->ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    @elseif($item->ribbon_product_type == 'App\Models\RibbonReel')
    <td><a href="{{route('ribbonReel.show',$item->ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    @endif
    </tr>
  @endforeach
</tbody>
</table>
</div>    
</div>
</div>
@include('coils.modalTypeSelection')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $('#formularioDestroy').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Está seguro?',
        text: "La bobina se eliminará definitivamente.",
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

<script type="text/javascript">
    function terminar(id){
        var opcion = confirm("¿Esta seguro que desea terminar la bobina?");
        if (opcion == true) {
        location.replace ("http://bolsasdecelofanminabi.com.mx/coil/terminar/"+id)
	    } 
    }

</script>
@endsection