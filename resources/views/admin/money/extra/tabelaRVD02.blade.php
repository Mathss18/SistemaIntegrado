<table class="table table-striped table-borderless table-sm">
    <thead>
        <tr>
            <th scope="col-md-2">Categoria de despesas</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 1; $i < sizeof($resultado); $i++) <tr class="clickable-row-{{strtoupper($resultado[$i]->tipoFav)}}">
            <td style="width: 25%">{{strtoupper($resultado[$i]->tipoFav)}}</td>
            <td style="width: 25%">R$: {{number_format($resultado[$i]->total,2,',','.')}}</td>
            </tr>
        @endfor
            <tr>
                <td style="color: blue;">Total de despesas:</td>
                <td style="color: blue;">R$: {{number_format($totalDespesa,2,',','.')}}</td>
            </tr>
    </tbody>
</table>

@for($i = 0; $i < sizeof($resultado)-1; $i++)
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id='modalRVD02-{{strtoupper($tipoFavArray[$i][0]->tipoFav)}}' tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Despesas de {{strtoupper($tipoFavArray[$i][0]->tipoFav)}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tableDT" class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Banco</th>
                            <th scope="col">Favorecido</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tipoFavArray[$i] as $rr)
                        <tr style="height: 1px;">
                            <td>{{date('d/m/Y', strtotime($rr->start))}}</td>
                            <td>{{strtoupper($rr->nome)}}</td>
                            <td>{{strtoupper($rr->favorecido)}}</td>
                            <td>R$: {{number_format($rr->valor,2,',','.')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.clickable-row-{{strtoupper($rr->tipoFav)}}').click(function() {
    $('#modalRVD02-{{strtoupper($rr->tipoFav)}}').modal('toggle');
    $('#modalRVD02-{{strtoupper($rr->tipoFav)}}').modal('show');

});
</script>
@endfor