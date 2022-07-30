@extends('layouts.formulario')

@section('title', 'Rollo')

@section('imgUrl',  asset('images/cinta.svg'))

@section('namePage', 'Rollo')

@section('form')
<form action="{{route('whiteRibbon.store')}}" method="POST">
    @csrf
    <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="nomenclatura" value="{{$nomenclatura}}" readonly>
                @error('nomenclatura')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Status</label>
                <input type="text" class="form-control" name="status" value="DISPONIBLE" readonly>
                @error('status')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label><span class="required">*</span>Peso (KG)</label>
                <input type="text" class="form-control" name="peso" value="{{old('peso')}}">
                @error('peso')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
    
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Fecha Arribo</label>
                <input type="date" class="form-control" name="fArribo" value="{{old('fArribo')}}">
                @error('fArribo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Largo (metros)</label>
                <input type="number" step="0.0001" class="form-control" name="largo" value="{{old('largo')}}">
                @error('largo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Peso Utilizado (KG)</label>
                <input type="number" step="0.0001" class="form-control" name="pesoUtilizado" value="0" readonly>
                @error('pesoUtilizado')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                 @enderror
            </div>
    
        <div class="col-lg-12 d-flex mt-3">
            
            <!--Id de bobina relacionado-->
                <input type="hidden" class="form-control" name="whiteCoilId" value="{{$whiteCoilId}}">
        </div>
    
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones" placeholder="Máximo 255 caracteres">{{old('observaciones')}}</textarea>
                @error('Observaciones')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                 @enderror
            </div>
        @if($errors->any())
        <div class="col-12 mt-3 text-center">
            <br>
                <div class="alert alert-danger">
                    {{$errors->first()}}
                </div>
                <br>
        </div>
        @endif
        <div class="col-12 mt-3 text-center">
            <a class="btn btn-danger mx-3" href="{{route('whiteCoil.show', $whiteCoilId)}}">Cancelar</a>
            <button type="submit" class="btn btn-success mx-3">Guardar</button>
        </div>
</div>
</form>
@endsection

@section('scripts')
<script type="text/javascript">
    function clonar()
    {
        var $form = $('.form-cloned .form-control').last().clone();

        $form.appendTo('.form-cloned');
    }

    function remover()
    {
        var $form = $('.form-cloned .form-control');

        if($form.length != 1) $form.last().remove();
    }
</script>
@endsection