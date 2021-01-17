<table class="table table-striped table-borderless table-sm">
    <thead>
        <tr>
            <th scope="col-md-2">Categoria de Rendimento</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        <tr style="height: 1px;">
            <td style="width: 25%">{{strtoupper($resultado[0]->tipoFav)}}</td>
            <td style="width: 25%">R$: {{number_format($resultado[0]->total,2,',','.')}}</td>
        </tr>
        <tr>
            <td style="color: blue;">Total de rendimentos:</td>
            <td style="color: blue;">R$: {{number_format($resultado[0]->total,2,',','.')}}</td>
        </tr>
    </tbody>
</table>