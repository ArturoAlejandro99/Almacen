<div class="modal fade" id="edit{{ $contact->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Editar Contacto</b></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formContactEdit{{ $contact->id }}" method="POST" action="{{ route('provider.update', $contact->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Télefono:</label>
                        <input type="number" class="form-control" name="telefono" id="telefono{{ $contact->id }}" value={{$contact->telefono}}>
                        <div class="telefono-error{{ $contact->id }}"></div>
                    </div>
                    <div class="form-group">
                        <label>Nombre(s):</label>
                        <input type="text" class="form-control" name="nombre" id="nombre{{ $contact->id }}" value={{$contact->nombre}}>
                        <div class="nombre-error{{ $contact->id }}"></div>
                    </div>
                    <div class="form-group">
                        <label>Apellidos:</label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos{{ $contact->id }}" value={{$contact->apellidos}}>
                        <div class="apellidos-error{{ $contact->id }}"></div>
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico:</label>
                        <input type="email" class="form-control" name="correoElectronico" id="correoElectronico{{ $contact->id }}" value={{$contact->correoElectronico}}>
                        <div class="correoElectronico-error{{ $contact->id }}"></div>
                    </div>
                    <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button id="{{ $contact->id }}" type="button" name="contactForm" class="btn btn-success" onclick="formValidationEdit(this)">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>