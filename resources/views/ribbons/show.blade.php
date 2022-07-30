@extends('layouts.formulario')

@section('title', 'Rollo')

@section('imgUrl',  asset('images/rollo-de-papel.svg'))

@section('namePage', 'Rollo')

@section('retornar')
<a href="{{route('coilProduct.index')}}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection
    
@section('form')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value="{{$ribbon->nomenclatura}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Status</label>
            <input type="text" class="form-control" name="status" value="{{$ribbon->status}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Largo (metros)</label>
            <input type="text" class="form-control" name="largo" value="{{$ribbon->largo}}" disabled>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso (KG)</label>
            <input type="text" class="form-control" name="peso" value="{{$ribbon->peso}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Fecha Inicio</label>
            <input type="text" class="form-control" name="fechaInicioTrabajo" value="{{$ribbon->fechaInicioTrabajo}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Hora Inicio</label>
            <input type="time" class="form-control" name="horaInicioTrabajo" value="{{$ribbon->horaInicioTrabajo}}" disabled>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso Utilizado (KG)</label>
            <input type="datetime" class="form-control" name="pesoUtilizado" value="{{$ribbon->pesoUtilizado}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Fecha Termino</label>
            <input type="text" class="form-control" name="fechaFinTrabajo" value="{{$ribbon->fechaFinTrabajo}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Hora Termino</label>
            <input type="time" class="form-control" name="horaFinTrabajo" value="{{$ribbon->horaFinTrabajo}}" disabled>
        </div>
 

    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
        <label>Temperatura (C°)</label>
        <input type="text" class="form-control" name="temperatura" value="{{$ribbon->temperatura}}" disabled>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
        <label>Velocidad</label>
        <input type="text" class="form-control" name="velocidad" value="{{$ribbon->velocidad}}" disabled>
    </div>
 
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" disabled>{{$ribbon->observaciones}}</textarea>
        </div>

    <div class="col-lg-12 mt-4 mb-2">
        <h3><img src="{{ asset('images/empleado.svg') }}" class="iconoTitle"> Empleados</h3>
        <table class="table table-striped my-4" >
            <thead class="bg-info">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Minutos Trabajados</th>
                <th scope="col">Sueldo por hora</th>
                <th scope="col">Costo de Mano de obra</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($ribbon->employees as $employee)
                    <tr>
                        <th scope="row" class="align-middle">{{$employee->id}}</th>
                        <td class="align-middle">{{$employee->nombre}}</td>
                        <td class="align-middle">{{$minutosLaborados}}</td>
                        <td class="align-middle">$ {{$employee->sueldoHora}}</td>
                        <td class="align-middle">$ {{($employee->sueldoHora/60)*$minutosLaborados}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($coil->status == 'TERMINADA')
    
    <div class="col-12 mt-2 mb-2 text-right">
        <h3 class="text-left"><img src="{{ asset('images/moneda-de-dinero.svg') }}" class="iconoTitle"> Costos</h3>
        <div class="d-flex">
            <div class="h5 col-10 ">Costo materia prima Cenefa=</div>
            <div class="h5 col-2 ">$ {{round($ribbon->costoCinta, 4)}}</div>
        </div>
        <div class="d-flex">
            <div class="h5 col-10 ">Costo materia prima Celofan=</div>
            <div class="h5 col-2 ">$ {{round($ribbon->costoCelofan, 4)}}</div>
        </div>
        <div class="d-flex">
            <div class="h5 col-10">Costo de mano de obra =</div>
            <div class="h5 col-2">$ {{round(($ribbon->employees->sum('sueldoHora')/60*$minutosLaborados),4)}}</div>
        </div>
        <hr>
        <div class="d-flex">
            <div class="h5 col-10">Total =</div>
            <div class="h5 col-2">$ {{round((($ribbon->employees->sum('sueldoHora'))/60*$minutosLaborados)+$ribbon->costoCelofan + $ribbon->costoCinta,4)}}</div>
        </div>
    </div>
    @endif 

    
    <div class="col-12 mt-2 mb-2 text-center">
        <form action="{{ route('ribbon.destroy', $ribbon) }}" method="POST" id="formularioDestroy">
            @csrf
            @method('delete')

            @can('ribbon.edit')
                <a class="btn btn-warning mx-3" href="{{route('ribbon.edit', $ribbon->id)}}">Editar</a>
            @endcan
            @can('ribbon.destroy')
                <button class="btn btn-danger mx-3" type="submit">Eliminar</button>
            @endcan
        </form>
    </div>
    
    
    <div class="col-lg-12 d-flex mt-5">
    <h3><img src="{{ asset('images/bobina.svg') }}" class="iconoTitle">Bobina <a href="{{route('coil.show', $coil->id)}}"><small>Ver Bobina</small></a> </h3>
    </div>
    
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="coilNomenclatura" value="{{$coil->nomenclatura}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Fecha Adquisición</label>
            <input type="datetime" class="form-control" name="coilfArribo" value="{{$coil->fArribo}}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Status</label>
            <input type="text" class="form-control" name="coilStatus" value="{{$coil->status}}" disabled>
        </div>

    @if (!$cinta->isEmpty())
        <div class="col-lg-12 my-5">
            <h3><img src="{{ asset('images/cinta.svg') }}" class="iconoTitle"> Cinta blanca</h3>
            <div class="table-responsive">
            <table class="table table-striped my-4" >
                <thead class="bg-info">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nomenclatura</th>
                <th scope="col">Fecha Adquisición</th>
                <th scope="col">Largo</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($cinta as $item)
        
                <tr>
                    <th scope="row" class="align-middle">{{$item->id}}</th>
                    <td class="align-middle">{{$item->nomenclatura}}</td>
                    <td class="align-middle">{{$item->fArribo}}</td>
                    <td class="align-middle">{{$item->pivot->largo}}</td>
                    <td class="align-middle"><label class="btn btn-outline-{{ ($item->status == 'DISPONIBLE') ? 'success' : 'danger' }} m-0">{{$item->status}}</label></td>
                   <!--Realizamos if para validacion de adonde dirgir el show-->
                
                <td><a href="{{route('whiteRibbon.show',$item->id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
                </tr>
              @endforeach
            </tbody>
            </table>
            </div>
        </div>
        @endif

    <div class="col-lg-12 my-5">
        <h3><img src="{{ asset('images/bolsa-de-papel.svg') }}" class="iconoTitle"> Bolsas y Mermas de Bolsa</h3>
        <a class="btn btn-success float-right mb-3"  data-toggle="modal" data-target="#createProduct">Nueva Bolsa</a>
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
            @foreach ($bag as $item)
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
    @include('ribbons.modalTypeSelection')
</div>

@endsection

@section('scripts')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $('#formularioDestroy').submit(function(e){
            e.preventDefault();
            Swal.fire({
            title: '¿Está seguro?',
            text: "El rollo se eliminará definitivamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                var input = $("<input>").attr("type", "hidden")
                                        .attr("name", "providerForm").val("providerForm");
                $('#formularioDestroy').append(input);
                this.submit();
            }
            })
        });        
    </script>
@endsection
