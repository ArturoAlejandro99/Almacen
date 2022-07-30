@extends('layouts.formulario')

@section('title', 'Editar Hueso')

@section('imgUrl',  asset('images/rollo-de-papel.svg'))

@section('namePage', 'Editar Hueso ' . $ribbonReel->nomenclatura)

@section('form')
<form action="{{route('ribbonReel.update', $ribbonReel)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
       
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="nomenclatura" value="{{$ribbonReel->nomenclatura}}" readonly>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Peso</label>
                <input type="number" step="0.0001" class="form-control" name="peso" value="{{$ribbonReel->peso}}" >
                @error('peso')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Fecha Alta</label>
                <input type="date" class="form-control" name="fechaAlta" value="{{$ribbonReel->fechaAlta}}">
                @error('fechaAlta')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
     
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Status</label>
                <input type="text" class="form-control" name="status" value="N/A" readonly>
                @error('status')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div> 
       
        
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones">{{$ribbonReel->observaciones}}</textarea>
            </div>
    

    <div class="col-12 mt-3 text-center">
        <a class="btn btn-danger mx-3" href="{{route('ribbonReel.show', $ribbonReel->id)}}">Cancelar</a>
        <button type="submit" class="btn btn-success mx-3">Guardar</button>
    </div>
</div>
</form>
@endsection