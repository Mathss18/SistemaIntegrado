<!-- Modal -->
<div class="modal fade" id="modalRelatorios" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Relatórios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col">
            <div class="row">
              <div><i class="fas fa-chart-pie"></i>&nbsp;<a style="font-size: 20px;" href="{{route('money.relatorios',1)}}">Rendimentos vs. despesas</a></div>
            </div>
            <div class="row">
              <div><i class="fas fa-chart-pie"></i>&nbsp;<a style="font-size: 20px;" href="{{route('money.relatorios',2)}}">Rendimentos ao longo do tempo</a></div>
            </div>
            <div class="row">
              <div><i class="fas fa-chart-pie"></i>&nbsp;<a style="font-size: 20px;" href="{{route('money.relatorios',3)}}">Relatórios de produção</a></div>
            </div>
            <div class="row">
              <div><i class="fas fa-chart-pie"></i>&nbsp;<a style="font-size: 20px;" href="{{route('money.relatorios',4)}}">Relatórios de materiais</a></div>
            </div>
            <div class="row">
              <div><i class="fas fa-chart-pie"></i>&nbsp;<a style="font-size: 20px;" href="{{route('money.relatorios',5)}}">Quanto tenho em estoque?</a></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>