@extends('layouts.formulario')

@section('title', 'Rollo')

@section('imgUrl',  asset('images/rollo-de-papel.svg'))

@section('namePage', 'Rollo')

@section('form')
<form action="{{route('ribbon.update', $ribbon)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Nomenclatura</label>
                <input type="text" class="form-control" name="nomenclatura" value="{{$ribbon->nomenclatura}}">
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
                <input type="text" class="form-control" name="status" value="{{$ribbon->status}}" readonly>
                @error('status')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
                <label>Peso (KG)</label>
                <input type="number" step="0.0001" class="form-control" name="peso" value="{{$ribbon->peso}}">
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
                <input type="number" step="0.0001" class="form-control" name="largo" value="{{$ribbon->largo}}">
                @error('largo')
                    <br>
                    <div class="alert alert-danger">
                        <small>{{$message}}</small>
                    </div>
                    <br>
                    @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" name="fechaInicioTrabajo" value="{{$ribbon->fechaInicioTrabajo}}">
                @error('fechaIncioTrabajo')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Hora Inicio</label>
                <input type="time" class="form-control" name="horaInicioTrabajo" value="{{$ribbon->horaInicioTrabajo}}">
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
                <input type="number" step="0.0001" class="form-control" name="pesoUtilizado" value="{{$ribbon->pesoUtilizado}}" readonly>
                @error('pesoUtilizado')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Fecha Termino</label>
                <input type="date" class="form-control" name="fechaFinTrabajo" value="{{$ribbon->fechaFinTrabajo}}">
                @error('fechaFinTermino')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                @enderror
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Hora Termino</label>
                <input type="time" class="form-control" name="horaFinTrabajo" value="{{$ribbon->horaFinTrabajo}}">
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
                <input type="number" step="0.0001" class="form-control" name="temperatura" value="{{$ribbon->temperatura}}">
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
                <label>Velocidad</label>
                <input type="number" step="0.0001" class="form-control" name="velocidad" value="{{$ribbon->velocidad}}">
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
                    @include('ribbons/modalCreateEmployee')
                    {{-- Modal crear empleado --}}
                    
                    <thead class="bg-info">
                    <tr>                        
                        <th scope="col">Nombre</th>
                        <th scope="col">Satus</th>
                        <th scope="col">Quitar o Cambiar</th>
                    </tr>
                    </thead>
                    <tbody id="tabla">
                        @foreach ($ribbon->employees as $employee)
                            <tr class="row{{$employee->id}}">
                                @include('ribbons.modalEditEmployee')
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
        @if (!$ribbon->whiteRibbons()->get()->isEmpty())
        <div class="col-lg-12 d-flex mt-5 mb-2">
            <div class="col-lg-2 px-2"></div>
            <div class="col-lg-8 px-2">
                <div class="col-lg-12 d-flex">
                    <div class="col-lg-10 px-0">
                        <h3><img src="{{ asset('images/cinta.svg') }}" class="iconoTitle"> Cinta Blanca</h3>
                    </div>
                    <div class="col-lg-2 px-0 pt-3">
                        <button type="button" class="btn btn-success  float-right" data-toggle="modal" data-target="#createCinta" onclick="limpiarInputsModalCreateCinta()">
                            Agregar
                        </button>    
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table table-striped my-2" id="tablaCintas">
                    {{-- Modal crear empleado --}}
                    @include('ribbons/modalCreateCinta')
                    {{-- Modal crear empleado --}}
                    
                    <thead class="bg-info">
                    <tr>                        
                        <th scope="col">Nomenclatura</th>
                        <th scope="col">Largo</th>
                        <th scope="col">Quitar o Cambiar</th>
                    </tr>
                    </thead>
                    <tbody id="tablaCinta">
                        @foreach ($ribbon->whiteRibbons()->get() as $whiteRibbon)
                            <tr class="rowCinta{{$whiteRibbon->id}}">
                                @include('ribbons.modalEditCinta')
                                <input type="hidden" name="cintas[]" id="cintaTD" class="form-control" value="{{$whiteRibbon->id}}">
                                <input type="hidden" name="largos[]" id="largoTD" class="form-control" value="{{$whiteRibbon->pivot->largo}}">
                                <td class="align-middle" id="nomenclatura">
                                    {{$whiteRibbon->nomenclatura}}
                                </td>
                                <td class="align-middle" id="largo">
                                    {{$whiteRibbon->pivot->largo}}
                                </td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-danger btn-sm" id="btnDeleteCinta" onclick="eliminarFilaCinta(this, id='{{$whiteRibbon->id}}')">
                                        <img src="{{ asset('images/cruz.svg') }}" class="iconosPequeños">
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" id="btnEditCinta" data-toggle="modal" data-target="#editCinta{{$whiteRibbon->id}}">
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
        @endif
        
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-2">
                <label>Observaciones</label>
                <textarea rows="3" class="form-control" name="observaciones" placeholder="Máximo 255 caracteres">{{$ribbon->observaciones}}</textarea>
                @error('observaciones')
                <br>
                <div class="alert alert-danger">
                    <small>{{$message}}</small>
                </div>
                <br>
                @enderror
            </div>

    <div class="col-12 mt-4 mb-4 text-center">
        <a class="btn btn-danger mx-3" href="{{route('ribbon.show', $ribbon->id)}}">Cancelar</a>
        <button type="submit" class="btn btn-success mx-3">Guardar</button>
    </div>
