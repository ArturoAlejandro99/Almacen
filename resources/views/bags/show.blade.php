@extends('layouts.formulario')

@section('title', 'Proveedores')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Bolsa ' . $bag->nomenclatura)

@section('retornar')
<a href="{{ route('ribbonProduct.index') }}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection

@section('form')
<div class="row">

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="nomenclatura" value={{ $bag->nomenclatura }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Status</label>
            <input type="text" class="form-control" name="status" value={{ $bag->status }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Cantidad</label>
            <input type="text" class="form-control" name="cantidad" value={{ $bag->cantidad }} disabled>
        </div>
  
    
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Temperatura</label>
            <input type="text" class="form-control" name="temperatura" value={{ $bag->temperatura }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Fecha Inicio</label>
            <input type="date" class="form-control" name="fechaInicioTrabajo" value={{ $bag->fechaInicioTrabajo }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Hora Inicio</label>
            <input type="time" class="form-control" name="horaInicioTrabajo" value={{ $bag->horaInicioTrabajo }} disabled>
        </div>
 
 
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Medida (largo x ancho)</label>
            <input type="text" class="form-control" name="bag_measure_id" value="{{ $bag->bagMeasure->largo .' x '. $bag->bagMeasure->ancho . ($cinta->isEmpty()? ' ' :  ' C/P')  }}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Fecha Termino</label>
            <input type="date" class="form-control" name="fechaFinTrabajo" value={{ $bag->fechaFinTrabajo }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Hora Termino</label>
            <input type="time" class="form-control" name="horaFinTrabajo" value={{ $bag->horaFinTrabajo }} disabled>
        </div>
 
 
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Tipo de unidad</label>
            <input type="text" class="form-control" name="tipoUnidad" value={{ $bag->tipoUnidad }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso (Kg)</label>
            <input type="text" class="form-control" name="peso" value={{ $bag->peso }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Velocidad</label>
            <input type="text" class="form-control" name="velocidad" value={{ $bag->velocidad }} disabled>
        </div>
 
   
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Cliente Stock</label>
            <input type="text" class="form-control" name="clienteStock" value={{ $bag->clienteStock }} disabled>
        </div>
 

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" disabled>{{ $bag->observaciones }}</textarea>
        </div>  
    

    <div class="col-lg-12 mt-4 mb-2">
        <h3><img src="{{ asset('images/empleado.svg') }}" class="iconoTitle"> Empleados</h3>
        <div class="table-responsive">
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
                @foreach ($bag->employees as $employee)
                    <tr>
                        <th scope="row" class="align-middle">{{$employee->id}}</th>
                        <td class="align-middle">{{$employee->nombre}}</td>
                        <td class="align-middle">{{$minutosLaborados}}</td>
                        <td class="align-middle">$ {{$employee->sueldoHora}}</td>
                        <td class="align-middle">$ {{round(($employee->sueldoHora/60)*$minutosLaborados,4)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @if ($coil->status == 'TERMINADA')
    
    <div class="col-12 mt-2 mb-2 text-right">
        <h3 class="text-left"><img src="{{ asset('images/moneda-de-dinero.svg') }}" class="iconoTitle"> Costos</h3>
        <div class="d-flex">
            <div class="h5 col-10 ">Costo Rollo=</div>
            <div class="h5 col-2 ">$ {{round($bag->costoTotal, 4)}}</div>
        </div>
        <div class="d-flex">
            <div class="h5 col-10">Costo de mano de obra =</div>
            <div class="h5 col-2">$ {{($bag->employees->sum('sueldoHora')/60)*$minutosLaborados}}</div>
        </div>
        <hr>
        <div class="d-flex">
            <div class="h5 col-10">Total =</div>
            <div class="h5 col-2">$ {{round((($bag->employees->sum('sueldoHora')/60)*$minutosLaborados)+ $bag->costoTotal,4)}}</div>
        </div>
        <div class="d-flex">
            <div class="h5 col-10">Costo por unidad =</div>
            <div class="h5 col-2">$ {{round(((($bag->employees->sum('sueldoHora')/60)*$minutosLaborados)+ $bag->costoTotal)/$bag->cantidad,4)}}</div>
        </div>
    </div>
    @endif 

    <div class="col-12 mt-3 text-center">
        <form action="{{ route('bag.destroy', $bag) }}" method="POST" id="formularioDestroy">
            @csrf
            @method('delete')

            @can('bag.edit')
                <a class="btn btn-warning mx-3" href="{{ route('bag.edit', $bag) }}">Editar</a>
            @endcan
            @can('bag.destroy')
                <button class="btn btn-danger mx-3" type="submit">Eliminar</button>
            @endcan
        </form>
    </div>  
    
    <div class="col-lg-12 d-flex mt-5">
        <h3><img src="{{ asset('images/rollo-de-papel.svg') }}" class="iconoTitle">Rollo <a href="{{route('ribbon.show', $ribbon->id)}}"><small>Ver Rollo</small></a> </h3>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
        <label>Nomenclatura</label>
        <input type="text" class="form-control" name="coilNomenclatura" value="{{$ribbon->nomenclatura}}" disabled>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
        <label>Fecha Adquisición</label>
        <input type="datetime" class="form-control" name="coilfArribo" value="{{$ribbon->fechaInicioTrabajo}}" disabled>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
        <label>Status</label>
        <input type="text" class="form-control" name="coilStatus" value="{{$ribbon->status}}" disabled>
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
 
    @if (!$cinta->isEmpty() )
    <div class="col-lg-12 my-5">
        <h3><img src="{{ asset('images/cinta.svg') }}" class="iconoTitle"> Cinta blanca</h3>
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
                @foreach ($cinta as $item)
                <tr>
                    <th scope="row" class="align-middle">{{$item->id}}</th>
                    <td class="align-middle">{{$item->nomenclatura}}</td>
                    <td class="align-middle">{{$item->fArribo}}</td>
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
</div>
@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $('#formularioDestroy').submit(function(e){
            e.preventDefault();
            Swal.fire({
            title: '¿Está seguro?',
            text: "La bolsa se eliminará definitivamente.",
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
