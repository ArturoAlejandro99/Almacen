@extends('layouts.formulario')

@section('title', 'Rollo')

@section('imgUrl',  asset('images/rollo-de-papel.svg'))

@section('namePage', 'Rollo')

@section('form')
<form action="{{route('ribbon.store')}}" method="POST">
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
                <input type="number" step="0.0001" class="form-control" name="peso" value="{{old('peso')}}">
                @error('peso')
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
                <label><span class="required">*</span>Fecha Inicio</label>
                <input type="date" class="form-control" name="fechaInicioTrabajo" value="{{old('fechaInicioTrabajo')}}">
                @error('fechaInicioTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Hora Inicio</label>
                <input type="time" class="form-control" name="horaInicioTrabajo" value="{{old('horaInicioTrabajo')}}">
                @error('horaInicioTrabajo')
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
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Fecha Termino</label>
                <input type="date" class="form-control" name="fechaFinTrabajo" value="{{old('fechaFinTrabajo')}}">
                @error('fechaFinTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label><span class="required">*</span>Hora Termino</label>
                <input type="time" class="form-control" name="horaFinTrabajo" value="{{old('horaFinTrabajo')}}">
                @error('horaFinTrabajo')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                @enderror
            </div>
        
    
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Temperatura (C°)</label>
                <input type="number" step = "0.0001" class="form-control" name="temperatura" value="{{old('temperatura')}}">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Velocidad</label>
                <input type="number" step = "0.0001" class="form-control" name="velocidad" value="{{old('velocidad')}}">
            </div>
            <div class="form-cloned col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
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
        
    
        <div class="col-lg-8 d-flex mt-3">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2" id="cajaCompleta">
                @if(old('white_ribbon_ids'))
                    @php($i=0)
                    @php($j=0)
                    @foreach(old('white_ribbon_ids') as $white_ribbon_id)
                        <div id="cintaBlanca">
                            <label><span class="required">*</span>Cintilla Blanca</label>
                            @if($i == 0)
                                <button type="button" onclick="clonarCinta()" class="btn btn-success btn-sm">+</button>
                                <button type="button" onclick="removerCinta()" class="btn btn-secondary btn-sm">-</button>
                                @php($i++)
                            @endif
                            <select class="form-control" name="white_ribbon_ids[]" id="{{++$j}}" onchange="cambioCintaBlanca(this)">
                                <option selected value="">N/A</option>
                                @foreach($cintaBlancas as $cintaBlanca)
                                    <option value={{$cintaBlanca->id}} {{ ($white_ribbon_id ==  $cintaBlanca->id) ? 'selected' : ''}}>
                                        {{$cintaBlanca->nomenclatura}}
                                    </option>
                                @endforeach
                            </select>
                        </div> 
                    @endforeach
                @else
                    <div id="cintaBlanca">
                        <label><span class="required">*</span>Cintilla Blanca</label>
                        <button type="button" id="bClon" onclick="clonarCinta()" class="btn btn-success btn-sm">+</button>
                        <button type="button" id="bRemove" onclick="removerCinta()" class="btn btn-secondary btn-sm">-</button>
                        <select class="form-control" name="white_ribbon_ids[]" id="1" onchange="cambioCintaBlanca(this)">
                            <option selected value="">N/A</option>
                            @foreach($cintaBlancas as $cintaBlanca)
                                <option value={{$cintaBlanca->id}}>
                                    {{$cintaBlanca->nomenclatura}}
                                </option>
                            @endforeach
                        </select>
                    </div>  
                @endif
                @error('white_ribbon_ids.*')
                <div class="error-whiteRibbon">
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                </div>
                @enderror
            </div>
            <div class="col-lg-6 px-2" id="contentLargos">
                @if(old('largos'))
                    @php($i=0)
                    @foreach(old('largos') as $largo)
                        <div id="inputLargos">
                            <label><span class="required">*</span>Largo (metros)</label>
                            <input type="number" step="0.0001" class="form-control" id="largo{{++$i}}" name="largos[]" value="{{ $largo }}">
                        </div>
                    @endforeach
                @else
                    <div id="inputLargos">
                        <label><span class="required">*</span>Largo (metros)</label>
                        <input type="number" step="0.0001" class="form-control" id="largo1" name="largos[]" readonly>
                    </div>
                @endif
                @error('largos.*')
                    <div class="error-largos">
                        <br>
                        <div class="alert alert-danger">
                            <small>{{$message}}</small>
                        </div>
                        <br>
                    </div>
                @enderror
            </div>
        </div>
            
    <!--Id de bobina relacionado-->
    <input type="hidden"  name="coilId" value="{{$coilId}}">
        
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-2">
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
        <div class="col-12 mt-4 mb-4 text-center">
            <a class="btn btn-danger mx-3" href="{{route('coil.show', $coilId)}}">Cancelar</a>
            <button type="submit" class="btn btn-success mx-3" onclick="guardar()">Guardar</button>
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

    function clonarCinta()
    {
        var $form = $('#cajaCompleta #cintaBlanca').last().clone();
        
        var id = $form.find('select').attr('id');  
        id = parseInt(id, 10);
        
        $form.html('<label><span class="required">*</span>Cintilla Blanca</label>' +
            '<select class="form-control" name="white_ribbon_ids[]" id="'+(++id)+'" onchange="cambioCintaBlanca(this)">' +
                '<option selected value="">N/A</option>' +
                '@foreach($cintaBlancas as $cintaBlanca)'+
                    '<option value={{$cintaBlanca->id}}>' +
                        '{{$cintaBlanca->nomenclatura}}' +
                    '</option>' +
                '@endforeach' +
            '</select>');   
        
        $('.error-whiteRibbon').html('');
        $('.error-largos').html('');
        
        $form.find(':input').each(function () {
            if ($(this).is('select')) {
                this.selectedIndex = 0;
            } else {
                this.value = '';
            }
        });

        $form.appendTo('#cajaCompleta');

        $form = $('#contentLargos #inputLargos').last().clone();
        $form.find('input').attr('id','largo'+id)        
        $form.find('input').val('');
        $form.find('input').prop('readonly', true);
        $form.appendTo('#contentLargos');
    }

    function removerCinta()
    {
        var $form = $('#cajaCompleta #cintaBlanca');
        var $formLargo = $('#contentLargos #inputLargos');

        if($form.length != 1) 
        {
            $form.last().remove();
            $formLargo.last().remove();
        }        
    }
    
    function cambioCintaBlanca(item)
    {
        var id = $(item).attr('id');
        id = parseInt(id, 10);

        var largo = $('#largo'+id);

        if($(item).val() != '')
        {
            largo.prop('readonly', false);
            largo.attr('name', 'largos[]');
            $(item).attr('name', 'white_ribbon_ids[]');
        }
        else
        {
            largo.prop('readonly', true);
            largo.removeAttr('name');
            $(item).removeAttr('name');
        }
    }
    function guardar()
    {
        
        $('#cajaCompleta').find('select').each(
            function()
            {
                if($(this).val() == '')
                {
                    var child = this.parentNode;
                    var parent = child.parentNode;
                    parent.removeChild(child); 
                    
                    var id = $(this).attr('id');
                    child = document.getElementById('largo'+id).parentNode;
                    parent = child.parentNode;
                    parent.removeChild(child); 
                }
            }
        )
    }
</script>
@endsection