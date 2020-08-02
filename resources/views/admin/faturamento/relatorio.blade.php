@extends('adminlte::page')

@section('title', 'Faturamento')

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
            <h4 style="color:green;">Relatório de Faturamento {{$nomeFimra}}<h4>
        </div>

        <div class="col-md-6">
            <h6>De: {{$data_inicio_reform}}  <br>Até: {{$data_fim_reform}}</h6>
        </div>
    </div>
    <div class="col-md-6">
        <h6>Sistema Integrado</h6>
    </div>


    <div class="row">
        <div class="card-body">
            <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Faturamento Total</th>
                        <th scope="col">Faturamento Em Aberto</th>
                        <th scope="col">Peso Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>R$: {{$faturamentoTotal[0]->total}}</td>
                        <td style="color:red">R$: {{$faturamentoAberto[0]->aberto}}</td>
                        <td>{{$faturamentoPeso[0]->peso}} KG</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="card-body">
            <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Cliente</th>
                        <th scope="col">Total Gasto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faturamentoClientes as $fc)
                    <tr>
                        <td>{{$fc->nome}}</td>
                        <td>R$: {{$fc->valor}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
@stop