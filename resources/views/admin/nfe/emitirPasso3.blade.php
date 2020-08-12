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

@if(isset($nfe))
<script>
     $("#{{$nfe3['tipoDesc']}}").prop("checked", true);
</script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="{{ asset('js/descontoNfe.js') }}"></script>

@stop
<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Informações Complementares</div>
        <div class="col">
            <hr>
        </div>
    </div>

    <form class="form-horizontal" id="myForm" method='POST' action="{{route('nfe.postEmitirPasso3')}}">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group col-md-2">
                <label for="especie">Especie</label>
                <div class="input-group">
                    <input required id="especie" name="especie" type="text" class="form-control" value="{{$nfe3['especie'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="qtdeComp">Quantidade</label>
                <div class="input-group">
                    <input required required id="qtdeComp" name="qtdeComp" type="number" min="1" class="form-control" value="{{$nfe3['qtdeComp'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="desconto">Desconto</label>
                <div class="input-group">
                    <input required id="desconto" name="desconto" type="number" min="0" step="0.000000000000001" oninput="validity.valid||(value='');" class="form-control" value="{{$nfe3['desconto'] ?? '0' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="finNFe">&nbsp</label>
                <div class="form-check">
                    <input class="form-check-input desc" type="radio" name="tipoDesc" id="valorCheio" value="valorCheio">
                    <label class="form-check-label" for="tipoDesc">
                        Valor Cheio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input desc" type="radio" name="tipoDesc" id="porcentagem" value="porcentagem">
                    <label class="form-check-label" for="tipoDesc">
                        Porcentagem
                    </label>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="form-group col-md-2">
                <label for="pesoBruto">Peso Bruto</label>
                <div class="input-group">
                    <input required id="pesoBruto" name="pesoBruto" type="number" min="0" step="0.01" class="form-control" value="{{$nfe3['pesoBruto'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="pesoLiq">Peso Liquido</label>
                <div class="input-group">
                    <input required id="pesoLiq" name="pesoLiq" type="number" min="0" step="0.01" class="form-control" value="{{$nfe3['pesoLiq'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="unidade">Unidade Padrão</label>
                <div class="input-group">
                    <input required id="unidade" name="unidade" type="text" class="form-control" value="{{$nfe3['unidade'] ?? '' }}">
                </div>
            </div>

        </div>
        <br>

        <div class="row">
            <div class="col-md-5">
                <hr>
            </div>
            <div class="col-auto">Informações Adicionais</div>
            <div class="col">
                <hr>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="form-group col-md-10">
                <label for="infoAdc">Informações Adicionais</label>
                <div class="input-group">
                    <textarea  id="infoAdc" name="infoAdc" type="textarea" class="form-control" value="{{$nfe3['infoAdc'] ?? '' }}"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
                <hr>
            </div>
            <div class="col-auto">Revisão da Nota</div>
            <div class="col">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="nomeCli">Nome do Cliente</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-address-book"></i>
                    </div>
                    <input readonly id="nomeCli" name="nomeCli" type="text" class="form-control" value="{{$nfe1['nomeCli'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="qtdProd">Qtde de Produtos</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-list-ol"></i>
                    </div>
                    <input readonly id="qtdProd" name="qtdProd" type="text" class="form-control" value="{{$nfe2['totalQtde'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="precoFinal">Valor final da Nota</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                    <input readonly id="precoFinal" name="precoFinal" type="number" min="0" class="form-control" value="{{$nfe2['total'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="precoFinal">Valor original da Nota</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                    <input readonly disabled id="precoFinalAux" name="precoFinalAux" type="number" min="0" class="form-control" value="{{$nfe2['total'] ?? '' }}">
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="input-group">
                    <input readonly id="porcento" name="porcento" type="hidden" min="0" class="form-control" value="">
                </div>
            </div>
        </div>
        <div class="form-group">
            <a href="{{route('nfe.emitirPasso1')}}" class="btn btn-secondary">Voltar Passo 1</a>
            <a href="{{route('nfe.emitirPasso2')}}" class="btn btn-secondary">Voltar Passo 2</a>
            <button name="submit" type="submit" class="btn btn-success">Finalizar</button>
        </div>

    </form>
    <br>
</div>
@stop