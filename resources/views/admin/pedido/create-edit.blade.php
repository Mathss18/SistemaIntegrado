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
<script src="{{ asset('js/dropdownProdutoCli.js') }}"></script>
<script src="{{ asset('js/fileInput.js') }}"></script>
<script>
    $("#tipo>option[value={{$pedido->tipo}}]").attr("selected", true);
</script>
@foreach($funcionario_pedido as $fp)
<script>
    $("#Cmbfuncionario>option[value={{$fp->ID_funcionario}}]").attr("selected", true);
</script>
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

@endforeach
@stop
@else
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
<script src="{{ asset('js/dropdownProdutoCli.js') }}"></script>
<script src="{{ asset('js/fileInput.js') }}"></script>
<script src="{{ asset('js/addProd.js') }}"></script>
@stop
@endif

<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <hr>
        </div>
        <div class="col-auto">Informações da Ordem de Serviço</div>
        <div class="col">
            <hr>
        </div>
    </div>

    @if(!isset($deletar) && !isset($pedido))
    <form id="pedidoForm" class="form-horizontal" method='POST' data-route="{{route('pedido.adicionar')}}" enctype="multipart/form-data">
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
                    <label for="OF">OF</label>
                    <div class="input-group">
                        <div class="input-group-addon ">
                            <i class="fa fa-envelope"></i>
                        </div>
                        @if($firma == 'FM')
                        <input required id="OF" name="OF" type="text" class="form-control" value="{{$pedido->OF ?? $codigo}}">
                        @else
                        <input required id="OF" name="OF" type="text" class="form-control" value="{{$pedido->OF ?? '' }}">
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
                <div class="form-group col-md-5">
                    <label for="data_pedido">Data Pedido</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-wpforms"></i>
                        </div>
                        <input required readonly id="data_pedido" name="data_pedido" type="date" class="form-control" value="{{$pedido->data_pedido ?? $hoje }}">
                    </div>
                </div>

                <div class="form-group col-md-5">
                    <label for="data_entrega">Data Entrega</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-address-book"></i>
                        </div>
                        <input required id="data_entrega" name="data_entrega" type="date" class="form-control" value="{{$pedido->data_entrega ?? '' }}">
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
                        <input value="{{$pedido->codigo ?? '' }}" class="typeahead form-control" name="codigo" id="ttexto1" style="margin:0px auto;width:150px;" type="text">
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="quantidade">Quantidade/Quilos</label>
                    <input min="0" required id="quantidade" name="quantidade" type="number" min="0" step="any" class="form-control" value="{{$pedido->quantidade ?? '' }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="tipo">Tipo</label>
                    <select required id="tipo" name="tipo" class="custom-select" value="{{$pedido->tipo ?? '' }}">
                        <option value="Molas⠀Niqueladas">Molas Niqueladas</option>
                        <option value="Ponteiras">Ponteiras</option>
                        <option value="Ganchinhos">Ganchinhos</option>
                        <option value="Diversos">Diversos</option>
                        <option value="Bicromatizada">Bicromatizada</option>
                        <option value="Trivalente">Trivalente</option>
                        <option value="Zincada">Zincada</option>
                        <option value="Aramado">Aramado</option>
                        <option value="Oleada">Oleada</option>
                        <option value="Inox⠀302">Inox 302</option>
                        <option value="Inox⠀304">Inox 304</option>
                        <option value="Fosfato⠀de⠀Zinco">Fosfato de Zinco</option>
                        <option value="Fosfato⠀de⠀Manganes">Fosfato de Manganês</option>
                        <option value="Pintura⠀KTL">Pintura KTL</option>
                        <option value="Sem⠀Banho">Sem Banho</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="funcionario">Funcionário</label>
                    <div>
                        <select required multiple="multiple" id="Cmbfuncionario" name="funcionario[]" class="custom-select">
                            @foreach($funcionarios as $funcionario)
                            <option value="{{$funcionario->ID_funcionario}}">{{$funcionario->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>




                @if(!isset($pedido) && $firma=='FM')
                <div class="form-group" style="position: absolute; top: 320px; right: 190px; border: 2px solid black;">
                    <iframe src="{{url('storage/Desenhos/semImagem2.png')}}" id="fotoProduto" style="width: 190px; height: 300px"></iframe>
                </div>
                @else
                <div class="form-group" style="display:none; position: absolute; top: 320px; right: 190px; border: 2px solid black;">
                    <iframe src="{{url('storage/Desenhos/semImagem2.png')}}" id="fotoProduto" style="width: 190px; height: 300px"></iframe>
                </div>
                <div class="form-group col-md-2">
                    <label for="path_desenho">Desenho</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="path_desenho" id="file" type="file" class="custom-file-input path" id="myInput" aria-describedby="myInput">
                            <label class="custom-file-label" for="myInput"></label>
                        </div>
                    </div>
                </div>
                @endif

                @isset($pedido['path_desenho'])
                <div class="form-group col-md-1">
                    <label>Visualizar</label>
                    <div class="input-group col">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalDesenho">Abrir Desenho</button>
                        @isset($pedido['path_desenho'])
                        <div class="form-group col-md-1 pt-2">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalFuncAberto">Quem Falta?</button>

                        </div>
                        @endisset
                    </div>
                </div>
                @endisset

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
                    <a readonly href="{{route('pedido.aberto2')}}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>
                        Finalizar OF
                    </a>
                </div>
            </div>
            @endif
        </form>
</div>

@isset($pedido['path_desenho'])
<div id="ModalDesenho" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="teste">
        <div class="modal-content" id="teste2">
            <div class="modal-body" align="center">
                <embed src="{{url('storage/Desenhos/'.$pedido['path_desenho'])}}" align="middle" width="600" height="600" style="border: none;"></embed>
            </div>
        </div>
    </div>
</div>
@endisset

@isset($funcAberto)
<div class="modal fade" id="ModalFuncAberto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Funcionários que ainda não deram Baixa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Nome do Funcionário</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($funcAberto as $fa)
                        <tr>
                            <td>{{$fa->nome}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endisset
<div class="modal fade" id="ModalListaProdutos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Lista de Produtos desta OF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table  class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">OF</th>
                            <th scope="col">Código</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Tipo</th>
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