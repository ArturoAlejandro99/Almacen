@extends('layouts.tablaIndex')

@section('title', 'Usuarios')

@section('imgUrl',  asset('images/usuario.svg'))

@section('namePage', 'Usuarios')

@section('nuevo')
@can('user.create')
<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-success float-right my-3" href="{{route('user.create')}}"> Nuevo </a>
    </div>
</div> 
@endcan
@endsection

@section('filtrado')
    <form action="{{ route('user.index') }}" method="GET" class="row g-3" id="formOrder">
        <div class="col-lg-5">
            <h6 class="textoConLinea"><span>Ordenar</span></h6>
            <div class="row">
                <div class="col-lg-7 d-flex align-items-center">
                    <div class="select">
                        <select class="form-control" name="orderBy" onchange="cambioOrden()">
                            <option value="id" {{ ($orderBy == 'id') ? 'selected' : '' }}>Ordenar por Identificador</option>
                            <option value="name" {{ ($orderBy == 'name') ? 'selected' : '' }}>Ordenar por Nombre</option>
                            <option value="email" {{ ($orderBy == 'email') ? 'selected' : '' }}>Ordenar por Usuario</option>
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
        </div>        
        <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 d-lg-flex d-md-flex align-items-center">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 pr-0 pl-lg-5">
                <input class="form-control" style="width: 100%" type="search" placeholder="Nombre..." name="name" value="{{ ($name != '') ? $name : '' }}">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pl-0 pr-0">
                <button class="form-control btn btn-secondary pl-2" style="width: 100%" type="submit">
                    <img src={{ asset('images/buscar.svg') }}  class="iconosPequeños float-left">
                    Buscar
                </button>
            </div>   
        </div>
    </form>
@endsection

@section('table')
<table class="table table-striped my-4" >
    <thead class="bg-info">
<tr>
    <th scope="col">#</th>
    <th scope="col">Nombre</th>
    <th scope="col">Usuario</th>
    <th scope="col"></th>
    <th scope="col"></th>
  </tr>
</thead>
<tbody id="tableBody">
    @foreach ($users as $item)
    <tr>
        <th scope="row" class="align-middle">{{$item->id}}</th>
        <td class="align-middle">{{$item->name}}</td>
        <td class="align-middle">{{$item->email}}</td>
        <td><form action="{{ route('user.destroy', $item->id) }}" method="POST" id="formularioDestroy">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm">
                <img src="{{ asset('images/icono-eliminar.svg') }}" class="iconosPequeños">
            </button>
        </form></td>
        <td><a href="{{route('user.edit', $item)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
    </tr>
    @endforeach
</tbody>
</table>
<div class="d-flex  justify-content-center" id="paginacion">
    {{$users->links()}}
</div>

@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $('#formularioDestroy').submit(function(e){
        e.preventDefault();
        Swal.fire({
        title: '¿Está seguro?',
        text: "El usuario se eliminará definitivamente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });        
</script>

@if(session('eliminar') == 'ok')
    <script>
        Swal.fire(
            '¡Eliminado!',
            'El rol se ha eliminado con éxito.',
            'success'
            )
    </script>
@endif

<script type="text/javascript">
    function cambioOrdenAscendente()
    {
        ascendente();
        cambioOrden();
    }

    function cambioOrdenDescendente()
    {
        descendente();
        cambioOrden();
    }

    function cambioOrden()
    {
        var form = $("#formOrder");
        var formData = form.serialize(); //variable con el valor de todos los input del formulario

        $.ajax({
            url: "{{ route('user.index') }}",
            type: 'GET',
            data: formData,
            success: function(response)
                     {
                        var table = document.getElementById('tableBody');
                        var newTable = $(response).find('tbody');
                        $(table).html(newTable.html());

                        var pagination = document.getElementById('paginacion');
                        var newPagination = $(response).find('div#paginacion');
                        $(pagination).html(newPagination.html());
                     },
            error: function(response)
                   {
                        console.log(response);
                        alert('Error. Por favor recargue la página.');
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

    function inicializador(){
        if('{{$order}}' == 'ASC')
            ascendente();
        else
            descendente();
    }
    window.onload = inicializador;

    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href');
        var form = $("#formOrder");
        var formData = form.serialize(); //variable con el valor de todos los input del formulario
        
        $.ajax({
            url: page,
            type: 'GET',
            data: formData,
            success: function(response)
                    {
                        //console.log(response);
                        var table = document.getElementById('tableBody');
                        var newTable = $(response).find('tbody');
                        $(table).html(newTable.html());
                        
                        var pagination = document.getElementById('paginacion');
                        var newPagination = $(response).find('div#paginacion');
                        $(pagination).html(newPagination.html());
                    },
            error: function(response)
                {
                        console.log(response)
                        alert('Error. Por favor recargue la página.');
                }
        });
    });
</script>
@endsection