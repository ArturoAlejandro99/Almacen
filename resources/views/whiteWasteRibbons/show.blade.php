@extends('layouts.formulario')

@section('title', 'Merma de Bolsas')

@section('imgUrl',  asset('images/cinta.svg'))

@section('namePage', 'Merma de Bolsas')

@section('retornar')
<a href="{{ route('whiteRibbonProduct.index') }}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection

@section('form')
<div class="row">
    
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Nomenclatura</label>
            <input type="text" class="form-control" name="fInicioTrabajo" value={{ $whiteWasteRibbon->nomenclatura }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Status</label>
            <input type="text" class="form-control" name="status" value={{ $whiteWasteRibbon->status }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Fecha Alta</label>
            <input type="text" class="form-control" name="fAlta" value={{ $whiteWasteRibbon->fAlta }} disabled>
        </div>
    
    
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Peso</label>
            <input type="text" class="form-control" name="peso" value={{ $whiteWasteRibbon->peso }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Largo</label>
            <input type="text" class="form-control" name="largo" value={{ $whiteWasteRibbon->largo }} disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Costo</label>
            <input type="number" step="0.0001" class="form-control" name="costo" value={{ $whiteWasteRibbon->costo }} disabled>
        </div>
        
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" disabled>{{ $whiteWasteRibbon->observaciones }}</textarea>
        </div>  
        
        <div class="col-12 mt-3 text-center">
            <form action="{{ route('whiteWasteRibbon.destroy', $whiteWasteRibbon) }}" method="POST" id="formularioDestroy">
                @csrf
                @method('delete')
                @can('whiteWasteRibbon.edit')
                    <a class="btn btn-warning mx-3" href="{{route('whiteWasteRibbon.edit', $whiteWasteRibbon)}}">Editar</a>
                @endcan
                @can('whiteWasteRibbon.destroy')
                   <button class="btn btn-danger mx-3" type="submit">Eliminar</button>
                @endcan
            </form>
        </div>  
        
     

    <div class="col-lg-12 d-flex mt-5">
        <h3><img src="{{ asset('images/cinta.svg') }}" class="iconoTitle"> Rollo <a href="{{route('whiteRibbon.show', $whiteRibbon->id)}}"><small>Ver Rollo</small></a> </h3>
        </div>
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="coilNomenclatura" value="{{$whiteRibbon->nomenclatura}}" disabled>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Adquisición</label>
                <input type="datetime" class="form-control" name="coilfArribo" value="{{$whiteRibbon->fechaInicioTrabajo}}" disabled>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Status</label>
                <input type="text" class="form-control" name="coilStatus" value="{{$whiteRibbon->status}}" disabled>
            </div>

    <div class="col-lg-12 d-flex mt-5">
        <h3><img src="{{ asset('images/base-de-datos.svg') }}" class="iconoTitle"> Bobina <a href="{{route('whiteCoil.show', $whiteCoil->id)}}"><small>Ver Bobina</small></a> </h3>
        </div>
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="coilNomenclatura" value="{{$whiteCoil->nomenclatura}}" disabled>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Adquisición</label>
                <input type="datetime" class="form-control" name="coilfArribo" value="{{$whiteCoil->fArribo}}" disabled>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Status</label>
                <input type="text" class="form-control" name="coilStatus" value="{{$whiteCoil->status}}" disabled>
            </div>
</div>
<br>
<br>
@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $('#formularioDestroy').submit(function(e){
            e.preventDefault();
            Swal.fire({
            title: '¿Está seguro?',
            text: "La merma se eliminará definitivamente.",
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
