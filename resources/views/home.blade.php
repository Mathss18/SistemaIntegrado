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
@endif
@stop