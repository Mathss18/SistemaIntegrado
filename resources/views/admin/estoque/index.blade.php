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
    <script src="{{ asset('js/clickTabelaEstoque.js') }}"></script>
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
        <h6>Gestão de Produtos</h6>
        <!--
        <a href="{{route('estoque.create')}}" class="btn btn-success">
            <span class="glyphicon glyphicon-plus"></span>
            Cadastrar Novo Produto
        </a>
        -->

    </div>
    <div class="card-body">
        <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col" style="display:none">ID</th>
                    <th scope="col" style="display:none">Preço</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Utilização</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estoques as $estoque)
                <tr data-toggle="modal" data-target="#ModalPergunta">
                    <td style="display:none">{{$estoque->ID_produto}}</td>
                    <td style="display:none">{{$estoque->valor_unitario}}</td>
                    <td>{{$estoque->nome}}</td>
                    <td>{{$estoque->qtde}}</td>
                    <td>{{$estoque->utilizacao}}</td>
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
                <h4>Deseja fazer uma?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalEntrada" data-dismiss="modal">Entrada</button>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#ModalSaida" data-dismiss="modal">Saida</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Modal Entrada -->
<div class="modal fade" id="ModalEntrada" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-target=".bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color:green;" class="modal-title" id="TituloModalCentralizado">Entrada de Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('entradaProduto.store')}}">
                {!! method_field('POST') !!}
                {!! csrf_field() !!}
                    <div class="form-group">
                        <label style="display:none">ID<input id="iptID" class="form-control " type="number" name="ID_produto"></label>
                        <label>Quantidade<input required min="0" id="iptQtde" class="form-control " type="number" step="any" name="qtde"></label>
                        <label>Preço<input required step="any" id="iptDoc" class="form-control " type="number" name="valor_unitario"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                        <button class="btn btn-outline-success" type="submit" name="submit">Adicionar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



<!-- Modal Saida -->
<div class="modal fade" id="ModalSaida" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-target=".bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color:red;" class="modal-title" id="TituloModalCentralizadoDel">Saida de Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('saidaProduto.store')}}">
                {!! method_field('POST') !!}
                {!! csrf_field() !!}
                    <div class="form-group">
                        <label style="display:none">ID<input id="iptIDDel" class="form-control " type="number" name="ID_produto"></label>
                        <label>Quantidade<input required min="0" step="any" id="iptQtdeDel" class="form-control " type="number" name="qtde"></label>
                        <label>Preço<input required step="any" min="0" step="any" id="iptDocDel" class="form-control " type="number" name="valor_unitario"></label>
                        <label>Destino
                        <select required id="banho" name="banho" class="custom-select">
                            @if($firma == 'MF')
                            <option value="COBRE 1">COBRE 1</option>
                            <option value="COBRE 2">COBRE 2</option>
                            <option value="NIQUEL 1">NIQUEL 1</option>
                            <option value="NIQUEL 2">NIQUEL 2</option>
                            <option value="CROMO">CROMO</option>
                            <option value="FOSFATO">FOSFATO</option>
                            <option value="ROTATIVO 1">ROTATIVO 1</option>
                            <option value="ROTATIVO 2">ROTATIVO 2</option>
                            <option value="ROTATIVO 3">ROTATIVO 3</option>
                            <option value="PARADO">PARADO</option>
                            <option value="TRATAMENTO E.T.E">TRATAMENTO E.T.E</option>
                            <option value="ALCALINO">ALCALINO</option>
                            @endif
                            <option value="MATERIAL P/ MOLA">MATERIAL P/ MOLA</option>
                    </select>
                    </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                        <button class="btn btn-outline-success" type="submit" name="submit">Retirar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@stop