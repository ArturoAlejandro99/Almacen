@extends('layouts.formulario')

@section('title', 'Merma de Bolsas')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Merma de Bolsas')

@section('form')
<form action="{{ route('whiteWasteRibbon.store') }}" method="POST">
    @csrf
    <div class="row">
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="nomenclatura" value="{{$nomenclatura}}" readonly>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Status</label>
                <input type="text" class="form-control" name="status" value="N/A" readonly>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Fecha Alta</label>
                <input type="date" class="form-control" name="fAlta">
            </div>
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Peso</label>
                <input type="number" step="0.0001" class="form-control" name="peso">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Largo</label>
                <input type="number" step="0.0001" class="form-control" name="largo">
            </div>  
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Costo</label>
                <input type="number" step="0.0001" class="form-control" name="costo">
            </div>
        
        <input type="hidden" class="form-control" name="whiteRibbonId" value="{{$whiteRibbonId}}">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones"></textarea>
            </div>  
        <div class="col-12 mt-3 text-center">
            <a class="btn btn-danger mx-3" href="{{ route('whiteRibbon.show', $whiteRibbonId) }}">Cancelar</a>
            <button type="submit" class="btn btn-success mx-3">Guardar</button>
        </div> 
    </div>
</form>
@endsection


