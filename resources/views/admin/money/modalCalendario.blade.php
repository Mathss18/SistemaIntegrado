<!-- Modal -->
<div class="modal fade " id="modalCalendario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalCalendar">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEvt">
          <input type="hidden" name="id" id="id">
          <input type="hidden" id="tipoCliForne" disabled>

          <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Título</label>
            <div class="col-sm-10">
              <input type="text" name="title" class="form-control" id="title" required>
            </div>
          </div>

          <div id='clienteModal'>
            <div class="form-group row">
              <label for="title" class="col-sm-2 col-form-label">Cliente</label>
              <div class="col-sm-10">
                <input required style="display:none" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:370px;">
                <input required class="typeahead form-control" id="ttexto" style="margin:0px auto;width:300px;" type="text">
              </div>
            </div>
          </div>

          <div id='fornecedorModal'>
            <div class="form-group row">
              <label for="fornecedor" class="col-sm-2 col-form-label">Fornecedor</label>
              <div class="col-sm-10">
                <input required style="display:none" id="ID_fornecedor" type="text" class="typeahead form-control " style="margin:0px auto;width:0px;">
                <input required class="typeahead form-control" id="ttexto1" style="margin:0px auto;width:350px;" type="text">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="start" class="col-sm-2 col-form-label">Inicio</label>
            <div class="col-sm-10">
              <input type="text" name="start" class="date form-control" id="start">
            </div>
          </div>

          <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Descrição</label>
            <div class="col-sm-10">
              <textarea name="description" id="description" cols="30" rows="4"></textarea>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger deleteEvent mr-5" data-dismiss="modal">Excluir</button>
        <button type="submit" class="btn btn-primary saveEvent ml-5">Salvar</button>
      </div>
      </form>
    </div>
  </div>
</div>