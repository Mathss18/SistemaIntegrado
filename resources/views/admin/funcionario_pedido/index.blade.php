@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/fileInput.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
@stop

@section('js')
<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="{{ asset('js/dropdownFornecedor.js') }}"></script>
<script src="{{ asset('js/clickTabelaFuncionarioPedido.js') }}"></script>

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
        <h6>Meus Pedidos</h6>
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
                    <th scope="col" style="display:none">Desenho</th>
                </tr>
            </thead>
            <tbody>
                @foreach($funcionarioPedido as $fp)
                <tr data-toggle="modal" data-target="#ModalPergunta">
                    <td style="display:none">{{$fp->ID_funcionario_pedido}}</td>
                    <td>{{$fp->OF}}</td>
                    <td>{{$fp->codigo}}</td>
                    <td>{{$fp->data_pedido}}</td>
                    <td>{{$fp->data_entrega}}</td>
                    <td>{{$fp->tipo}}</td>
                    <td>{{$fp->quantidade}}</td>
                    <td>{{$fp->cliente}}</td>
                    <td style="display:none">{{$fp->path_desenho}}</td>
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
                <h4>Deseja dar Baixa?</h4>
                <form method="POST" action="funcionarioPedido/baixa">
                {!! method_field('POST') !!}
                {!! csrf_field() !!}
                    <div class="form-group">
                        <label style="display:none">ID<input id="iptID" class="form-control " type="number" name="ID_funcionario_pedido"></label>
                        @if($nivelFunc == 'Gerente')
                        <hr>
                        <input required value="" style="display:none" name="ID_fornecedor" id="ID_fornecedor" type="text" class="typeahead form-control " style="margin:0px auto;width:370px;">
                        <label>Fornecedor<br><input required value="" class="typeahead form-control" id="ttexto" style="margin:0px auto;width:350px;" type="text"></label>
                        <label>Nota<input required id="iptNota" class="form-control " type="text" name="nota"></label>
                        @endif
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="status" value="Fechado" class="btn btn-outline-success">Dar BAIXA</button>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#ModalDesenho" data-dismiss="modal">Ver Desenho</button>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#ModalSaida" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="ModalDesenho" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" id="teste">
    <div class="modal-content" id="teste2">
        <div class="modal-body" height="800" align="center">
            <div class="form-group">
                    <label style="display:none">ID<input id="iptID2" class="form-control " type="text" value="{{url('storage/Desenhos/')}}"></label>
                </div>
            <iframe  id="iframe" align="middle"  width="600" height="610" style="border: none;"></iframe >
        </div>
    </div>
  </div>
</div>
@stop