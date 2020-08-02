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
    $(document).ready(function() {
        $('#tableDT').DataTable({
            "order": [],
            "language": {
            url: '../../js/traducao.json',
            decimal: ",",
        },
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

@section('content')
@if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {!! \Session::get('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    </div>
@endif
@if (\Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {!! \Session::get('error') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-end">
        <h6>Gestão de Pedidos</h6>
        <a href="{{route('pedido.create')}}" class="btn btn-success">
            <span class="glyphicon glyphicon-plus"></span>
            Cadastrar Novo Pedido
        </a>

    </div>
    <div class="card-body">
        <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
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
                <tr class='clickable-row' data-href="{{route('pedido.edit',$pedido->ID_pedido)}}">
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

<!-- Modal Pergunta -->
<div class="modal fade" id="ModalPergunta" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-target=".bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color:orange;" class="modal-title" id="TituloModalCentralizadoPergunta">Escolha Uma Opção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Deseja Editar ou Excluir este Pedido?</h4>
            </div>
            <div class="modal-footer">
                <a ><button type="button" class="btn btn-outline-success">Editar</button></a>
                <a ><button type="button" class="btn btn-outline-danger">Exluir</button></a>
            </div>
            </form>
        </div>

    </div>
</div>
</div>
@stop