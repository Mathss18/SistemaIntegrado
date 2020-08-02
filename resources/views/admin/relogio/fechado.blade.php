@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
@stop

@section('js')
<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="{{ asset('js/clickTabelaRelogio.js') }}"></script>
<script src="{{ asset('js/consumo.js') }}"></script>
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
                <h4>Relógio De Cima <p style="color:red" id="consumoCima">Falha JS</p></h4>
                <hr>
                <div class="card-body">
                <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="display:none">ID</th>
                            <th scope="col" class="inicio">Inicio</th>
                            <th scope="col" class="fim">Fim</th>
                            <th scope="col">Consumo</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($relogios as $relogio)
                        <tr data-toggle="modal" data-target="#ModalEdit" onclick ="pegarID(this,1);">
                            <td style="display:none">{{$relogio->ID_relogio}}</td>
                            <td>{{$relogio->inicio}}</td>
                            <td>{{$relogio->fim}}</td>
                            <td>Falha JS</td>
                            <td>{{$relogio->data}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            </div>
        </div>
    </div>

    <!-- Relógio Direito -->
    <div class="col-md-6 p-0 bg-white h-md-100">
        <div class="d-md-flex align-items-start h-100 p-5 text-center justify-content-center">

            <div class="logoarea pt-5 pb-5">
                <h4>Relógio De Baixo <p style="color:red" id="consumoBaixo">Falha JS</p></h4>
                <hr>
                
                <div class="card-body">
                <table id="tableDT2" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" style="display:none">ID</th>
                            <th scope="col">Inicio</th>
                            <th scope="col">Fim</th>
                            <th scope="col">Consumo</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($relogios2 as $relogio)
                        <tr data-toggle="modal" data-target="#ModalEdit" onclick ="pegarID(this,1);"> 
                            <td style="display:none">{{$relogio->ID_relogio}}</td>
                            <td>{{$relogio->inicio}}</td>
                            <td>{{$relogio->fim}}</td>
                            <td>Falha JS</td>
                            <td>{{$relogio->data}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            </div>
        </div>
    </div>
</div>








<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-target=".bd-example-modal-lg">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color:orange;" class="modal-title" id="TituloModalCentralizado">Falha JS 'Consumo'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../relogio/editar">
                {!! method_field('POST') !!}
                {!! csrf_field() !!}
                    <div class="form-group">
                        <label style="display:none">ID<input id="iptID" class="form-control " type="number" name="ID_relogio"></label>
                        <label>Inicio<input id="iptInicio" class="form-control " type="number" name="inicio"></label>
                        <label>Fim<input id="iptFim" class="form-control " type="text" name="fim"></label>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-success" type="submit" name="submit" value="editar">Editar</button>
                        <button class="btn btn-outline-danger" type="submit" name="submit" value="excluir">Excluir</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@stop