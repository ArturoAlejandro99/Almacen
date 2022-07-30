@extends('layouts.formulario')

@section('title', 'Merma de Bolsas')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Editar Merma de Bolsas')

@section('form')
<form action="{{ route('wasteBag.update', $wasteBag) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="fechaInicioTrabajo" value={{ $wasteBag->fechaInicioTrabajo }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Fecha Fin</label>
                <input type="date" class="form-control" name="fechaFinTrabajo" value={{ $wasteBag->fechaFinTrabajo }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Peso</label>
                <input type="text" class="form-control" name="peso" value={{ $wasteBag->peso }}>
            </div>
   
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Largo</label>
                <input type="number" step="0.0001" class="form-control" name="largo" value={{ $wasteBag->largo }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Temperatura</label>
                <input type="number" step="0.0001" class="form-control" name="temperatura" value={{ $wasteBag->temperatura }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Velocidad</label>
                <input type="number" step="0.0001" class="form-control" name="velocidad" value={{ $wasteBag->velocidad }}>
            </div>
    
       
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="DISPONIBLE" {{ ($wasteBag->status === 'DISPONIBLE') ? 'Selected' : '' }}>
                        DISPONIBLE
                    </option>
                    <option value="TERMINADO" {{ ($wasteBag->status === 'TERMINADO') ? 'Selected' : '' }}>
                        TERMINADO
                    </option>
                </select>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Tipo Unidad</label>
                <input type="text" class="form-control" name="tipoUnidad" value={{ $wasteBag->tipoUnidad }}>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Cantidad</label>
                <input type="number" step="0.0001" class="form-control" name="cantidad" value={{ $wasteBag->cantidad }}>
            </div>
        </div>
        <div class="col-lg-12 d-flex mt-3">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="nomenclatura" value={{ $wasteBag->nomenclatura }}>
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
                <table class="table table-striped my-2" id="tablaEmpleadosLaboraron">
                    {{-- Modal crear empleado --}}
                    @include('wasteBags.modalCreateEmployee')
                    {{-- Modal crear empleado --}}
                    
                    <thead class="bg-info">
                    <tr>                        
                        <th scope="col">Nombre</th>
                        <th scope="col">Satus</th>
                        <th scope="col">Quitar o Cambiar</th>
                    </tr>
                    </thead>
                    <tbody id="tabla">
                        @foreach ($wasteBag->employees as $employee)
                            <tr class="row{{$employee->id}}">
                                @include('wasteBags.modalEditEmployee')
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
            <div class="col-lg-2 px-2"></div>
        </div>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones">{{ $wasteBag->observaciones }}</textarea>
            </div>  
        <div class="col-12 mt-3 text-center">
            <a class="btn btn-danger mx-3" href="{{route('wasteBag.show', $wasteBag->id)}}">Cancelar</a>
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


