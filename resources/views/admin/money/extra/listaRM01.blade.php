<div>
    <h4>Flex-Mol</h4>
    @foreach($totaisGastos as $tg)
    @if($tipos[$loop->index]->banho == 'Arame')
    <li class="list-group-item">Saída {{$tipos[$loop->index]->banho}} ➔ <b style="color: red;">R$: {{number_format($tg, 2, ',', '.')}}</b></li>
    @endif
    @endforeach
    <li class="list-group-item">Entrada Arame ➔ <b style="color: green;">R$: {{number_format($totalAdquiridoFM, 2, ',', '.')}}</b></li>
</div>