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
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
@stop

<!------ Inclui arquivos JS *no fim*---------->


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
@if($firma == 'MF')
<script src="{{ asset('js/clickTabelaFaturamento.js') }}"></script>
@else
<script src="{{ asset('js/clickTabelaFaturamentoFM.js') }}"></script>
@endif
@stop



<!------ Include the above in your HEAD tag ---------->
@section('content')
@if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {!! \Session::get('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    </div>
@endif
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <hr>
                </div>
                <div class="col-auto">Informações de Faturamento</div>
                <div class="col">
                    <hr>
                </div>
            </div>

                <form class="form-horizontal" method='POST' action="../faturamento/acao">
                    {!! method_field('POST') !!}
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-5">
                            <label for="ID_cliente">Nome Cliente</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-address-card"></i>
                                </div>
                                <input required value="{{$cliente['ID_cliente'] ?? '' }}" style="display:none" name="cliente" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:360px;">
                                <input required value="{{$cliente['nome'] ?? '' }}" class="typeahead form-control" id="ttexto" style="margin:0px auto;width:340px;" type="text">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="vale">OF</label>
                            <div class="input-group">
                                <div class="input-group-addon ">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <input style="display:none" id="ID_faturamento" name="ID_faturamento" type="text" class="form-control">
                                <input required id="vale" name="vale" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="nfe">NF-e</label>
                            <div class="input-group">
                                <div class="input-group-addon ">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <input required id="nfe" name="nfe" type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="peso">Peso</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-wpforms"></i>
                                </div>
                                <input required id="peso" name="peso" type="number" step="any" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="valor">Valor</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-address-book"></i>
                                </div>
                                <input required id="valor" name="valor" type="number" step="any" class="form-control">
                            </div>
                        </div>
                        @if($firma == 'MF')
                        <div class="form-group col-md-2">
                            <label for="situacao">Situação</label>
                            <select required id="situacao" name="situacao" class="custom-select">
                                <option value="Aberto">Aberto</option>
                                <option value="Fechado">Fechado</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="status">Status</label>
                            <select required id="status" name="status" class="custom-select">
                                <option value="Pago">Pago</option>
                                <option value="Pendente">Pendente</option>
                            </select>
                        </div>
                        @else
                        <div class="form-group col-md-4">
                            <label for="situacao">Situação</label>
                            <select required id="situacao" name="situacao" class="custom-select">
                                <option value="Aberto">Aberto</option>
                                <option value="Fechado">Fechado</option>
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="form-group col-md-1">
                            <button name="submit" value="inserir" type="submit" class="btn btn-success">Inserir</button>
                        </div>
                        <div class="form-group col-md-1">
                            <button name="submit" value="editar" type="submit" class="btn btn-primary">Editar</button>
                        </div>
                        <div class="form-group col-md-1">
                            <button name="submit" value="excluir" type="submit" class="btn btn-danger">Excluir</button>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-5">
                            <hr>
                        </div>
                        <div class="col-auto">Faturamentos Lançados</div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                </form>
                <div>
                <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col" style="display:none">ID Fat</th>
                    <th scope="col" style="display:none">ID Cli</th>
                    <th scope="col">OF</th>
                    <th scope="col">NF-e</th>
                    <th scope="col">Situação</th>
                    @if($firma == 'MF')
                    <th scope="col">Status</th>
                    @endif
                    <th scope="col">Cliente</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faturamentos as $faturamento)
                <tr>
                    <td style="display:none">{{$faturamento->ID_faturamento}}</td>
                    <td style="display:none">{{$faturamento->ID_Cliente}}</td>
                    <td>{{$faturamento->vale}}</td>
                    <td>{{$faturamento->nfe}}</td>
                    <td>{{$faturamento->situacao}}</td>
                    @if($firma == 'MF')
                    <td>{{$faturamento->status}}</td>
                    @endif
                    <td>{{$faturamento->nome}}</td>
                    <td>{{$faturamento->peso}}</td>
                    <td>{{$faturamento->valor}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
                </div>
        </div>
    </div>
</div>
@stop