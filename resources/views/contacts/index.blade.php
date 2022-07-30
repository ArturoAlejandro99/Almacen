<div class="table-responsive-md table-responsive-sm">
<table class="table table-striped mt-1 mb-5" >
    <thead class="bg-info">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Télefono</th>
            <th scope="col">Nombre(s)</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Correo electrónico</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $contact)
            <tr>
                <th scope="row" class="align-middle">{{ $contact->id }}</th>
                <td class="align-middle">{{ $contact->telefono }}</td>
                <td class="align-middle">{{ $contact->nombre }}</td>
                <td class="align-middle">{{ $contact->apellidos }}</td>
                <td class="align-middle">{{ $contact->correoElectronico }}</td>
                <td class="align-middle">
                    {{-- MODAL edit para cada contacto--}}
                    @include('contacts.edit')
                    {{-- MODAL edit para cada contacto--}}
                    <form action="{{ route('provider.destroy', $contact->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <a href="{{ route('provider.edit', $contact->id) }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{$contact->id}}">
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