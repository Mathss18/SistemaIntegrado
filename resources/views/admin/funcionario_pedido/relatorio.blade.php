@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
@stop



<!------ Inclui arquivos CSS *no inicio* ---------->
@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
@stop

<!------ Inclui arquivos JS *no fim*---------->

@section('js')
<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"></script>
<script>
    $(document).ready(function() {
        $('.tableDT').DataTable({
            "language": {
                url: '../../js/traducao.json',
                decimal: ",",
            },
            paging: false
        });
    });
</script>
<script>
    $(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>
@stop


<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            
            @if($aproveitamento <= 100.0 && $aproveitamento >= 80.0)
            <h4 style="color:green;">Relatório de Desempenho {{$aproveitamento}}% <b style="color:black;">{{$nomeFuncionario}}</b></h4>
            @elseif($aproveitamento <= 79.0 && $aproveitamento >= 50.0)
            <h4 style="color:orange;">Relatório de Desempenho {{$aproveitamento}}% <b style="color:black;">{{$nomeFuncionario}}</b></h4>
            @else
            <h4 style="color:red;">Relatório de Desempenho {{$aproveitamento}}% <b style="color:black;">{{$nomeFuncionario}}</b></h4>
            @endif
<hr>
        </div>

        <div class="col-md-2">
            <h6>De: {{$data_inicio_reform}} <br>Até: {{$data_fim_reform}}</h6>
        </div>
    </div>

    @if($pedidosFechadosAdiantados->count() > 0)
    <div class="row">
        <div class="card-body">
            <table class="tableDT table table-striped table-bordered" style="width:100%">
                <h5 style="color:green;">Pedidos Adiantados ou na Data: {{$pedidosFechadosAdiantados->count()}}<h5>
                        <thead>
                            <tr>
                                <th scope="col">OF</th>
                                <th scope="col">Código</th>
                                <th scope="col">Data Pedido</th>
                                <th scope="col">Data Entrega</th>
                                <th scope="col">Data de Baixa</th>
                                <th scope="col">Dias De Adianto</th>
                                <th scope="col">Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidosFechadosAdiantados as $pfa)
                            <tr>
                                <td>{{$pfa->OF}}</td>
                                <td>{{$pfa->codigo}}</td>
                                <td>{{$pfa->data_pedido}}</td>
                                <td style="font-weight: bold; color:green;">{{$pfa->data_entrega}}</td>
                                <td style="font-weight: bold; color:green;">{{$pfa->data_baixa}}</td>
                                <td style="color:green;">{{$pfa->diferenca}}</td>
                                <td>{{$pfa->nome}}</td>
                            </tr>
                            @endforeach
                        </tbody>
            </table>
        </div>
    </div>
    @else
        @if($pedidosFechadosAdiantados->count() <= 0 && ($pedidosAbertosAtrasados->count() > 0 || $pedidosFechadosAtrasados->count() > 0))
            <div class="alert alert-danger alert-dismissible fade show">
                <h5>Atenção! Você não tem pedidos <b>Adiantados</b> ou <b>Na data</b></h5>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endif

        @if($pedidosAbertosAtrasados->count() > 0)
        <div class="row">
            <div class="card-body">
                <table class="tableDT table table-striped table-bordered" style="width:100%">
                    <h5 style="color:red;">Pedidos Atrasados - Abertos: {{$pedidosAbertosAtrasados->count()}}<h5>
                            <thead>
                                <tr>
                                    <th scope="col">OF</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Data Pedido</th>
                                    <th scope="col">Data Entrega</th>
                                    <th scope="col">Data de Hoje</th>
                                    <th scope="col">Dias De Atraso</th>
                                    <th scope="col">Cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidosAbertosAtrasados as $paa)
                                <tr>
                                    <td>{{$paa->OF}}</td>
                                    <td>{{$paa->codigo}}</td>
                                    <td>{{$paa->data_pedido}}</td>
                                    <td style="font-weight: bold; color:red;">{{$paa->data_entrega}}</td>
                                    <td style="font-weight: bold; color:red;">{{$paa->data_controle}}</td>
                                    <td style="color:red;">{{$paa->diferenca}}</td>
                                    <td>{{$paa->nome}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-success alert-dismissible fade show">
            <h5>Parabéns! Você não tem pedidos <b>Abertos</b> que estejam atrasados.</h5>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if($pedidosFechadosAtrasados->count() > 0)
        <div class="row">
            <div class="card-body">
                <table class="tableDT table table-striped table-bordered" style="width:100%">
                    <h5 style="color:orange;">Pedidos Atrasados - Fechados: {{$pedidosFechadosAtrasados->count()}}<h5>
                            <thead>
                                <tr>
                                    <th scope="col">OF</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Data Pedido</th>
                                    <th scope="col">Data Entrega</th>
                                    <th scope="col">Data de Baixa</th>
                                    <th scope="col">Dias De Atraso</th>
                                    <th scope="col">Cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidosFechadosAtrasados as $pfa)
                                <tr>
                                    <td>{{$pfa->OF}}</td>
                                    <td>{{$pfa->codigo}}</td>
                                    <td>{{$pfa->data_pedido}}</td>
                                    <td style="font-weight: bold; color:red;">{{$pfa->data_entrega}}</td>
                                    <td style="font-weight: bold; color:red;">{{$pfa->data_baixa}}</td>
                                    <td style="color:red;">{{$pfa->diferenca}}</td>
                                    <td>{{$pfa->nome}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-success alert-dismissible fade show">
            <h5>Parabéns! Você não tem pedidos <b>Fechados</b> que estejam atrasados.</h5>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

</div>
@stop