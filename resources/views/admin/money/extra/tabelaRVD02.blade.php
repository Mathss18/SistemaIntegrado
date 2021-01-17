<table class="table table-striped table-borderless table-sm">
    <thead>
        <tr>
            <th scope="col-md-2">Categoria de despesas</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 1; $i < sizeof($resultado); $i++) <tr>
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