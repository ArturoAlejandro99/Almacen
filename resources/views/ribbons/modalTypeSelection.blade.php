<div class="modal fade" id="createProduct">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Seleccione un nuevo elemento a crear</b></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
                <div class="modal-body">
                  @can('bag.create')
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                      Bolsas
                    </label>
                  </div>
                    @else
                    <input type="hidden" name="flexRadioDefault" id="flexRadioDefault1">
                  @endcan
                    @can('wasteBag.create')
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2">
                      <label class="form-check-label" for="flexRadioDefault2">
                        Merma
                      </label>
                    </div>
                    @else
                    <input type="hidden" name="flexRadioDefault" id="flexRadioDefault2">
                    @endcan
                      @can('ribbonReel.create')
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="3">
                        <label class="form-check-label" for="flexRadioDefault2">
                          Hueso
                        </label>
                      </div>
                      @else
                    <input type="hidden" name="flexRadioDefault" id="flexRadioDefault3">
                      @endcan
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" onclick="redirect({{$ribbon->id}})">Crear</button>  
                </div>
                <script type="text/javascript">
                    function redirect(id){
                        if(document.getElementById('flexRadioDefault1').checked == true){
                           location.replace ("http://bolsasdecelofanminabi.com.mx/bag/create/"+id)
                        }
                        if(document.getElementById('flexRadioDefault2').checked == true){
                            location.replace ("http://bolsasdecelofanminabi.com.mx/wasteBag/create/"+id)
                        }
                        if(document.getElementById('flexRadioDefault3').checked == true){
                            location.replace ("http://bolsasdecelofanminabi.com.mx/ribbonReel/create/"+id)
                        }
                    }
                </script>
        </div>
    </div>
</div>
