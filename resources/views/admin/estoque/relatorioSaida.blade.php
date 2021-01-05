@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
@stop



<!------ Inclui arquivos CSS *no inicio* ---------->
@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
@stop

<!------ Inclui arquivos JS *no fim*---------->

@if(isset($pedido))
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
@stop
@else
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
@stop
@endif

<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Gerar Relátorio de Entrada</div>
        <div class="col">
            <hr>
        </div>
    </div>


    <form class="form-horizontal" method='POST' action="../estoque/gerarRelatorioSaida">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group col-md-4">
                <label for="data_inicio">Data Inicio</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-address-card"></i>
                    </div>
                    <input required id="data_inicio" name="data_inicio" type="date" class="form-control">
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="data_fim">Data Fim</label>
                <div class="input-group">
                    <div class="input-group-addon ">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <input required id="data_fim" name="data_fim" type="date" class="form-control">
                </div>
            </div>

            <div class="form-group col-md-4">
                    <label for="banho">Utilização</label>
                    <div class="input-group">
                        <div class="input-group-addon ">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <select required id="banho" name="banho" class="custom-select">
                            @if($firma=='MF')
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
                            @else
                                <option value="Arame">ARAME</option>
                            @endif
                    </select>
                    </div>
                </div>

        </div>

        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Gerar Relatório</button>
        </div>

    </form>
</div>
@stop