</div>
</form>
@endsection

@section('scripts')
<script type="text/javascript">
///////////////////EMPLEADOS//////////////////////
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

///////////////////CINTILLAS//////////////////////
    function crearFilaCinta()
    {
        var idCinta = $("#modalCinta").val();
        var idEstaRepetido = false;

        var largo = $("#largoCinta").val();

        if(idCinta != null )
        {
            if(largo != '')
            {
                $('#tablaCinta').find('tr').find('input#cintaTD').each(function(){
                    if(idCinta == $(this).val())
                    {
                        idEstaRepetido = true;
                        return;
                    }      
                })
                if(idEstaRepetido)
                {
                    mostrarErrorRepetidoCintas();
                    return;
                }
                else
                {
                    var nomenclatura = $("#modalCinta option:selected").text();
                    
                    var fila =
                    '<tr>'+
                        '<input type="hidden" name="cintas[]" id="cintaTD" class="form-control" value="'+idCinta+'">'+
                        '<input type="hidden" name="largos[]" id="largoTD" class="form-control" value="'+largo+'">'+
                        '<td class="align-middle" id="nomenclatura">'+
                            nomenclatura+
                        '</td>'+
                        '<td class="align-middle" id="largo">'+
                            largo+
                        '</td>'+
                        '<td class="align-middle">'+
                            '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaCinta(this)">'+
                                '<img src="{{ asset('images/cruz.svg') }}" class="iconosPequeños">'+
                            '</button>'+
                            '<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCinta'+idCinta+'" disabled>'+
                                '<img src="{{ asset('images/cambiar-empleado.svg') }}" class="iconosPequeños">'+
                            '</button>'+
                        '</td>'+
                    '</tr>'        

                    $('#tablaCintas').append(fila);
                    $('#createCinta').modal('toggle');
                }    
            }
            else
            {
                $(".error-largo").html(
                '<div class="alert alert-danger mt-2">' +
                    '<small>El campo largo no puede estar vacío</small>' +
                '</div>');    
            }
        }
        else
        {
            $(".error-nomenclatura").html(
                '<div class="alert alert-danger mt-2">' +
                    '<small>Debe seleccionar una cinta</small>' +
                '</div>');
        }
    }

    function mostrarErrorRepetidoCintas()
    {
        $(".error-nomenclatura").html(
                '<div class="alert alert-danger mt-2">' +
                    '<small>La cinta ya está agregada</small>' +
                '</div>');
    }

    function limpiarInputsModalCreateCinta()
    {
        $('#modalCinta').val('');
        $('#largoCinta').val('');

        $(".error-nomenclatura").html('');
        $(".error-largo").html('');
    }
    function cambioCinta()
    {
        var idCinta = $("#modalCinta").val();
        //Obtengo el array de cintas que pase desde el controlador y lo convierto en un objeto json
        //para poder utilizarlo en javascript. Se utilizó la clausula json de laravel
        var cintas = @json($cintaBlancas);
        //Obtengo un array(cinta) con los elementos que coincidan del array(cinta) 
        //filtrandolos por el id
        var cinta = cintas.filter(function (cinta) { return cinta.id == idCinta; });
        
        var largo = document.getElementById("largoCinta");

        largo.value = cinta[0].largo;
    }

    function eliminarFilaCinta(t, id)
    {
        var td = t.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr); // Borramos la fila 


        var child = document.getElementById('editCinta'+id);
        var parent = child.parentNode;
        parent.removeChild(child); // Borramos el modal correspondiente a esa fila
    }

    function cambioEditCinta(id)
    {
        var idCinta = $(".modalCinta" + id).val();

        //Obtengo el array de empleados que pase desde el controlador y lo convierto en un objeto json
        //para poder utilizarlo en javascript. Se utilizó la clausula json de laravel
        var cintas = @json($cintaBlancas);
        
        //Obtengo un array(empleado) con los elementos que coincidan del array(empleados) 
        //filtrandolos por el id
        var cinta = cintas.filter(function (cinta) { return cinta.id == idCinta; });
        
        var largo = document.getElementById("modalLargoCinta" + id);

        largo.value = cinta[0].largo;
    }

    function editRowCinta(id)
    {
        var idEstaRepetido = false;  
        var nuevoId=$(".modalCinta"+id).val(); //obtenemos en nuevo ID que selecciono el usuario en el <select> de empleado
        var largo = $("#modalLargoCinta"+id).val();
        
        $(".error-nomenclatura"+id).html('');
        $(".error-largo"+id).html('');

        if(nuevoId != id)
        {
            if(largo != '')
            {
                $('#tablaCinta').find('tr').find('input#cintaTD').each(function(){
                    if(nuevoId == $(this).val())
                    {
                        idEstaRepetido = true;
                        return;
                    }      
                })

                if(idEstaRepetido)
                {
                    $(".error-nomenclatura"+id).html(
                        '<div class="alert alert-danger mt-2">' +
                            '<small>La cinta ya está agregado</small>' +
                        '</div>');
                    return;
                }
                else
                {
                    var nomenclatura = $('.modalCinta'+ id +' option:selected').text();
                    
                    $("#editCinta"+id).attr('id', 'editCinta' + nuevoId);
                    $(".modalCinta"+id).attr('class', 'form-control modalCinta' + nuevoId);
                    $(".modalCinta"+nuevoId).attr('onchange', "cambioEditCinta(id='"+ nuevoId +"')");
                    $("#modalLargoCinta"+id).attr('id', "modalLargoCinta"+ nuevoId);
                    $(".buttonCinta"+id).attr('class', "btn btn-success buttonCinta"+ nuevoId);
                    $(".buttonCinta"+nuevoId).attr('onclick', "editRowCinta(id='"+ nuevoId +"')");
                    $(".error-nomenclatura"+id).attr('class', "error-nomenclatura"+nuevoId);
                    $(".error-largo"+id).attr('class', "error-largo"+nuevoId);

                    //a=$('.row'+id).find('button#btnDelete').attr('onclick');//
                    $('.rowCinta'+id).find('input#cintaTD').val(nuevoId);
                    $('.rowCinta'+id).find('input#largoTD').val(largo);
                    $('.rowCinta'+id).attr('class', 'rowCinta'+nuevoId);
                    $('.rowCinta'+nuevoId).find('td#largo').text(largo);
                    $('.rowCinta'+nuevoId).find('td#nomenclatura').text(nomenclatura);
                    $('.rowCinta'+nuevoId).find('button#btnEditCinta').attr('data-target', "#editCinta"+nuevoId);
                    $('.rowCinta'+nuevoId).find('button#btnDeleteCinta').attr('onclick', "eliminarFilaCinta(this, id='"+nuevoId+"')");

                    $("#editCinta"+nuevoId).modal("toggle");/////Me quede aqui
                    
                    //b=$('.row'+nuevoId).find('button#btnDelete').attr('onclick');//
                    //console.log(a+'\n');//
                    //console.log(b);//
                }            
            }
            else
            {
                $(".error-largo"+id).html(
                '<div class="alert alert-danger mt-2">' +
                    '<small>El campo largo no puede estar vacío</small>' +
                '</div>');    
            }
        }
        else
        {
            if(largo != '')
            {
                $('.rowCinta'+id).find('input#largoTD').val(largo);
                console.log($('.rowCinta'+id).find('input#largoTD').val())
                $('.rowCinta'+id).find('td#largo').text(largo);
                $("#editCinta"+id).modal("toggle");
            }
            else
            {
                $(".error-largo"+id).html(
                '<div class="alert alert-danger mt-2">' +
                    '<small>El campo largo no puede estar vacío</small>' +
                '</div>');    
            }
        }
    }    
</script>
@endsection

