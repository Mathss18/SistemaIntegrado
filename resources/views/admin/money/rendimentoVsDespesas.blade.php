@extends('adminlte::page')

@section('title', 'Rendimento vs. Despesas')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('js')
<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
<script src="{{ asset('js/relatorio01.js') }}"></script>

@stop

@section('content')

@if (\Session::has('success'))
<div class="alert alert-success alert-dismissible fade show">
    {!! \Session::get('success') !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div><i class="fas fa-arrow-circle-left"></i>&nbsp;<a href="{{route('money.index')}}">Voltar ao Caléndario</a></div>
<div class="card shadow mb-4">
<div id="rotas" style="display: none;" data-route-gerar-ralatorio01="{{route('money.gerarRelatorio01')}}"></div>

    <div class="card-body">
        <form id="formData" action="{{route('money.gerarRelatorio01')}}" method="post">
            {!! method_field('POST') !!}
            {!! csrf_field() !!}
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="inicio">Inicio</label>
                    <input type="date" name="inicio" id="inicio" class="form-control" value="{{$primeiroDiaMes ?? ''}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="fim">Fim</label>
                    <input type="date" name="fim" id="fim" class="form-control" value="{{$ultimoDiaMes ?? ''}}">
                </div>
                <div class="form-group col-md-3">
                    <label for="">&nbsp;</label><br>
                    <button type="button" id="submit" class="btn btn-primary" onClick="gerarRelatorio()"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <hr style="border:1px solid black">
        <div>
            <div>
                <table class="table table-striped table-borderless table-sm">
                    <thead>
                        <tr>
                            <th scope="col-md-2">Categoria de Rendimento</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="height: 1px;">
                            <td style="width: 25%">{{strtoupper($resultado[0]->tipoFav)}}</td>
                            <td style="width: 25%">R$: {{number_format($resultado[0]->total,2,',','.')}}</td>
                        </tr>
                        <tr>
                            <td style="color: blue;">Total de rendimentos:</td>
                            <td style="color: blue;">R$: {{number_format($resultado[0]->total,2,',','.')}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr style="border:1px solid black">
            <div>
                <table class="table table-striped table-borderless table-sm">
                    <thead>
                        <tr>
                            <th scope="col-md-2">Categoria de despesas</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i < sizeof($resultado); $i++) <tr>
                            <td style="width: 25%">{{strtoupper($resultado[$i]->tipoFav)}}</td>
                            <td style="width: 25%">R$: {{number_format($resultado[$i]->total,2,',','.')}}</td>
                            </tr>
                            <a style="display: none;">{{$totalDespesa += $resultado[$i]->total}}</a>
                            @endfor
                            <tr>
                                <td style="color: blue;">Total de despesas:</td>
                                <td style="color: blue;">R$: {{number_format($totalDespesa,2,',','.')}}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <hr style="border:1px solid black">
            <div>
                <table class="table table-striped table-borderless table-sm">
                    <thead>
                    </thead>
                    <tbody>
                        @if(($resultado[0]->total-$totalDespesa) > 0)
                        <tr>
                            <td style="color: black; width: 25%"><b>Total:</b></td>
                            <td style="color: blue; width: 25%">R$: {{number_format(($resultado[0]->total-$totalDespesa),2,',','.')}}</td>
                        </tr>
                        @else
                        <tr>
                            <td style="color: black; width: 25%"><b>Total:</b></td>
                            <td style="color: red; width: 25%">R$: {{number_format(($resultado[0]->total-$totalDespesa),2,',','.')}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <hr style="border:1px solid black">
        </div>

        @stop