<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Crear Contacto</b></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formContact" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Teléfono:</label>
                        <input type="number" class="form-control" name="telefono" value="{{ old('telefono') }}">
                        <div class="telefono-error"></div>
                    </div>
                    <div class="form-group">
                        <label>Nombre(s):</label>
                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}">
                        <div class="nombre-error"></div>
                    </div>
                    <div class="form-group">
                        <label>Apellidos:</label>
                        <input type="text" class="form-control" name="apellidos" value="{{ old('apellidos') }}">
                        <div class="apellidos-error"></div>
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico:</label>
                        <input type="email" class="form-control" name="correoElectronico" value="{{ old('correoElectronico') }}">
                        <div class="correoElectronico-error"></div>
                    </div>
                    <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" name="contactForm" class="btn btn-success" onclick="formValidation()">Guardar Contacto</button>
                </div>
            </form>
        </div>
    </div>
</div>
