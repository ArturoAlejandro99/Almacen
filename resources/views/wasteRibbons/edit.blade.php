@extends('layouts.formulario')

@section('title', 'Rollo')

@section('imgUrl',  asset('images/rollo-de-papel.svg'))

@section('namePage', 'Merma Rollo')

@section('form')
<form action="{{route('wasteRibbon.update', $wasteRibbon)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="nomenclatura" value={{$wasteRibbon->nomenclatura}} readonly>
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
                <input type="text" class="form-control" name="status" value={{$wasteRibbon->status}} readonly>
                @error('largo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Peso (KG)</label>
                <input type="number" class="form-control" name="peso" value={{$wasteRibbon->peso}}>
                @error('peso')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
    
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Largo (metros)</label>
                <input type="number" class="form-control" name="largo" value={{$wasteRibbon->largo}}>
                @error('largo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Incio Trabajo</label>
                <input type="date" class="form-control" name="fechaInicioTrabajo" value={{$wasteRibbon->fechaInicioTrabajo}}>
                @error('fechaInicioTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Hora Inicio Trabajo</label>
                <input type="time" class="form-control" name="horaInicioTrabajo" value={{$wasteRibbon->horaInicioTrabajo}}>
                @error('horaInicioTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
    
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Temperatura</label>
                <input type="text" class="form-control" name="temperatura" value={{$wasteRibbon->temperatura}}>
                @error('temperatura')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Fin Trabajo</label>
                <input type="date" class="form-control" name="fechaFinTrabajo" value={{$wasteRibbon->fechaFinTrabajo}}>
                @error('fechaFinTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Hora Fin Trabajo</label>
                <input type="time" class="form-control" name="horaFinTrabajo" value={{$wasteRibbon->horaFinTrabajo}}>
                @error('horaFinTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
            @enderror
            </div>
            
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Velocidad</label>
                <input type="number" class="form-control" name="velocidad" value={{$wasteRibbon->velocidad}}>
                @error('velocidad')
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
                    @include('wasteRibbons.modalCreateEmployee')
                    {{-- Modal crear empleado --}}
                    
                    <thead class="bg-info">
                    <tr>                        
                        <th scope="col">Nombre</th>
                        <th scope="col">Satus</th>
                        <th scope="col">Quitar o Cambiar</th>
                    </tr>
                    </thead>
                    <tbody id="tabla">
                        @foreach ($wasteRibbon->employees as $employee)
                            <tr class="row{{$employee->id}}">
                                @include('wasteRibbons.modalEditEmployee')
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
    
        <div class="col-lg-12 d-flex mt-4">
            <div class="col-lg-12 px-2">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones" placeholder="Máximo 255 caracteres">{{$wasteRibbon->observaciones}}</textarea>
            </div>
        </div>

    <div class="col-12 mt-3 text-center">
        <a class="btn btn-danger mx-3" href="{{route('wasteRibbon.show', $wasteRibbon->id)}}">Cancelar</a>
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