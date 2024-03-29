@extends('adminlte::page')
@section('title', 'Sistema Integrado')

@section('content_header')
<h1 class="m-0 text-dark">Bem Vindo <strong>{{Auth::user()->name}}</strong></h1>
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
@stop

@section('js')
<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
@stop


@section('content')
@if (\Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {!! \Session::get('error') !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(Auth::user()->funcao == 'Admin')
<div class="content">
    <div class="card text-center" style="width: 18rem;">
        <img class="card-img-top" src="moneyLogo.png" alt="MoneyLogo">
        <div class="card-body">
            <a class="btn btn-dark" href="{{route('money.index')}}">Acessar</a>
        </div>

    </div>
</div>
@elseif(Auth::user()->funcao == 'Producao')
<div class="content">
    @if($aproveitamento <= 100.0 && $aproveitamento>= 80.0)
        <p style="font-size: 18px;">Seu aproveitamento neste mês é de <b style="color: green;">{{$aproveitamento}} %</b></p>
    @elseif($aproveitamento <= 79.9 && $aproveitamento>= 50.0)
        <p style="font-size: 18px;">Seu aproveitamento neste mês é de <b style="color: orange;">{{$aproveitamento}} %</b></p>
    @else
        <p style="font-size: 18px;">Seu aproveitamento neste mês é de <b style="color: red;">{{$aproveitamento}} %</b></p>
    @endif
    @if($aproveitamentoLastMonth <= 100.0 && $aproveitamentoLastMonth>= 80.0)
        <p style="font-size: 18px;">Seu aproveitamento no mês passado foi de <b style="color: green;">{{$aproveitamentoLastMonth}} %</b></p>
    @elseif($aproveitamentoLastMonth <= 79.9 && $aproveitamentoLastMonth>= 50.0)
        <p style="font-size: 18px;">Seu aproveitamento no mês passado foi de <b style="color: orange;">{{$aproveitamentoLastMonth}} %</b></p>
    @else
        <p style="font-size: 18px;">Seu aproveitamento no mês passado foi de <b style="color: red;">{{$aproveitamentoLastMonth}} %</b></p>
    @endif
</div>
@endif
@stop