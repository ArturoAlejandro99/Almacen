@extends('layouts.formulario')

@section('title', 'Merma de Bolsas')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Merma de Bolsas')

@section('form')
<form action="{{ route('wasteBag.store') }}" method="POST">
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
                <label><span class="required">*</span>Peso</label>
                <input type="number" step="0.0001" class="form-control" name="peso" value={{ old('peso') }}>
                @error('peso')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Largo</label>
                <input type="number" step="0.0001" class="form-control" name="largo" value={{ old('largo') }}>
                @error('largo')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div> 
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Fecha Inicio</label>
                <input type="date" class="form-control" name="fechaInicioTrabajo" value={{ old('fechaInicioTrabajo') }}>
                @error('fechaInicioTrabajo')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Fecha Inicio</label>
                <input type="time" class="form-control" name="horaInicioTrabajo" value={{ old('horaInicioTrabajo') }}>
                @error('horaInicioTrabajo')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>
    
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Tipo Unidad</label>
                <select class="form-control" name="tipoUnidad">
                    <option selected class="text-muted" disabled value="">--seleccione una opción--</option>
                    <option {{ (old('tipoUnidad') == 'MILLAR') ? 'selected' : '' }} value="MILLAR">MILLAR</option>
                    <option {{ (old('tipoUnidad') == 'CIENTO') ? 'selected' : '' }} value="CIENTO">CIENTO</option>
                </select>
                @error('tipoUnidad')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Fecha Fin</label>
                <input type="date" class="form-control" name="fechaFinTrabajo" value={{ old('fechaFinTrabajo') }}>
                @error('fechaFinTrabajo')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Hora Fin</label>
                <input type="time" class="form-control" name="horaFinTrabajo" value={{ old('horaFinTrabajo') }}>
                @error('horaFinTrabajo')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Temperatura</label>
                <input type="number" step="0.0001" class="form-control" name="temperatura" value={{ old('temperatura') }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Velocidad</label>
                <input type="number" step="0.0001" class="form-control" name="velocidad" value={{ old('velocidad') }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Cantidad</label>
                <input type="number" step="0.0001" class="form-control" name="cantidad" value={{ old('cantidad') }}>
                @error('cantidad')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>

        <div class="col-lg-12 d-flex mt-3">
            <div class="form-cloned col-lg-4 px-2">
                <label><span class="required">*</span>Empleado(s)</label>
                <button type="button" onclick="clonar()" class="btn btn-success btn-sm">+</button>
                <button type="button" onclick="remover()" class="btn btn-secondary btn-sm">-</button>
                @if(old('empleados'))
                    @foreach(old('empleados') as $empleado)
                        <select class="form-control" name="empleados[]">
                            <option selected class="text-muted" value="">--seleccione una opción--</option>
                            @foreach($employees as $employee)
                                <option value={{ $employee->id }} {{ ($empleado ==  $employee->id) ? 'selected' : ''}}>
                                    {{ $employee->nombre }}
                                </option>
                            @endforeach
                        </select>
                    @endforeach
                @else
                    <select class="form-control" name="empleados[]">
                        <option selected class="text-muted" value="">--seleccione una opción--</option>
                        @foreach($employees as $employee)
                            <option value={{ $employee->id }}>
                                {{ $employee->nombre }}
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('empleados.*')
                    <div class="error-empleado">
                        <br>
                        <div class="alert alert-danger">
                            <small>{{$message}}</small>
                        </div>
                        <br>
                    </div>
                @enderror            
            </div>
        </div>

        <input type="hidden" class="form-control" name="ribbonId" value="{{$ribbonId}}">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones">{{ old('observaciones') }}</textarea>
            </div>  

        <div class="col-12 mt-4 mb-4 text-center">
            <a class="btn btn-danger mx-3" href="{{ route('ribbon.show', $ribbonId) }}">Cancelar</a>
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

        $('.error-empleado').html('');

        $form.appendTo('.form-cloned');
    }

    function remover()
    {
        var $form = $('.form-cloned .form-control');

        if($form.length != 1) $form.last().remove();
    }
</script>
@endsection