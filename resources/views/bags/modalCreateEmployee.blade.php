<div class="modal fade" id="create">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Agregar Empleado</b></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
                <div class="modal-body row">
                    <div class="col-lg-8 px-2">
                        <label align-midle> Empleado:</label>
                        <select class="form-control" id="modalEmpleado" onchange="cambio()">
                            <option selected class="text-muted" disabled value="">--seleccione empleado--</option>
                            @foreach($employees as $employee)
                                <option value={{ $employee->id }}>{{ $employee->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="error-empleado"></div>    
                    </div>
                    <div class="col-lg-4 px-2">
                        <label> Status:</label>
                        <input type="text" class="form-control" id="modalStatusEmpleado" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="crearFila()">Agregar Empleado</button>
                </div>
        </div>
    </div>
</div>