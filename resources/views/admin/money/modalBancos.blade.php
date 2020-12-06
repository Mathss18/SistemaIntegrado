<!-- Modal -->
<div class="modal fade" id="modalBancos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bancos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col">
            @foreach($bancos as $banco)
            <div class="row">
              <div><i class="fas fa-university"></i>&nbsp;<a style="font-size: 20px;" href="{{route('money.mostrarBanco',$banco->ID_banco)}}">{{$banco->nome}}</a></div>
            </div>
            @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>