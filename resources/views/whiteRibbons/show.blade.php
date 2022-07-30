@extends('layouts.formulario')

@section('title', 'Rollo')

@section('imgUrl',  asset('images/cinta.svg'))

@section('namePage', 'Rollo')

@section('retornar')
<a href="{{route('whiteCoilProduct.index')}}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection
    
@section('form')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{$whiteRibbon->nomenclatura}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Status</label>
            <input type="text" class="form-control" name="status" value="{{$whiteRibbon->status}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Peso (KG)</label>
            <input type="text" class="form-control" name="peso" value="{{$whiteRibbon->peso}}" disabled>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Fecha Alta</label>
            <input type="text" class="form-control" name="fArribo" value="{{$whiteRibbon->fArribo}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Largo (metros)</label>
            <input type="text" class="form-control" name="largo" value="{{$whiteRibbon->largo}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Utilizado (KG)</label>
            <input type="datetime" class="form-control" name="pesoUtilizado" value="{{$whiteRibbon->pesoUtilizado}}" disabled>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 px-2">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" disabled>{{$whiteRibbon->observaciones}}</textarea>
        </div>
    </div>

    {{--<div class="col-lg-12 mt-4 mb-2">
        <h3><img src="{{ asset('images/empleado.svg') }}" class="iconoTitle"> Empleados</h3>
        <table class="table table-striped my-4" >
            <thead class="bg-info">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Satus</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($whiteRibbon->employees as $employee)
                    <tr>
                        <th scope="row" class="align-middle">{{$employee->id}}</th>
                        <td class="align-middle">{{$employee->nombre}}</td>
                        <td class="align-middle">{{$employee->status}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>--}}

    <div class="col-12 mt-5 text-center">
        <form action="{{ route('whiteRibbon.destroy', $whiteRibbon) }}" method="POST" id="formularioDestroy">
            @csrf
            @method('delete')

            @can('whiteRibbon.edit')
                <a class="btn btn-warning mx-3" href="{{route('whiteRibbon.edit', $whiteRibbon->id)}}">Editar</a>
            @endcan
            @can('whiteRibbon.destroy')
                <button class="btn btn-danger mx-3" type="submit">Eliminar</button>
            @endcan
        </form>
    </div>

    <div class="col-lg-12 d-flex mt-5">
    <h3><img src="{{ asset('images/base-de-datos.svg') }}" class="iconoTitle">Bobina de cinta blanca <a href="{{route('whiteCoil.show', $whiteCoil->id)}}"><small>Ver Bobina</small></a> </h3>
    </div>
    
        <div class="col-lg-12 col-md-12 col-sm-12 px-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="coilNomenclatura" value="{{$whiteCoil->nomenclatura}}" disabled>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 px-2">
            <label>Fecha Adquisición</label>
            <input type="datetime" class="form-control" name="coilfArribo" value="{{$whiteCoil->fArribo}}" disabled>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 px-2">
            <label>Status</label>
            <input type="text" class="form-control" name="coilStatus" value="{{$whiteCoil->status}}" disabled>
        </div>
    
    <div class="col-lg-12 my-5">
        <h3><img src="{{ asset('images/rollo-de-papel.svg') }}" class="iconoTitle"> Mermas de Cinta blanca y Rollos de celofan</h3>
        <a class="btn btn-success float-right mb-3"  data-toggle="modal" data-target="#createProduct">Nueva Producto</a>
        <div class="table-responsive">
        <table class="table table-striped my-4" >
            <thead class="bg-info">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nomenclatura</th>
            <th scope="col">Largo</th>
            <th scope="col">Fecha Adquisición</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($bag as $item)
    
            <tr>
                <th scope="row" class="align-middle">{{$item->id}}</th>
                <td class="align-middle">{{$item->nomenclatura}}</td>
                <td class="align-middle">{{$item->largo}}</td>
                <td class="align-middle">{{$item->fAdquisicion}}</td>
                <td class="align-middle"><label class="btn btn-outline-{{ ($item->status == 'DISPONIBLE') ? 'success' : 'danger' }} m-0">{{$item->status}}</label></td>
               <!--Realizamos if para validacion de adonde dirgir el show-->
            @if ($item->white_ribbon_product_type == 'App\Models\WhiteRibbonReel')
            <td><a href="{{route('whiteRibbonReel.show',$item->white_ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
            @elseif($item->white_ribbon_product_type == 'App\Models\WhiteWasteRibbon')
            <td><a href="{{route('whiteWasteRibbon.show',$item->white_ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
            @elseif($item->white_ribbon_product_type == 'App\Models\Ribbon')
            <td><a href="{{route('ribbon.show',$item->white_ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
            @endif
            </tr>
          @endforeach
        </tbody>
        </table>
        </div>
    </div>


    @include('whiteRibbons.modalTypeSelection')
</div>

@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @if(session('eliminar') == 'whiteRibbonReel')
        <script>
            Swal.fire(
                '¡Eliminado!',
                'El hueso de cinta blanca se ha eliminado con éxito.',
                'success'
                )
        </script>
    @elseif(session('eliminar') == 'whiteWasteRibbon')
        <script>
            Swal.fire(
                '¡Eliminado!',
                'La merma se ha eliminado con éxito.',
                'success'
                )
        </script>
    @endif

    <script>
        $('#formularioDestroy').submit(function(e){
            e.preventDefault();
            Swal.fire({
            title: '¿Está seguro?',
            text: "El rollo de cinta blanca se eliminará definitivamente.",
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