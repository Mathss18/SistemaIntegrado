@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
@stop

@section('js')
    <script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#tableDT').DataTable({
            "language": {
                url: '../js/traducao.json',
                decimal: ",",
            }
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
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-end">
        <h6>Gestão de Produtos de Clientes</h6>
        <a href="{{route('produto_cliente.create')}}" class="btn btn-success">
            <span class="glyphicon glyphicon-plus"></span>
            Cadastrar Novo Produto
        </a>

    </div>
    <div class="card-body">
        <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Código Fabricação</th>
                    <th scope="col">Descrição do Produto</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Cliente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos as $produto)
                <tr class='clickable-row' data-href="{{route('produto_cliente.edit',$produto->ID_produto_cliente)}}">
                    <td>{{$produto->ID_produto_cliente}}</td>
                    <td>{{$produto->cod_fabricacao}}</td>
                    <td>{{$produto->descricao}}</td>
                    <td>{{$produto->preco_venda}}</td>
                    <td>{{$produto->nome}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop