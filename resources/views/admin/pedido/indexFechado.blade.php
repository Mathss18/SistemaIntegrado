@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(document).ready( function () {
    $('#tableDT').DataTable({
        "order": [],
        url: '../js/traducao.json',
        decimal: ",",
        "language": {
            url: '../../js/traducao.json',
            decimal: ",",
        },
    });
    
} );
</script>
@stop

@section('content')

        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-end">
            <h6>Gestão de Pedidos</h6>

            </div>
            <div class="card-body">
                <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                            <th scope="col" style="display:none">ID</th>
                            <th scope="col">OF</th>
                            <th scope="col">Código</th>
                            <th scope="col">Data Pedido</th>
                            <th scope="col">Data Entrega</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Qtde</th>
                            <th scope="col">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                        <tr data-toggle="modal" data-target="#ModalPergunta">
                            <td style="display:none">{{$pedido->ID_pedido}}</td>
                            <td>{{$pedido->OF}}</td>
                            <td>{{$pedido->codigo}}</td>
                            <td>{{$pedido->data_pedido}}</td>
                            <td>{{$pedido->data_entrega}}</td>
                            <td>{{$pedido->tipo}}</td>
                            <td>{{$pedido->quantidade}}</td>
                            <td>{{$pedido->nome}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

@stop
