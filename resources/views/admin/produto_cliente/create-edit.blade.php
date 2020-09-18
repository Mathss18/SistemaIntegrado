@extends('adminlte::page')

@section('title', 'Produto de Clientes')

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
<script src="{{ asset('js/dropdown.js') }}"></script>
<!--<script src="{{ asset('js/codFabricacaoProdCliente.js') }}"></script>-->
@if(!isset($produto))
<script>
    
</script>
@else
<script>
    $("#grupo>option[value={{$produto->grupo}}]").attr("selected", true);
    $("#cfop>option[value={{$produto->cfop}}]").attr("selected", true);
    $("#imposto>option[value={{$produto->imposto}}]").attr("selected", true);
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
    <form class="form-horizontal" method='POST' action="{{route('produto_cliente.store')}}" enctype="multipart/form-data">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        @elseif(isset($cliente))
        <form class="form-horizontal" method='POST' action="{{route('produto_cliente.update',$produto->ID_produto_cliente)}}" enctype="multipart/form-data">
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
                    <label for="ID_cliente">Cliente</label>
                    <div class="input-group">
                        <input required value="{{$cliente['ID_cliente'] ?? '' }}" style="display:none" name="ID_cliente" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:360px;">
                        <input required value="{{$cliente['nome'] ?? '' }}" class="typeahead form-control" id="ttexto" style="margin:0px auto;width:350px;" type="text">
                    </div>
                </div>
                

                <div class="form-group col-md-2">
                    <label for="grupo">Grupo</label>
                    <div class="input-group">
                        <select required id="grupo" name="grupo" class="form-control" value="{{$produto->grupo ?? '' }}">
                            <option value="Mola">Mola</option>
                            <option value="Produto_Quimico">Produto Quimico</option>
                            <option value="Outros">Outros</option>
                        </select>
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

                <div class="form-group col-md-2">
                    <label for="ncm">NCM</label>
                    <div class="input-group">
                        <input required id="ncm" name="ncm" type="text" class="form-control" value="{{$produto->ncm ?? '' }}">
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
                <div class="form-group col-md-3">
                    <label for="imposto">Imposto</label>
                    <select required id="imposto" name="imposto" type="text" class="form-control" value="{{$produto->imposto ?? '' }}">
                        <option value="101">Imposto 101</option>
                        <option value="102">Imposto 102</option>
                        <option value="500">Imposto 500</option>
                        <option value="900">Imposto 900</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="cfop">CFOP</label>
                    <select required id="cfop" name="cfop" type="text" class="form-control" value="{{$produto->cfop ?? '' }}">
                        <option value="1201">1201 - NOTA ENTRADA</option>
                        <option value="2209">2209 - DEVOLUCAO DE MERCADORIA</option>
                        <option value="5101">5101-VENDA DENTRO DO ESTADO</option>
                        <option value="5902">5902 - RETORNO</option>
                        <option value="59025903">5902 / 5903 - RETORNO DE MERCADORIA</option>
                        <option value="5903">5903 - RETORNO DE MERC RECEBIDA IND NAO APLIC REFER PROCESSO</option>
                        <option value="5916">5916-RETORNO DE MERC OU BEM RECEBIDO P CONSERTO OU REPARO</option>
                        <option value="6101">6101 - VENDAS FORA DO ESTADO</option>
                        <option value="1551">COMPRA DE BEM P O ATIVO IMOBILIZADO</option>
                        <option value="1101">COMPRA PARA INDUSTRIALIZACAO OU PROD RURAL</option>
                        <option value="1410">DEV DE VENDA DE PROD DO ESTAB SUJ AO REG SUBT TRIB</option>
                        <option value="5411">DEVOLUCAO DE COMPRA P COM EM OP COM MERC SUJ AO REG SUBST TR</option>
                        <option value="5410">DEVOLUCAO DE COMPRA P IND DE MERC SUJ A SP</option>
                        <option value="1202">DEVOLUCAO DE VENDA DE MERC ADQ OU REC DE TERC</option>
                        <option value="2201">DEVOLUCAO DE VENDA DE PRODUCAO DO ESTABELECIMENTO</option>
                        <option value="5202">DEVOLUÇÃO DE COMPRA DE MERCADORIA</option>
                        <option value="6202">DEVOLUÇÃO DE COMPRAS FORA DO ESTADO (SAÍDA).</option>
                        <option value="5918">DEVOLUÇÃO DE MERC. RECEBIDA EM CONSIGNAÇÃO</option>
                        <option value="5201">DEVOLUÇÃO DE MERCADORIA</option>
                        <option value="5413">DEVOLUÇÃO DE MERCADORIA DESTINADA AO USO E CONSUMO ST</option>
                        <option value="6949">DEVOLUÇÃO PARA TROCA</option>
                        <option value="5124">INDUSTRIALIZACAO</option>
                        <option value="6124">INDUSTRIALIZAÇÃO</option>
                        <option value="5502">REMESSA COM FIM ESPECIFICO DE EXPORTAÇÃO</option>
                        <option value="5911">REMESSA DE AMOSTRA GRÁTIS</option>
                        <option value="5910">REMESSA DE BRINDES</option>
                        <option value="5923">REMESSA DE MERC POR ORDEM DE TERCEIRO E VENDA À ORDEM</option>
                        <option value="5912">REMESSA DE MERCADORIA P/ DEMONSTRAÇÃO</option>
                        <option value="5915">REMESSA DE MERCADORIA P/CONSERTO</option>
                        <option value="6915">REMESSA P/CONSERTO FORA DO ESTADO (SAÍDA)</option>
                        <option value="5905">REMESSA P/DEPOSITO FECHADO</option>
                        <option value="5901">REMESSA P/INDUSTRIALIZAÇÃO POR ENCOMENDA</option>
                        <option value="1949">RETORNO</option>
                        <option value="5906">RETORNO DE DEPOSITO FECHADO</option>
                        <option value="2949">RETORNO DE MERCADORIA NÃO ENTREGUE AO DESTINATÁRIO</option>
                        <option value="6916">RETORNO DE MERCADORIA OU BENS RECEBIDO P CONCERTO REPARO</option>
                        <option value="5913">RETORNO DE REMESSA PARA DEMONSTRAÇÃO</option>
                        <option value="6902">RETORNO DE REMESSA PARA INDUSTRIALIZACAO</option>
                        <option value="5921">Retorno de Embalagem</option>
                        <option value="5949">Retorno de Remessa para Retrabalho</option>
                        <option value="6551">VENDA DE ATIVO</option>
                        <option value="5551">VENDA DE ATIVO IMOBILIZADO</option>
                        <option value="5403">VENDA DE MER AD EM OP COM MERC SUJ A REG SUB TRIB</option>
                        <option value="5119">VENDA DE MERC ADQ DE TERCEIRO COM VENDA À ORDEM</option>
                        <option value="6119">VENDA DE MERC.POR CONTA E ORDEM DE TERCEIRO</option>
                        <option value="5401">VENDA DE PRODUTO COM ST</option>
                        <option value="6401">VENDA DE PRODUTO COM ST</option>
                        <option value="5102">VENDAS DENTRO DO ESTADO - 5102</option>
                        <option value="54055102">VENDAS DENTRO DO ESTADO / VENDAS ST</option>
                        <option value="6107">VENDAS FORA DO ESTADO</option>
                        <option value="6102">VENDAS FORA DO ESTADO (SAÍDA).</option>
                        <option value="5405">VENDAS ST / VENDAS DENTRO DO ESTADO - 5405</option>
                        <option value="6404">VENDAS ST FORA DO ESTADO</option>
                    </select>
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
            @if(isset($produto))
            <div class="form-group col-md-2" style="position: absolute; top: 400px; right: 113px;" >
                <label for="path_imagem"></label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="path_imagem" type="file" class="custom-file-input" id="myInput" aria-describedby="myInput">
                            <label class="custom-file-label" for="myInput"></label>
                        </div>
                    </div>
                </div>
            @else  
            <div class="form-group col-md-2" style="position: absolute; top: 400px; right: 113px;" >
             <label for="path_imagem"></label>
                <div class="input-group">
                    <div class="custom-file">
                        <input required name="path_imagem" type="file" class="custom-file-input" id="myInput" aria-describedby="myInput">
                        <label class="custom-file-label" for="myInput"></label>
                    </div>
                </div>
            </div>
            @endif
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary">Confirmar</button>
            </div>

        </form>
        
</div>
@stop