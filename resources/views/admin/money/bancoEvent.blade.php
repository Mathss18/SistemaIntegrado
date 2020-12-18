@extends('adminlte::page')

@section('title', 'Bancos')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
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
<script src="{{asset('assets/fullcalendar/lib/main.js')}}"></script>
<script src="{{asset('assets/fullcalendar/js/carregarEvento.js')}}"></script>
<script src="{{asset('assets/fullcalendar/js/script.js')}}"></script>
<script src="{{asset('assets/fullcalendar/lib/locales/pt-br.js')}}"></script>
<script src="{{ asset('js/dropdownFornecedorMoney.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
<script src="{{ asset('js/dropdownFunc.js') }}"></script>
<script src="{{ asset('js/dropdownTranspMoney.js') }}"></script>
<script src="{{ asset('js/clickTabelaEvt.js') }}"></script>

<script>
    $(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>
@stop

@section('content')

<div id='calendar-wrap'>
        <div id='calendar' 
        data-route-carregar-eventos="{{route('money.carregarEventos')}}" 
        data-route-atualizar-evento="{{route('money.atualizarEvento')}}"
        data-route-inserir-evento="{{route('money.inserirEvento')}}"
        data-route-excluir-evento="{{route('money.excluirEvento')}}"
        >
        </div>
</div>
@include('admin.money.modalCalendarioBanco')
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
    <div class="card-header d-flex" style="justify-content: left; align-items: left;">
        <div class="row">
            <img src="{{asset($banco->logo)}}" alt="aa" class="mr-2" width="100px" height="100px" style="opacity: 80%;">
            <div class="col">
                <div><a style="font-size: 26px; color: black; text-align: center; font-weight: bolder; font-family: monospace">{{$banco->nome}}</a></div>
                <div><a style="font-size: 20px; color: black; text-align: center; font-weight: lighter; font-family: monospace">Saldo R$: {{number_format($banco->saldo,2,',','.')}}</a></div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
                
        <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col" style="display: none;">ID</th>
                    <th scope="col" style="display: none;">DataReal</th>
                    <th scope="col" style="display: none;">desc</th>
                    <th scope="col" style="display: none;">fav</th>
                    <th scope="col" style="display: none;">tipoFav</th>
                    <th scope="col" style="display: none;">ID_Banco</th>
                    <th scope="col" style="display: none;">num</th>
                    <th scope="col" style="display: none;">sit</th>
                    <th scope="col">Data</th>
                    <th scope="col">Favorecido</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventos as $evento)
                <tr style="color: {{$evento->corFonte}}">
                    <td style="display: none;">{{$evento->id}}</td>
                    <td style="display: none;">{{$evento->start}}</td>
                    <td style="display: none;">{{$evento->description}}</td>
                    <td style="display: none;">{{$evento->favorecido}}</td>
                    <td style="display: none;">{{$evento->tipoFav}}</td>
                    <td style="display: none;">{{$evento->ID_banco}}</td>
                    <td style="display: none;">{{$evento->numero}}</td>
                    <td style="display: none;">{{$evento->situacao}}</td>
                    <td>{{$evento->dataFormat}}</td>
                    <td>{{$evento->favorecido}}</td>
                    <td style="color: {{$evento->corFonte}}">{{$evento->valor}}</td>
                    <td>{{$evento->saldo}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>



@stop