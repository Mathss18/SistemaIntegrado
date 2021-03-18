<div>
    <h4>Metal-Flex</h4>
    @foreach($totaisGastos as $tg)
    @if($tipos[$loop->index]->banho != 'Arame')
    <li class="list-group-item">{{$tipos[$loop->index]->banho}} ➔ <b style="color: red;">R$: {{number_format($tg, 2, ',', '.')}}</b></li>
    @endif
    @endforeach
    <li class="list-group-item">Entrada de Produtos Químicos ➔ <b style="color: green;">R$: {{number_format($totalAdquiridoMF, 2, ',', '.')}}</b></li>

</div>