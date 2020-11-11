@extends('adminlte::page')

@section('title', 'Nota Fiscal')

@section('content_header')
@stop

@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@stop


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="{{ asset('js/totalProdutosNfeMf.js') }}"></script>

@stop
<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Informações dos Produtos</div>
        <div class="col">
            <hr>
        </div>
    </div>

    <form class="form-horizontal" method='POST' action="{{route('nfemf.postEmitirPasso2')}}">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
            <div class="row">
                <div class="card-body">
                    <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Código Fabricação</th>
                                <th scope="col">Descrição do Produto</th>
                                <th scope="col">CFOP</th>
                                <th scope="col">Unidade</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Preço</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($produtos as $produto)
                            <tr id="{{$loop->index+1}}">
                                <td><input type="hidden" name="codFabriProd[]" value='{{$produto->cod_fabricacao}}' type="text">{{$produto->cod_fabricacao}}</td>
                                <td style="width:370px"><input class="form-control" name="descricaoProd[]" value ='{{$produto->descricao}}' type="text"></td>
                                <td style="width:100px"><input class="form-control" type="text" name="cfop[]" value ="{{$nfe1['natOp']}}"  type="text"></td>
                                <td style="width:100px"><input class="form-control" type="text" name="unidade[]" value ='{{$produto->unidade_saida}}'  type="text"></td>
                                <td><input class="form-control" step='0.01' type="number" name="quantidade[]" value ='{{$quantidades[$loop->index]}}' class="qtde" type="text"></td>
                                <td><input class="form-control" step='0.0001' type="number" name="precoProd[]" value ='{{$produto->preco_venda}}' class="preco" type="text"></td>
                                <td style="display: none;" ><input type="hidden" name="ncm[]" value ='{{$produto->ncm}}' type="text">{{$produto->ncm}}</td>
                                <td><a onclick="deletaRow(this);" href="#"><i class="fas fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td style="visibility: hidden;"></td>
                                <td style="visibility: hidden;"></td>
                                <td style="visibility: hidden;"></td>
                                <td style="visibility: hidden;"></td>
                                <td class="total" style="color: crimson"><input type="hidden" name="totalQtde" id="inputTotal" value =''><a id="totalProd"></a></td>
                                <td class="total" style="color: crimson"><input type="hidden" name="total" id="inputTotalProd" value =''><a id="total"></a></td>
                                <td style="visibility: hidden;"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="form-group">
                <a href="{{route('nfemf.emitirPasso1')}}" class="btn btn-secondary">Voltar Passo 1</a>
                <button name="submit" type="submit" class="btn btn-primary">Próximo</button>
            </div>

        </form>
        <br>
</div>
@stop