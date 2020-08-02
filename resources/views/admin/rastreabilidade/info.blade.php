@extends('adminlte::page')

@section('title', 'Rastreabilidade')

@section('content_header')
@stop



<!------ Inclui arquivos CSS *no inicio* ---------->
@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
@stop

<!------ Inclui arquivos JS *no fim*---------->

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
<script>$('#editable-select').editableSelect();</script>
@stop


<!------ Include the above in your HEAD tag ---------->
@section('content')
@if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {!! \Session::get('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    </div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Cadastro de novos Lacres</div>
        <div class="col">
            <hr>
        </div>
    </div>


    <form class="form-horizontal" method='POST' action="../rastreabilidade/armazenarInfoSeccion">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group col-md-4">
                <label for="cor">Cor</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-address-card"></i>
                    </div>
                    <select required id="editable-select" name="cor" class="custom-select">
                            <option value="Amarela Reformer">Amarela Reformer</option>
                            <option value="Azul Reformer">Azul Reformer</option>
                            <option value="Verde Reformer">Verde Reformer</option>
                            <option value="Amarela Cadilac">Amarela Cadilac</option>
                            <option value="Vermelha Cadilac">Vermelha Cadilac</option>
                            <option value="Preta Cadilac">Preta Cadilac</option>
                            <option value="Branca Cadeira">Branca Cadeira</option>
                            <option value="Marrom">Marrom</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="data">Data</label>
                <div class="input-group">
                    <div class="input-group-addon ">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <input required readonly id="data" value="{{$hoje ?? ''}}" name="data" type="date" class="form-control" required>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="codigo">Código</label>
                <div class="input-group">
                    <div class="input-group-addon ">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <input id="codigo" required name="codigo" type="text" class="form-control" required>
                </div>
            </div>

        </div>
        <!-- Segunda Linha !-->
        <div class="row">
            <div class="form-group col-md-4">
                <label for="nota">Nota Fiscal</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-address-card"></i>
                    </div>
                    <input id="nota" required name="nota" type="text" class="form-control" required>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="qtde">Quantidade</label>
                <div class="input-group">
                    <div class="input-group-addon ">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <input  id="qtde" required name="qtde" type="number" class="form-control" required>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="cliente">Cliente</label>
                <div class="input-group">
                    <div class="input-group-addon ">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <input required value="{{$cliente['ID_cliente'] ?? '' }}" style="display:none" name="cliente" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:360px;" required>
                    <input required value="{{$cliente['nome'] ?? '' }}" name="nomeCliente" class="typeahead form-control" id="ttexto" style="margin:0px auto;width:250px;" type="text" required>
                </div>
            </div>

        </div>

        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Começar a Cadastrar Lacres</button>
        </div>

    </form>
</div>
@stop