@extends('layouts.formulario')

@section('title', 'Medida de Bobina')

@section('imgUrl',  asset('images/bobina.svg'))

@section('namePage', 'Medida de Bobina ' . $coilType->alias)

@section('retornar')
<a href="{{ route('coilType.index') }}" ><img src="{{ asset('images/flecha-derecha.svg') }}" class="iconosFlechas mirror"></a>
@endsection

@section('form')
<div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Alias</label>
            <input type="text" class="form-control" name="alias" value="{{ $coilType->alias }}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Ancho (cm)</label>
            <input type="number" step="0.0001" class="form-control" name="anchoCm" value="{{ $coilType->anchoCm }}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-2">
            <label>Largo (m)</label>
            <input type="number" step="0.0001" class="form-control" name="largoM" value="{{ $coilType->largoM }}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Densidad</label>
            <input type="number" step="0.0001" class="form-control" name="densidad" value="{{ $coilType->densidad }}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Material</label>
            <input type="text" class="form-control" name="material" value="{{ $coilType->material }}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Calibre</label>
            <input type="text" class="form-control" name="calibre" value="{{ $coilType->calibre }}" disabled>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 px-2 mt-3">
            <label>Tipo</label>
            <input type="text" class="form-control" name="tipo" value="{{ ($coilType->tipo == 'CELOFAN') ? 'CELOFÁN' : 'CENEFA'}}" disabled>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 px-2 mt-3">
            <label>Observaciones</label>
            <textarea rows="3" class="form-control" name="observaciones" disabled>{{ $coilType->observaciones }}</textarea>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3 text-center">
            <form action="{{ route('coilType.destroy', $coilType->id) }}" method="POST" id="formularioDestroy">
                @csrf
                @method('delete')
                @can('coilType.edit')
                    <a class="btn btn-warning mx-3" href="{{route('coilType.edit', $coilType)}}">Editar</a>
                @endcan
                @can('coilType.destroy')
                    <button class="btn btn-danger mx-3" type="submit" name="coilTypeForm">Eliminar</button>
                @endcan
            </form>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 px-2 float-left">
            <h3><img src="{{ asset('images/bolsa-de-papel.svg') }}" class="iconoTitle"> Medidas de Bolsas </h3>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 px-2 mt-2 float-left">
            <button type="button" class="btn btn-success float-right mb-3" data-toggle="modal" data-target="#create" onclick="cleanModal()">
                Añadir Medida de Bolsa
            </button>
        </div>
    <div class="col-lg-12">   
        {{-- Modal de contactos --}}
            @include('bagMeasures.create')
        {{-- Modal de contactos --}}
        
        {{-- Index de contactos --}}
            @include('bagMeasures.index')
        {{-- Index de contactos --}}    
    </div>
</div>
@endsection

@section('scripts')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $('#formularioDestroy').submit(function(e){
            e.preventDefault();
            Swal.fire({
            title: '¿Está seguro?',
            text: "La medida de bobina se eliminará definitivamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.isConfirmed) {
                var input = $("<input>").attr("type", "hidden")
                                        .attr("name", "coilTypeForm").val("coilTypeForm");
                $('#formularioDestroy').append(input);
                this.submit();
            }
            })
        });        
    </script>

    <script type="text/javascript">
        function formValidation()
        {
            var formBagMeasure = $("#formBagMeasure");
            var formData = formBagMeasure.serialize(); //variable con el valor de todos los input del formulario

            //Limpiamos el contenido de los div de errores
            cleanErrorsModal();

            $.ajax({
                url: "{{ route('coilType.store') }}",
                type: 'POST',
                data: formData,
                success: function(response)
                        {
                            if (response)
                            {
                                $('#create').modal('toggle'); //cerramos modal #create
                                location.reload(); // recargamos la página
                            }
                        },
                error: function(response)
                    {
                            if(errorMessageAncho = response.responseJSON.errors.ancho)
                            {
                                $(".ancho-error").html(
                                    '<div class="alert alert-danger mt-2">' +
                                        '<small>'+ errorMessageAncho +'</small>' +
                                    '</div>');
                            }
                            if(errorMessageLargo = response.responseJSON.errors.largo)
                            {
                                $(".largo-error").html(
                                    '<div class="alert alert-danger mt-2">' +
                                        '<small>'+ errorMessageLargo +'</small>' +
                                    '</div>');
                            }
                    }
            });
        }
        function cleanModal()
        {
            cleanErrorsModal();
            cleanInputValueModal();
        }
        function cleanErrorsModal()
        {
            //Limpiamos el contenido de los div de errores del modal #create
            $(".ancho-error").html('');
            $(".largo-error").html(''); 
        }
        function cleanInputValueModal()
        {
            //Limpiamos el contenido de los input del modal #create
            $('input[name=largo]').val('');
            $('input[name=ancho]').val('');
        }

        //Funciones para el form modal de Edit

        function formValidationEdit(item)
        {
            var idBagMeasure = item.id;

            var formBagMeasureEdit = $('#formBagMeasureEdit' + idBagMeasure);
            var formData = formBagMeasureEdit.serialize(); //variable con el valor de todos los input del formulario

            //Limpiamos el contenido de los div de errores
            cleanErrorsModalEdit(idBagMeasure);

            //Aqui guardamos la ruta con un id temporal
            var url = "route('coilType.update', ['id' => 'temp'])";
            //Aqui sustituimos la variable temp por el id de bagMeasure
            url = url.replace('temp', idBagMeasure);
            
            $.ajax({
                url: "/coilType/" + idBagMeasure,
                type: 'POST',
                data: formData,
                success: function(response)
                        {
                            if (response)
                            {
                                $('#edit'+ idBagMeasure).modal('toggle'); //cerramos modal #create
                                location.reload(); // recargamos la página
                            }
                        },
                error: function(response)
                    {
                            if(errorMessageAncho = response.responseJSON.errors.ancho)
                            {
                                $(".ancho-error"+ idBagMeasure).html(
                                    '<div class="alert alert-danger mt-2">' +
                                        '<small>'+ errorMessageAncho +'</small>' +
                                    '</div>');
                            }
                            if(errorMessageLargo = response.responseJSON.errors.largo)
                            {
                                $(".largo-error"+ idBagMeasure).html(
                                    '<div class="alert alert-danger mt-2">' +
                                        '<small>'+ errorMessageLargo +'</small>' +
                                    '</div>');
                            }
                    }
            });
        }
        function cleanErrorsModalEdit(idBagMeasure)
        {
            //Limpiamos el contenido de los input del modal #editID
            $(".ancho-error"+ idBagMeasure).html('')
            $(".largo-error"+ idBagMeasure).html(''); 
        }
    </script>
@endsection
