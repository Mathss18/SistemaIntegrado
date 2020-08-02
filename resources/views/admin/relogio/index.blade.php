@extends('adminlte::page')

@section('title', 'Relógio')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{ asset('css/telaDividida.css') }}">
@stop

@section('js')
<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#tableDT').DataTable({
            "language": {
            url: '../../js/traducao.json',
            decimal: ",",
        },
        });
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
<div class="d-md-flex h-md-100 align-items-center">

    <!-- Relógio Esquerdo -->
    <div class="col-md-6 p-0 bg-white h-md-100">
        <div class="d-md-flex align-items-start h-100 p-5 text-center justify-content-center">

            <div class="logoarea pt-5 pb-5">
                <h4>Relógio De Cima</h4>
                <hr>
                <form class="form-horizontal" method='POST' action="{{route('relogio.store')}}">
                    {!! method_field('POST') !!}
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inicio">Inicio Dia</label>
                            <div class="input-group">
                                <input min="0" id="inicio1" name="inicio" type="number" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="fim">Fim Dia</label>
                            <div class="input-group">
                                <input min="0" id="fim1" name="fim" type="number" class="form-control" required>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <button name="status" value="r1" class="btn btn-primary">Lançar Valor</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Relógio Direito -->
    <div class="col-md-6 p-0 bg-white h-md-100">
        <div class="d-md-flex align-items-start h-100 p-5 text-center justify-content-center">

            <div class="logoarea pt-5 pb-5">
                <h4>Relógio De Baixo</h4>
                <hr>
                <form class="form-horizontal" method='POST' action="{{route('relogio.store')}}">
                    {!! method_field('POST') !!}
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="data_inicio">Inicio Dia</label>
                            <div class="input-group">
                                <input min="0" id="inicio2" name="inicio" type="number" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="data_fim">Fim Dia</label>
                            <div class="input-group">
                                <input min="0" id="fim2" name="fim" type="number" class="form-control" required>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <button name="status" value="r2" type="submit" class="btn btn-primary">Lançar Valor</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@stop