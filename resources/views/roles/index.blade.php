@extends('layouts.tablaIndex')

@section('title', 'Roles')

@section('imgUrl',  asset('images/usuario.svg'))

@section('namePage', 'Roles')

@section('nuevo')
@can('rol.create')
<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-success float-right my-3" href="{{route('rol.create')}}"> Nuevo </a>
    </div>
</div> 
@endcan
@endsection
{{--
@section('filtrado')
    <form action="{{ route('coilType.index') }}" method="GET" class="row g-3" id="formOrder">
        <div class="col-lg-5">
            <h6 class="textoConLinea"><span>Ordenar</span></h6>
            <div class="row">
                <div class="col-lg-7 d-flex align-items-center">
                    <div class="select">
                        <select class="form-control" name="orderBy" onchange="actualizarTabla()">
                            <option value="id" {{ ($orderBy == 'id') ? 'selected' : '' }}>Ordenar por Identificador</option>
                            <option value="alias" {{ ($orderBy == 'alias') ? 'selected' : '' }}>Ordenar por Alias</option>
                            <option value="largoM" {{ ($orderBy == 'largoM') ? 'selected' : '' }}>Ordenar por Largo</option>
                            <option value="anchoCm" {{ ($orderBy == 'anchoCm') ? 'selected' : '' }}>Ordenar por Ancho</option>
                            <option value="tipo" {{ ($orderBy == 'tipo') ? 'selected' : '' }}>Ordenar por Tipo</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-2 d-flex align-items-center">
                            <div class="mt-1 mb-0 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="order" id="radioAsc" value="ASC" onclick="cambioOrdenAscendente()">
                            </div>
                        </div>
                        <div class="col-lg-10 d-flex align-items-center">
                            <h5 class="mt-1 mb-0">
                                <span class="badge badge-pill badge-light pr-4" id="badgeAsc" style="color:#343A40; font-weight:normal; width: 95%;">
                                    <img src={{ asset('images/ascendente-black.svg') }}  class="iconosFiltrado" id="imgAsc">
                                    Ascendente
                                </span>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 d-flex align-items-center">
                            <div class="mt-4 mb-0 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="order" id="radioDesc" value="DESC" onclick="cambioOrdenDescendente()">
                            </div>
                        </div>
                        <div class="col-lg-10 d-flex align-items-center">
                            <h5 class="mt-4 mb-0">
                                <span class="badge badge-pill badge-light pr-4" id="badgeDesc" style="color:#343A40; font-weight:normal; width: 95%;">
                                    <img src={{ asset('images/descendente-black.svg') }}  class="iconosFiltrado" id="imgDesc">
                                    Descendente
                                </span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="textoConLinea mt-3"><span>Filtrar</span></h6>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row ">
                        <div class="col-lg-12 mb-1 mt-1">
                            <div class="form-check float-right">
                                <input class="form-check-input" type="checkbox" onchange="cambiarTipo(this)" {{ ($tipo) ? 'checked' : '' }}>
                                <label class="form-check-label float-right text-muted mr-3" for="flexCheckDefault" id="labelTipo">
                                  Tipo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <select class="form-control text-muted" name="tipo" id="checkTipo" onchange="actualizarTabla()" {{ ($tipo) ? '' : 'disabled' }}>
                                <option value="">--todos--</option>
                                @foreach($allTypes as $t)  
                                    <option {{ ($tipo == $t->tipo) ? 'selected' : ''}} value="{{$t->tipo}}">{{$t->tipo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="col-lg-7 d-flex align-items-center">
            <div class="col-lg-10 pr-0 pl-5">
                <input class="form-control" style="width: 100%" type="search" placeholder="Alias..." name="alias" value="{{ ($alias != '') ? $alias : '' }}">
            </div>
            <div class="col-lg-2 pl-0 pr-0">
                <button class="form-control btn btn-secondary pl-2" style="width: 100%" type="submit">
                    <img src={{ asset('images/buscar.svg') }}  class="iconosPequeños float-left">
                    Buscar
                </button>
            </div>   
        </div>
    </form>
@endsection--}}

@section('table')
<tr>
    <th scope="col"> # </th>
    <th scope="col"> Nombre </th>
    <th scope="col"> <span class="sr-only"> (botonConsultar) </span> </th>
</tr>
</thead>
<tbody id="tableBody">
    @foreach ($roles as $rol)
    <tr>
        <th scope="row" class="align-middle"> {{ $rol->id }} </th>
        <td class="align-middle"> {{ $rol->name }} </td>
        <td><a href="{{ route('rol.show', $rol) }}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    </tr>
    @endforeach
@endsection

<div class="d-flex  justify-content-center">{{$roles->links()}}</div>

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @if(session('eliminar') == 'ok')
        <script>
            Swal.fire(
                '¡Eliminado!',
                'El rol se ha eliminado con éxito.',
                'success'
                )
        </script>
    @endif
@endsection

{{--
@section('scripts')
<script type="text/javascript">
    function cambioOrdenAscendente()
    {
        ascendente();
        actualizarTabla();
    }

    function cambioOrdenDescendente()
    {
        descendente();
        actualizarTabla();
    }

    function actualizarTabla()
    {
        var form = $("#formOrder");
        var formData = form.serialize(); //variable con el valor de todos los input del formulario

        $.ajax({
            url: "{{ route('coilType.index') }}",
            type: 'GET',
            data: formData,
            success: function(response)
                     {
                        var table = document.getElementById('tableBody');
                        var newTable = $(response).find('tbody');
                        
                        //console.log(response);

                        $(table).html(newTable.html());
                     },
            error: function(response)
                   {
                        alert(response);
                   }
        });
    }
    
    function ascendente()
    {
        $('#badgeAsc').attr('class', 'badge badge-pill badge-info pr-4');
        $('#badgeAsc').attr('style', 'color:white; font-weight:normal; width: 95%;');
        $('#imgAsc').attr('src', "{{ asset('images/ascendente-white.svg') }}");
        $('#radioAsc').prop('checked', true);
        
        $('#badgeDesc').attr('class', 'badge badge-pill badge-light pr-4');
        $('#badgeDesc').attr('style', 'color:black; font-weight:normal; width: 95%;');
        $('#imgDesc').attr('src', "{{ asset('images/descendente-black.svg') }}");
        $('#radioDesc').prop('checked', false);
    }

    function descendente()
    {
        $('#badgeAsc').attr('class', 'badge badge-pill badge-light pr-4');
        $('#badgeAsc').attr('style', 'color:black; font-weight:normal; width: 95%;');
        $('#imgAsc').attr('src', "{{ asset('images/ascendente-black.svg') }}");
        $('#radioAsc').prop('checked', false);

        $('#badgeDesc').attr('class', 'badge badge-pill badge-info pr-4');
        $('#badgeDesc').attr('style', 'color:white; font-weight:normal; width: 95%;');
        $('#imgDesc').attr('src', "{{ asset('images/descendente-white.svg') }}");
        $('#radioDesc').prop('checked', true);
    }

    function cambiarTipo(checkbox)
    {
        if(checkbox.checked)
        {
            $('#labelTipo').attr('class', 'form-check-label float-right mr-3');

            $('#checkTipo').attr('class', 'form-control');
            $('#checkTipo').prop('disabled', false);
        }
        else
        {
            $('#labelTipo').attr('class', 'form-check-label float-right text-muted mr-3');

            var selectTipo = $('#checkTipo');
            selectTipo.attr('class', 'form-control text-muted');
            selectTipo.prop('disabled', true);
            selectTipo[0].selectedIndex = 0;
        }

        actualizarTabla();
    }

    function inicializador(){
        if('{{$order}}' == 'ASC')
            ascendente();
        else
            descendente();
    }
    
    window.onload = inicializador;
</script>
@endsection--}}