@extends('adminlte::page')

@section('title', 'Produto de Fornecedores')

@section('content_header')
@stop

@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<link rel="stylesheet" href="{{ asset('css/fileInput.css') }}">
@stop


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="{{ asset('js/dropdownFornecedor.js') }}"></script>
<!--<script src="{{ asset('js/codFabricacaoProdCliente.js') }}"></script>-->
@if(!isset($produto))
<script>
    
</script>
@else
<script>
    $("#grupo>option[value={{$produto->grupo}}]").attr("selected", true);
</script>
@endif
@stop
<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Informações de Produto</div>
        <div class="col">
            <hr>
        </div>
    </div>

    @if(!isset($produto))
    <form class="form-horizontal" method='POST' action="{{route('produto_fornecedor.store')}}" enctype="multipart/form-data">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        @elseif(isset($fornecedor))
        <form class="form-horizontal" method='POST' action="{{route('produto_fornecedor.update',$produto->ID_produto_fornecedor)}}" enctype="multipart/form-data">
            {!! method_field('PUT') !!}
            {!! csrf_field() !!}
            @endif
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="cod_fabricacao">Cód de Fabri.</label>
                    <div class="input-group">
                        <input required id="cod_fabricacao" name="cod_fabricacao" type="text" class="form-control" value="{{$produto->cod_fabricacao ?? '' }}">
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="ID_fornecedor">Fornecedor</label>
                    <div class="input-group">
                        <input required value="{{$fornecedor['ID_fornecedor'] ?? '' }}" style="display:none" name="ID_fornecedor" id="ID_fornecedor" type="text" class="typeahead form-control " style="margin:0px auto;width:360px;">
                        <input required value="{{$fornecedor['nome'] ?? '' }}" class="typeahead form-control" id="ttexto" style="margin:0px auto;width:390px;" type="text">
                    </div>
                </div>
                

                

                
            </div>

            <div class="row">

            <div class="form-group col-md-5">
                    <label for="descricao">Descrição</label>
                    <div class="input-group">
                        <input required id="descricao" name="descricao" type="text" class="form-control" value="{{$produto->descricao ?? '' }}">
                    </div>
                </div>


                <div class="form-group col-md-1">
                    <label for="unidade_saida">Unidade</label>
                    <div class="input-group">
                        <input required id="unidade_saida" name="unidade_saida" type="text" class="form-control" value="{{$produto->unidade_saida ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="row">

            <div class="form-group col-md-2">
                    <label for="grupo">Grupo</label>
                    <div class="input-group">
                        <select required id="grupo" name="grupo" class="form-control" value="{{$produto->grupo ?? '' }}">
                            <option value="EPI">EPI</option>
                            <option value="Produto_Quimico">Produto Quimico</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="preco_venda">Preço Venda</label>
                    <input required id="preco_venda" name="preco_venda" type="number" step="any" class="form-control" value="{{$produto->preco_venda ?? '' }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="obs">Observação</label>
                    <textarea id="obs" name="obs" class="form-control">{{$produto->obs ?? '' }}</textarea> 
                </div>

                <div class="form-group col-md-1">
                    <label>Ultima Atualização: <a style="color: red;">{{$produto->last_preco ?? ''}}</a></label>
                </div>

                
            </div>
            @if(isset($produto))
            <div class="form-group" style="position: absolute; top: 110px; right: 130px; border: 2px solid black;">
                    <embed
                     src="{{url('storage/Desenhos/'.$produto['path_imagem'])}}" alt="" style="width: 190px; height: 300px"></embed>
            </div>
            @else
            <div class="form-group" style="position: absolute; top: 110px; right: 130px; border: 2px solid black;">
                    <embed src="{{url('storage/Desenhos/semImagem.png')}}" alt="" style="width: 190px; height: 300px"></embed>
            </div>
            @endif
            <div class="form-group col-md-2" style="position: absolute; top: 400px; right: 113px;" >
                <label for="path_imagem"></label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input required name="path_imagem" type="file" class="custom-file-input" id="myInput" aria-describedby="myInput">
                            <label class="custom-file-label" for="myInput"></label>
                        </div>
                    </div>
                </div>

            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary">Confirmar</button>
            </div>

        </form>
        
</div>
@stop