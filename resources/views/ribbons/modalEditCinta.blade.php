<div class="modal fade" id="editCinta{{$whiteRibbon->id}}">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cambiar Cinta Blanca</b></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-lg-8 px-2">
                    <label align-midle> Nomenclatura:</label>
                    <select class="form-control modalCinta{{$whiteRibbon->id}}" onchange="cambioEditCinta(id='{{ $whiteRibbon->id }}')">
                        @foreach($cintaBlancas as $cintaBlancaC)
                            <option {{ ($cintaBlancaC->id == $whiteRibbon->id)? 'selected' : '' }} value="{{ $cintaBlancaC->id }}">{{ $cintaBlancaC->nomenclatura }}</option>
                        @endforeach
                    </select>
                    <div class="error-nomenclatura{{$whiteRibbon->id}}"></div> 
                </div>
                <div class="col-lg-4 px-2">
                    <label> Largo (metros):</label>
                    <input type="number" step="0.0001" class="form-control" id="modalLargoCinta{{ $whiteRibbon->id }}" value="{{$whiteRibbon->pivot->largo }}" >
                    <div class="error-largo{{$whiteRibbon->id}}"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success buttonCinta{{ $whiteRibbon->id }}" onclick="editRowCinta(id='{{ $whiteRibbon->id }}')">Aceptar</button>
            </div>
        </div>
    </div>
</div>
