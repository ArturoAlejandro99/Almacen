<div class="table-responsive-md table-responsive-sm">
<table class="table table-striped mt-1 mb-5" >
    <thead class="bg-info">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Ancho</th>
            <th scope="col">Largo</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bagMeasures as $bagMeasure)
            <tr>
                <th scope="row" class="align-middle">{{ $bagMeasure->id }}</th>
                <td class="align-middle">{{ $bagMeasure->ancho }}</td>
                <td class="align-middle">{{ $bagMeasure->largo }}</td>
                <td class="align-middle">
                    {{-- MODAL edit para cada contacto--}}
                    @include('bagMeasures.edit')
                    {{-- MODAL edit para cada contacto--}}
                    <form action="{{ route('coilType.destroy', $bagMeasure->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <a href="{{ route('coilType.edit', $bagMeasure->id) }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$bagMeasure->id}}">
                            <img src="{{ asset('images/icono-editar.svg') }}" class="iconosPequeños">
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <img src="{{ asset('images/icono-eliminar.svg') }}" class="iconosPequeños">
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>