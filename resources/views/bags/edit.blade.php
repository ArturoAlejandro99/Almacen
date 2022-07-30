@extends('layouts.formulario')

@section('title', 'Editar Bolsa')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Editar Bolsa ' . $bag->nomenclatura)

@section('form')
<form action="{{ route('bag.update', $bag) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
     
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="nomenclatura" value={{ $bag->nomenclatura }} readonly>
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
                <input type="text" class="form-control" name="status" value={{$bag->status}} readonly>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Cantidad</label>
                <input type="number" step="0.0001" class="form-control" name="cantidad" value={{ $bag->cantidad }}>
                @error('cantidad')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
       
     
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Temperatura</label>
                <input type="number" step="0.0001" class="form-control" name="temperatura" value={{ $bag->temperatura }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="fechaInicioTrabajo" value={{ $bag->fechaInicioTrabajo }}>
                @error('fechaInicioTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Hora Inicio</label>
                <input type="time" class="form-control" name="horaInicioTrabajo" value={{ $bag->horaInicioTrabajo }}>
                @error('horaInicioTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
    
      
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Medida (largo x ancho)</label>
                <select class="form-control" name="bag_measure_id">
                    @foreach($combinedBagMeasures as $key => $bagMeasure)                    
                        <option {{ ($key == $bag->bag_measure_id) ? 'selected' : ''}} value="{{ $key }}">
                            {{ $bagMeasure }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Termino</label>
                <input type="date" class="form-control" name="fechaFinTrabajo" value={{ $bag->fechaFinTrabajo }}>
                @error('fechaFinTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Hora Termino</label>
                <input type="time" class="form-control" name="horaFinTrabajo" value={{ $bag->horaFinTrabajo }}>
                @error('horaFinTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
   
   
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Tipo de unidad</label>
                <select class="form-control" name="tipoUnidad">
                    <option value="MILLAR" {{ ($bag->tipoUnidad === 'MILLAR') ? 'Selected' : '' }}>
                        MILLAR
                    </option>
                    <option value="CIENTO" {{ ($bag->tipoUnidad === 'CIENTO') ? 'Selected' : '' }}>
                        CIENTO
                    </option>
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
                <label>Peso (Kg)</label>
                <input type="number" step="0.0001" class="form-control" name="peso" value={{ $bag->peso }}>
                @error('peso')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Velocidad</label>
                <input type="number" step="0.0001" class="form-control" name="velocidad" value={{ $bag->velocidad }}>
            </div>
    
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Cliente Stock</label>
                <select class="form-control" name="clienteStock">
                    <option value="CLIENTE" {{ ($bag->clienteStock === 'CLIENTE') ? 'Selected' : '' }}>
                        CLIENTE
                    </option>
                    <option value="STOCK" {{ ($bag->clienteStock === 'STOCK') ? 'Selected' : '' }}>
                        STOCK
                    </option>
                </select>
                @error('clienteStock')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
        
        <div class="col-lg-12 d-flex mt-5 mb-2">
            <div class="col-lg-2 px-2"></div>
            <div class="col-lg-8 px-2">
                <div class="col-lg-12 d-flex">
                    <div class="col-lg-10 px-0">
                        <h3><img src="{{ asset('images/empleado.svg') }}" class="iconoTitle"> Empleados que laboraron</h3>
                    </div>
                    <div class="col-lg-2 px-0 pt-3">
                        <button type="button" class="btn btn-success  float-right" data-toggle="modal" data-target="#create" onclick="limpiarInputsModalCreate()">
                            Agregar
                        </button>    
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table table-striped my-2" id="tablaEmpleadosLaboraron">
                    {{-- Modal crear empleado --}}
                    @include('bags.modalCreateEmployee')
                    {{-- Modal crear empleado --}}
                    
                    <thead class="bg-info">
                    <tr>                        
                        <th scope="col">Nombre</th>
                        <th scope="col">Satus</th>
                        <th scope="col">Quitar o Cambiar</th>
                    </tr>
                    </thead>
                    <tbody id="tabla">
                        @foreach ($bag->employees as $employee)
                            <tr class="row{{$employee->id}}">
                                @include('bags.modalEditEmployee')
                                <input type="hidden" name="empleados[]" class="form-control" value="{{$employee->id}}">
                                <td class="align-middle" id="nombre">
                                    {{$employee->nombre}}
                                </td>
                                <td class="align-middle" id="status">{{$employee->status}}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-danger btn-sm" id="btnDelete" onclick="eliminarFila(this, id='{{$employee->id}}')">
                                        <img src="{{ asset('images/cruz.svg') }}" class="iconosPequeños">
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" id="btnEdit" data-toggle="modal" data-target="#edit{{$employee->id}}">
                                        <img src="{{ asset('images/cambiar-empleado.svg') }}" class="iconosPequeños">
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="col-lg-2 px-2"></div>
        </div>

        <div class="col-lg-12 d-flex mt-3">
            <div class="col-lg-12 px-2">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones">{{ $bag->observaciones }}</textarea>
                @error('observaciones')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>  
        </div>
        <div class="col-12 mt-4 mb-4 text-center">
            <a class="btn btn-danger mx-3" href="{{ route('bag.show', $bag) }}">Cancelar</a>
            <button type="submit" class="btn btn-success mx-3">Guardar</button>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script type="text/javascript">
    function crearFila()
    {
        var idEmpleado = $("#modalEmpleado").val();
        var idEstaRepetido = false;

        if(idEmpleado != null)
        {
            $('#tabla').find('tr').find('input').each(function(){
                if(idEmpleado == $(this).val())
                {
                    idEstaRepetido = true;
                    return;
                }      
            })
            if(idEstaRepetido)
            {
                mostrarErrorRepetido();
                return;
            }
            else
            {
                var nombreEmpleado = $("#modalEmpleado option:selected").text();
                var statusEmpleado = $("#modalStatusEmpleado").val();
                
                var fila =
                '<tr>'+
                    '<td class="align-middle">'+
                        '<input type="hidden" name="empleados[]" class="form-control" value="'+idEmpleado+'">'+
                        nombreEmpleado+
                    '</td>'+
                    '<td class="align-middle">'+statusEmpleado+'</td>'+
                    '<td class="align-middle">'+
                        '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">'+
                            '<img src="{{ asset('images/cruz.svg') }}" class="iconosPequeños">'+
                        '</button>'+
                        '<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit'+idEmpleado+'" disabled>'+
                            '<img src="{{ asset('images/cambiar-empleado.svg') }}" class="iconosPequeños">'+
                        '</button>'+
                    '</td>'+
                '</tr>'        
                
                $('#tablaEmpleadosLaboraron').append(fila);
                $('#create').modal('toggle');
            }
            
        }
        else
        {
            $(".error-empleado").html(
                '<div class="alert alert-danger mt-2">' +
                    '<small>Debe seleccionar un empleado</small>' +
                '</div>');
        }
    }

    function mostrarErrorRepetido()
    {
        $(".error-empleado").html(
                '<div class="alert alert-danger mt-2">' +
                    '<small>El usuario ya está agregado</small>' +
                '</div>');
    }

    function limpiarInputsModalCreate()
    {
        $('#modalStatusEmpleado').val('');
        $('#modalEmpleado').val('');

        $(".error-empleado").html('');
    }
    function cambio()
    {
        var idEmpleado = $("#modalEmpleado").val();
        //Obtengo el array de empleados que pase desde el controlador y lo convierto en un objeto json
        //para poder utilizarlo en javascript. Se utilizó la clausula json de laravel
        var empleados = @json($employees);
        //Obtengo un array(empleado) con los elementos que coincidan del array(empleados) 
        //filtrandolos por el id
        var empleado = empleados.filter(function (empleado) { return empleado.id == idEmpleado; });
        
        var statusEmpleado = document.getElementById("modalStatusEmpleado");

        statusEmpleado.value = empleado[0].status;
    }

    function eliminarFila(t, id)
    {
        var td = t.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr); // Borramos la fila 


        var child = document.getElementById('edit'+id);
        var parent = child.parentNode;
        parent.removeChild(child); // Borramos el modal correspondiente a esa fila
    }

    function cambioEdit(id)
    {
        var idEmpleado = $(".modalEmpleado" + id).val();

        //Obtengo el array de empleados que pase desde el controlador y lo convierto en un objeto json
        //para poder utilizarlo en javascript. Se utilizó la clausula json de laravel
        var empleados = @json($employees);
        
        //Obtengo un array(empleado) con los elementos que coincidan del array(empleados) 
        //filtrandolos por el id
        var empleado = empleados.filter(function (empleado) { return empleado.id == idEmpleado; });
        
        var statusEmpleado = document.getElementById("modalStatusEmpleado" + id);

        statusEmpleado.value = empleado[0].status;
    }

    function editRow(id)
    {
        var idEstaRepetido = false;  
        var nuevoId=$(".modalEmpleado"+id).val(); //obtenemos en nuevo ID que selecciono el usuario en el <select> de empleado
        
        $(".error-empleado"+id).html('');

        if(nuevoId != id)
        {
            $('#tabla').find('tr').find('input').each(function(){
                if(nuevoId == $(this).val())
                {
                    idEstaRepetido = true;
                    return;
                }      
            })

            if(idEstaRepetido)
            {
                $(".error-empleado"+id).html(
                    '<div class="alert alert-danger mt-2">' +
                        '<small>El usuario ya está agregado</small>' +
                    '</div>');
                return;
            }
            else
            {
                var nuevoNombre = $('.modalEmpleado'+ id +' option:selected').text();
                var nuevoStatus = $('#modalStatusEmpleado'+id).val();
                
                $("#edit"+id).attr('id', 'edit' + nuevoId);
                $(".modalEmpleado"+id).attr('class', 'form-control modalEmpleado' + nuevoId);
                $(".modalEmpleado"+nuevoId).attr('onchange', "cambioEdit(id='"+ nuevoId +"')");
                $("#modalStatusEmpleado"+id).attr('id', "modalStatusEmpleado"+ nuevoId);
                $(".button"+id).attr('class', "btn btn-success button"+ nuevoId);
                $(".button"+nuevoId).attr('onclick', "editRow(id='"+ nuevoId +"')");
                $(".error-empleado"+id).attr('class', "error-empleado"+nuevoId);

                //a=$('.row'+id).find('button#btnDelete').attr('onclick');//

                $('.row'+id).find('input').val(nuevoId);
                $('.row'+id).attr('class', 'row'+nuevoId);
                $('.row'+nuevoId).find('td#nombre').text(nuevoNombre);
                $('.row'+nuevoId).find('td#status').text(nuevoStatus);
                $('.row'+nuevoId).find('button#btnEdit').attr('data-target', "#edit"+nuevoId);
                $('.row'+nuevoId).find('button#btnDelete').attr('onclick', "eliminarFila(this, id='"+nuevoId+"')");

                $("#edit"+nuevoId).modal("toggle");
                
                //b=$('.row'+nuevoId).find('button#btnDelete').attr('onclick');//
                //console.log(a+'\n');//
                //console.log(b);//
            }            
        }
        else
        {
            $("#edit"+nuevoId).modal("toggle");
        }
    }

</script>
@endsection
