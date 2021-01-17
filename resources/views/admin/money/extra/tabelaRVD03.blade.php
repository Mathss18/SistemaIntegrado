<table class="table table-striped table-borderless table-sm">
    <thead>
    </thead>
    <tbody>
        @if(($resultado[0]->total-$totalDespesa) > 0)
        <tr>
            <td style="color: black; width: 25%"><b>Total:</b></td>
            <td style="color: blue; width: 25%">R$: {{number_format(($resultado[0]->total-$totalDespesa),2,',','.')}}</td>
        </tr>
        @else
        <tr>
            <td style="color: black; width: 25%"><b>Total:</b></td>
            <td style="color: red; width: 25%">R$: {{number_format(($resultado[0]->total-$totalDespesa),2,',','.')}}</td>
        </tr>
        @endif
    </tbody>
</table>
