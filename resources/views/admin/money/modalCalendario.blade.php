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
            <div class="col-sm-10">
              <input value='title' type="hidden" name="title" class="form-control" id="title">
            </div>
          </div>

          <div class="form-group row" id='categoriaModal'>
            <label for="title" class="col-sm-2 col-form-label">Categoria</label>
            <div class="col-sm-10">
              <select required id="categoria" class="custom-select">
                <option value="">Escolha uma categoria...</option>
                <option value="fornecedor">Fornecedor</option>
                <option value="transportadora">Transportadora</option>
                <option value="funcionario">Salário</option>
                <option value="imposto">Imposto</option>
                <option value="investimento">Investimento</option>
                <option id="optionCli" value="cliente" disabled>Cliente</option>
              </select>
            </div>
          </div>

          <div id="inputsModal" style="display:none">

            <div id='clienteModal' style="display:none">
              <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Cliente</label>
                <div class="col-sm-10">
                  <input required style="display:none" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:0px;" disabled>
                  <input required class="typeahead form-control" id="ttexto" style="margin:0px auto;width:383px;" type="text" disabled>
                </div>
              </div>
            </div>



            <div id='fornecedorModal' style="display:none">
              <div class="form-group row">
                <label for="fornecedor" class="col-sm-2 col-form-label">Fornecedor</label>
                <div class="col-sm-10">
                  <input required style="display:none" id="ID_fornecedor" type="text" class="typeahead form-control " style="margin:0px auto;width:0px;" disabled>
                  <input required class="typeahead form-control" id="ttexto1" style="margin:0px auto;width:383px;" type="text" disabled>
                </div>
              </div>
            </div>

            <div id='transportadoraModal' style="display:none">
              <div class="form-group row">
                <label for="transportadora" class="col-sm-2 col-form-label">Transp.</label>
                <div class="col-sm-10">
                  <input required style="display:none" id="ID_transportadora" type="text" class="typeahead form-control " style="margin:0px auto;width:0px;" disabled>
                  <input required class="typeahead form-control" id="ttexto2" style="margin:0px auto;width:383px;" type="text" disabled>
                </div>
              </div>
            </div>

            <div id='funcionarioModal' style="display:none">
              <div class="form-group row">
                <label for="fornecedor" class="col-sm-2 col-form-label">Nome Func.</label>
                <div class="col-sm-10">
                  <input required style="display:none" id="ID_funcionario" type="text" class="typeahead form-control " style="margin:0px auto;width:0px;" disabled>
                  <input required class="typeahead form-control" id="ttexto3" style="margin:0px auto;width:383px;" type="text" disabled>
                </div>
              </div>
            </div>


            <div id='impostoModal' style="display:none">
              <div class="form-group row">
                <label for="imposto" class="col-sm-2 col-form-label">Imposto</label>
                <div class="col-sm-10">
                  <input required style="display:none" id="ID_imposto" type="text" class="typeahead form-control " style="margin:0px auto;width:0px;" disabled>
                  <input required class="typeahead form-control" id="ttexto4" style="margin:0px auto;width:383px;" type="text" disabled>
                </div>
              </div>
            </div>

            <div id='investimentoModal' style="display:none">
              <div class="form-group row">
                <label for="ID_investimento" class="col-sm-2 col-form-label">Invest.</label>
                <div class="col-sm-10">
                  <input required style="display:none" id="ID_investimento" type="text" class="typeahead form-control " style="margin:0px auto;width:0px;" disabled>
                  <input required class="typeahead form-control" id="ttexto5" style="margin:0px auto;width:383px;" type="text" disabled>
                </div>
              </div>
            </div>



            <div class="form-group row">
              <label for="start" class="col-sm-2 col-form-label">Data</label>
              <div class="col-sm-10">
                <input type="text" name="start" class="date form-control" id="start">
              </div>
            </div>

            <div class="form-group row">
              <label for="start" class="col-sm-2 col-form-label">Banco</label>
              <div class="col-sm-10">
                <select required id="banco" class="custom-select">
                  @foreach($bancos as $banco)
                  <option value="{{$banco->ID_banco}}">{{$banco->nome}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="start" class="col-sm-2 col-form-label">Valores</label>
              <div class="col">

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                  </div>
                  <input id="valor" type="number" step="0.01" class="form-control" placeholder="Valor" required>
                </div>

              </div>

              <div class="col">

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">N°</span>
                  </div>
                  <input id="numero" type="text" class="form-control" placeholder="Número do cheque">
                </div>

              </div>

            </div>

            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">Obs</label>
              <div class="col-sm-10">
                <textarea name="description" id="description" cols="51" rows="2"></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">Situação</label>
              <div class="col-sm-10">
                <input type="checkbox" id="situacao" onchange="showState()" checked data-toggle="toggle" data-on="Pendente" data-off="Registrado" data-onstyle="danger" data-offstyle="success" data-width="380">
              </div>
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

<script>
  function showState(){
    console.log('entrei');
    console.log($('#situacao').val());
    if($('#situacao').val()=='on'){
      $('#situacao').val('off')
    }
    else{
      $('#situacao').val('on')
    }
    
  }
  
  
</script>