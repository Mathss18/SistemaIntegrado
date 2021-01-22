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
<style>
    /* Important part */
    .modal-dialog {
        overflow-y: initial !important;
    }

    .modal-body {
        height: 50vh;
        overflow-y: auto;
    }

    .modal-lg {
        max-width: 90% !important;
    }
</style>
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
<script>
    $(".clickable-row").click(function() {
    $('#modalRVD01').modal('toggle');
    $('#modalRVD01').modal('show');

});
</script>
<script>
    $(".clickable-row-FORNECEDOR").click(function() {
    $('#modalRVD02-FORNECEDOR').modal('toggle');
    $('#modalRVD02-FORNECEDOR').modal('show');

});
</script>
<script>
    $(".clickable-row-FUNCIONARIO").click(function() {
    $('#modalRVD02-FUNCIONARIO').modal('toggle');
    $('#modalRVD02-FUNCIONARIO').modal('show');

});
</script>
<script>
    $(".clickable-row-IMPOSTO").click(function() {
    $('#modalRVD02-IMPOSTO').modal('toggle');
    $('#modalRVD02-IMPOSTO').modal('show');

});
</script>
<script>
    $(".clickable-row-TRANSPORTADORA").click(function() {
    $('#modalRVD02-TRANSPORTADORA').modal('toggle');
    $('#modalRVD02-TRANSPORTADORA').modal('show');

});
</script>
<script>
    $(".clickable-row-INVESTIMENTO").click(function() {
    $('#modalRVD02-INVESTIMENTO').modal('toggle');
    $('#modalRVD02-INVESTIMENTO').modal('show');

});
</script>

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
                    <label for="fim">Situação</label>
                    <select class="form-control" name="situacao" id="situacao">
                        <option value="off">Fechados</option>
                        <option value="on">Abertos</option>
                        <option value="%o%">Ambos</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="">&nbsp;</label><br>
                    <button type="button" id="submit" class="btn btn-primary" onClick="gerarRelatorio()"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <hr style="border:1px solid black">
        <div>
            <div class="table-container01">
                @include('admin.money.extra.tabelaRVD01')
            </div>
            <hr style="border:1px solid black">
            <div class="table-container02">
                @include('admin.money.extra.tabelaRVD02')
            </div>
            <hr style="border:1px solid black">
            <div class="table-container03">
                @include('admin.money.extra.tabelaRVD03')
            </div>
            <hr style="border:1px solid black">
        </div>

        
        @stop