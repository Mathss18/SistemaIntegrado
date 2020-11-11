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
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<link rel="stylesheet" href="{{ asset('css/fileInput.css') }}">
@stop

<!------ Inclui arquivos JS *no fim*---------->

@if(isset($pedido))
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
<script src="{{ asset('js/dropdownProdutoCliOrc.js') }}"></script>
<script src="{{ asset('js/fileInput.js') }}"></script>
<script src="{{ asset('js/addOrca.js') }}"></script>
@if($firma == 'MF')
<script>
    $(document).ready(function() {
        var path = document.getElementById('codigo').value;
        var fileInput = document.getElementById('file');
        fileInput.setAttribute('value', path)
        console.log('oi');

    });
</script>
@endif


@stop
@else
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
<script src="{{ asset('js/dropdownProdutoCliOrc.js') }}"></script>
<script src="{{ asset('js/fileInput.js') }}"></script>
<script src="{{ asset('js/addOrca.js') }}"></script>
@stop
@endif

<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <hr>
        </div>
        <div class="col-auto">Informações de Orçamento</div>
        <div class="col">
            <hr>
        </div>
    </div>

    @if(!isset($deletar) && !isset($pedido))
    <form id="orcamentoForm" class="form-horizontal" method='POST' data-route="{{route('orcamento.adicionar')}}" enctype="multipart/form-data">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        @elseif(!isset($deletar) && isset($pedido))
        <form class="form-horizontal" method='POST' action="{{route('pedido.update',$pedido->ID_pedido)}}" enctype="multipart/form-data">
            {!! method_field('PUT') !!}
            {!! csrf_field() !!}
            @endif
            <div class="row">
                <div class="form-group col-md-5">
                    <label for="ID_cliente">Nome Cliente</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-address-card"></i>
                        </div>
                        <input required value="{{$cliente['ID_cliente'] ?? '' }}" style="display:none" name="ID_cliente" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:370px;">
                        <input required value="{{$cliente['nome'] ?? '' }}" class="typeahead form-control" id="ttexto" style="margin:0px auto;width:350px;" type="text">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="cod_orcamento">N° de Orçamento</label>
                    <div class="input-group">
                        <div class="input-group-addon ">
                            <i class="fa fa-bookmark"></i>
                        </div>
                        @if($firma == 'FM')
                        <input required readonly id="cod_orcamento" name="cod_orcamento" type="text" class="form-control" value="{{$pedido->OF ?? $codigoOrca->cod_orcamento+1}}">
                        @else
                        <input required readonly id="cod_orcamento" name="cod_orcamento" type="text" class="form-control" value="{{$pedido->OF ?? $codigoOrca->cod_orcamento+1}}">
                        @endif
                    </div>
                </div>
                @if(!isset($pedido))
                <div class="form-group col-md-3">
                    <label>Produtos:</label>
                    <div class="input-group">
                        <h5 id="contadorProd" style="color: red">0</h5>
                    </div>
                </div>
                @endif
            </div>



            <div class="row">
                <div class="form-group col-md-3">
                    <label for="data">Data Orçamento</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input required id="data" name="data" type="date" class="form-control" value="{{$pedido->data_pedido ?? '' }}">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="cond_pagto">Condição de pagamento</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <input required id="cond_pagto" name="cond_pagto" type="text" class="form-control" value="{{$pedido->data_pedido ?? '' }}">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="prazo_entrega">Prazo de Entrega</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-clock"></i>
                        </div>
                        <input required  id="prazo_entrega" name="prazo_entrega" type="text" class="form-control" value="{{$pedido->data_pedido ?? '' }}">
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="pedidoCli">Pedido Cliente</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fas fa-user"></i>
                        </div>
                        <input id="pedidoCli" name="pedidoCli" type="text" class="form-control" value="{{$pedido->pedidoCli ?? '' }}">
                    </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-4">
                    <hr>
                </div>
                <div class="col-auto">Informações de Produção</div>
                <div class="col">
                    <hr>
                </div>
            </div>

            <div class="row">


                <div class="form-group col-md-2">
                    <label for="codigo">Código</label>
                    <div class="input-group">
                        <input value="{{$pedido['path_desenho'] ?? '' }}" style="display:none" name="path_desenho" id="codigo" type="text" class="typeahead form-control path" style="margin:0px auto;width:370px;">
                        <input id="ID_produto_cliente" name="ID_produto_cliente" style="display:none" type="text"  class="form-control" value="{{$pedido->ID_produto_cliente  ?? '' }}">
                        <input value="{{$pedido->codigo ?? '' }}" class="typeahead form-control" name="codigo" id="ttexto1" style="margin:0px auto;width:150px;" type="text">
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="qtde_prod">Quantidade/Quilos</label>
                    <input min="0" required id="qtde_prod" name="qtde_prod" type="number" min="0" step="any" class="form-control" value="{{$pedido->quantidade ?? '' }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="obs">Observações</label>
                    <div class="input-group">
                        <textarea name="obs" id="obs" cols="80" rows="2"></textarea>
                    </div>
                </div>

                <div class="form-group" style="position: absolute; top: 340px; right: 150px; border: 2px solid black;">
                    <iframe src="{{url('storage/Desenhos/semImagem2.png')}}" id="fotoProduto" style="width: 190px; height: 300px"></iframe>
                </div>


            </div>
            @if(!isset($pedido))
            <div class="row">


                <div class="form-group col-md-2">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalListaProdutos">Lista de produtos</button>
                </div>

                <div class="form-group col-md-1">
                    <div>
                        <button name="submit" type="submit" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Produto</button>
                    </div>
                </div>

            </div>
            @endif
            @if(isset($pedido))
            <div class="row">
                <div class="form-group col-md-1">
                    <button name="submit" class="btn btn-primary" type="submit">Confirmar</button>
                </div>
            </div>
            @else
            <div class="row">
                <div class="form-group col-md-1">
                    <a readonly href="{{route('orcamento.mostrarPronto',$codigoOrca->cod_orcamento+1)}}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>
                        Finalizar Orçamento
                    </a>
                </div>
            </div>
            @endif
        </form>
</div>

<div class="modal fade" id="ModalListaProdutos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Lista de Produtos deste Orçamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table  class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">N° Orçamento</th>
                            <th scope="col">Código</th>
                            <th scope="col">Quantidade</th>
                        </tr>
                    </thead>
                    <tbody id="tblProd">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@stop