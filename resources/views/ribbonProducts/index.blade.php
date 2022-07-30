@extends('layouts.tablaIndexSinAgregar')

@section('title', 'Bolsas')

@section('imgUrl',  asset('images/bolsa-de-papel.svg'))

@section('namePage', 'Bolsas')

@section('filtrado')
    <form action="{{ route('ribbonProduct.index') }}" method="GET" class="row g-3 mt-5" id="formOrder">
        <div class="col-lg-5">
                <h6 class="textoConLinea"><span>Ordenar</span></h6>
                <div class="row">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="select">
                            <select class="form-control" name="orderBy" onchange="actualizarTabla()">
                                <option value="id" {{ ($orderBy == 'id') ? 'selected' : '' }}>Ordenar por Identificador</option>
                                <option value="nomenclatura" {{ ($orderBy == 'nomenclatura') ? 'selected' : '' }}>Ordenar por Nomenclatura</option>
                                <option value="fAdquisicion" {{ ($orderBy == 'fAdquisicion') ? 'selected' : '' }}>Ordenar por Fecha Adquisición</option>
                                <option value="medidaBolsa" {{ ($orderBy == 'medidaBolsa') ? 'selected' : '' }}>Ordenar por Medida</option>
                                <option value="peso" {{ ($orderBy == 'peso') ? 'selected' : '' }}>Ordenar por Peso</option>
                                <option value="status" {{ ($orderBy == 'status') ? 'selected' : '' }}>Ordenar por Status</option>
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
        <div class="col-lg-7 col-md-12 col-sm-12 d-lg-flex d-md-flex align-items-center">
            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 pr-0 pl-lg-5">
                <input class="form-control" style="width: 100%" type="search" placeholder="Nomenclatura..." name="nomenclatura" value="{{ ($nomenclatura != '') ? $nomenclatura : '' }}">
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 pl-0 pr-0">
                <button class="form-control btn btn-secondary pl-2" style="width: 100%" type="submit">
                    <img src={{ asset('images/buscar.svg') }}  class="iconosPequeños float-left">
                    Buscar
                </button>
            </div>   
        </div>
        <div class="col-lg-9 d-flex">
            <h6 class="textoConLinea mt-3"><span>Filtrar</span></h6>                 
        </div>
        <div class="col-lg-12 d-lg-flex">
            <div class="col-lg-3 col-md-6 col-sm-12 pl-0 pr-0">
                <div class="row">
                    <div class="col-lg-9 mb-1 mt-1">
                        <div class="form-check float-right">
                            <input class="form-check-input" type="checkbox" onchange="cambiarStatus(this)" {{ ($status) ? 'checked' : '' }}>
                            <label class="form-check-label float-right text-muted mr-3" for="flexCheckDefault" id="labelStatus">
                                Status
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <select class="form-control text-muted" name="status" id="checkStatus" onchange="actualizarTabla()" {{ ($status) ? '' : 'disabled' }}>
                            <option value="">--todos--</option>
                            @foreach($allStatus as $s)  
                                <option {{ ($status == $s->status) ? 'selected' : ''}} value="{{$s->status}}">{{$s->status}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pl-0 pr-0">
                <div class="row">
                    <div class="col-lg-9 mb-1 mt-1">
                        <div class="form-check float-right">
                            <input class="form-check-input" type="checkbox" onchange="cambiarFecha(this)"> {{-- ($fecha) ? 'checked' : '' --}}
                            <label class="form-check-label float-right text-muted" for="flexCheckDefault" id="labelFecha">
                                Fecha Adquisición
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1 d-flex align-items-center">
                        <img src="{{ asset('images/fecha-disabled.svg') }}" class="iconosPequeños" id="icoFecha">
                    </div> 
                    <div class="col-lg-9">
                        <input class="form-control" type="text" name="fecha" id="daterange" value="" disabled> 
                    </div> 
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pl-0 pr-0">
                <div class="row">
                    <div class="col-lg-9 mb-1 mt-1">
                        <div class="form-check float-right">
                            <input class="form-check-input" type="checkbox" onchange="cambiarMedida(this)" {{ ($medida) ? 'checked' : '' }}>
                            <label class="form-check-label float-right text-muted mr-3" for="flexCheckDefault" id="labelMedida">
                                Medida
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <select class="form-control text-muted" name="medida" id="checkMedida" onchange="actualizarTabla()" {{ ($medida) ? '' : 'disabled' }}>
                            <option value="">--todos--</option>
                            @foreach($allMedidas as $m)
                                @if($m->medidaBolsa != "")
                                    <option {{ ($medida == $m->medidaBolsa) ? 'selected' : ''}} value="{{$m->medidaBolsa}}">{{$m->medidaBolsa}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div> 
                </div>
            </div>
        </div>
    </form>
@endsection

@section('table')
<table class="table table-striped my-4" >
    <thead class="bg-info">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nomenclaturas</th>
            <th scope="col">Peso</th>
            <th scope="col">Medida</th>
            <th scope="col">Fecha Adquisición</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
          </tr>
</thead>
<tbody id="tableBody">
    @foreach ($ribbonProduct as $item)
    <tr>
        <th scope="row" class="align-middle">{{$item->id}}</th>
        <td class="align-middle">{{$item->nomenclatura}}</td>
        <td class="align-middle">{{$item->peso}}</td>
        <td class="align-middle">{{$item->medidaBolsa}}</td>
        <td class="align-middle">{{$item->fAdquisicion}}</td>
        <td class="align-middle"><label class="btn btn-outline-{{ ($item->status == 'DISPONIBLE') ? 'success' : 'danger' }} m-0">{{$item->status}}</label></td>
        @if ($item->ribbon_product_type == 'App\Models\Bag')
        <td><a href="{{route('bag.show',$item->ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @elseif($item->ribbon_product_type == 'App\Models\WasteBag')
        <td><a href="{{route('wasteBag.show',$item->ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @elseif($item->ribbon_product_type == 'App\Models\RibbonReel')
        <td><a href="{{route('ribbonReel.show',$item->ribbon_product_id)}}"><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas"></a></td>
        @endif
    </tr>
    @endforeach
</tbody>
</table>
<div class="d-flex justify-content-center" id="paginacion">
    {{$ribbonProduct->links()}}
</div>

@endsection

@section('scripts')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@if(session('eliminar') == 'ok')
    <script>
        Swal.fire(
            '¡Eliminado!',
            'La bolsa se ha eliminado con éxito.',
            'success'
            )
    </script>
@elseif(session('eliminar') == 'ribbonReel')
<script>
    Swal.fire(
        '¡Eliminado!',
        'El hueso se ha eliminado con éxito.',
        'success'
        )
</script>
@elseif(session('eliminar') == 'wasteBag')
<script>
    Swal.fire(
        '¡Eliminado!',
        'La merma de bolsa se ha eliminado con éxito.',
        'success'
        )
</script>
@endif

<script type="text/javascript">

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        actualizarTabla();
    });

    $('#daterange').daterangepicker(
        {
            "locale": 
            {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Filtrar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Personalizar",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Setiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            "opens": "center"
        }
    ); // cargamos el datarange

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
            url: "{{ route('ribbonProduct.index') }}",
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

    function cambiarStatus(checkbox)
    {
        if(checkbox.checked)
        {
            $('#labelStatus').attr('class', 'form-check-label float-right mr-3');

            $('#checkStatus').attr('class', 'form-control');
            $('#checkStatus').prop('disabled', false);
        }
        else
        {
            $('#labelStatus').attr('class', 'form-check-label float-right text-muted mr-3');

            var selectStatus = $('#checkStatus');
            selectStatus.attr('class', 'form-control text-muted');
            selectStatus.prop('disabled', true);
            selectStatus[0].selectedIndex = 0;
        }

        actualizarTabla();
    }

    function cambiarMedida(checkbox)
    {
        if(checkbox.checked)
        {
            $('#labelMedida').attr('class', 'form-check-label float-right mr-3');

            $('#checkMedida').attr('class', 'form-control');
            $('#checkMedida').prop('disabled', false);
        }
        else
        {
            $('#labelMedida').attr('class', 'form-check-label float-right text-muted mr-3');

            var selectMedida = $('#checkMedida');
            selectMedida.attr('class', 'form-control text-muted');
            selectMedida.prop('disabled', true);
            selectMedida[0].selectedIndex = 0;
        }

        actualizarTabla();
    }

    function cambiarFecha(checkbox)
    {
        if(checkbox.checked)
        {
            $('#labelFecha').attr('class', 'form-check-label float-right');
            $('#icoFecha').attr('src', "{{ asset('images/fecha-enabled.svg') }}");

            $('#daterange').attr('class', 'form-control');
            $('#daterange').prop('disabled', false);
        }
        else
        {
            $('#labelFecha').attr('class', 'form-check-label float-right text-muted');
            $('#icoFecha').attr('src', "{{ asset('images/fecha-disabled.svg') }}");

            $('#daterange').attr('class', 'form-control text-muted');
            $('#daterange').prop('disabled', true);

            actualizarTabla();
        }
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
                        console.log(response);
                        alert('Error. Por favor recargue la página.');
                   }
        });
    });
</script>
@endsection