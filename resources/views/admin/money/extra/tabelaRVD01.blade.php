<table class="table table-striped table-borderless table-sm">
    <thead>
        <tr>
            <th scope="col-md-2">Categoria de Rendimento</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        <tr style="height: 1px;" class='clickable-row'>
            <td style="width: 25%">{{strtoupper($resultado[0]->tipoFav)}}</td>
            <td style="width: 25%">R$: {{number_format($resultado[0]->total,2,',','.')}}</td>
        </tr>
        <tr>
            <td style="color: blue;">Total de rendimentos:</td>
            <td style="color: blue;">R$: {{number_format($resultado[0]->total,2,',','.')}}</td>
        </tr>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalRVD01" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Rendimentos</h5>
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
                        @foreach($resultadoRendimentos as $rr)
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
    $(".clickable-row").click(function() {
    $('#modalRVD01').modal('toggle');
    $('#modalRVD01').modal('show');

});
</script>