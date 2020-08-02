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
@stop

<!------ Inclui arquivos JS *no fim*---------->

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
@stop


<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h4 style="color:red;">Relatório de Saida - {{$banho}}<h4>
        </div>

        <div class="col-md-6">
            <h6 style="padding-left:5em">De: {{$data_inicio_reform}}  <br>Até: {{$data_fim_reform}}</h6>
        </div>
    </div>
    <div class="col-md-6">
        <h6>Total Gasto: R$: {{$totalGasto}}</h6>
    </div>


    <div class="row">
        <div class="card-body">
            <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Data Entrada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dados as $dado)
                    <tr>
                        <td>{{$dado->nome}}</td>
                        <td>{{$dado->quantidade_gasta}}</td>
                        <td>{{$dado->valor_unitario}}</td>
                        <td>{{$dado->data_saida}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
@stop