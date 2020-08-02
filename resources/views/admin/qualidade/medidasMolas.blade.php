@extends('adminlte::page')

@section('title', 'Clientes')

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
<script src="{{ asset('js/clickTabelaQualidade.js') }}"></script>
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
<div>

    <div class="card-body" >
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <hr>
                </div>
                <div class="col-auto">Informações de Medidas</div>
                <div class="col">
                    <hr>
                </div>
            </div>

                <form class="form-horizontal" method='POST' action="../qualidade/acao">
                    {!! method_field('POST') !!}
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="ID_cliente">Nome Cliente</label>
                            <div class="input-group">
                                <input required value="{{$cliente['ID_cliente'] ?? '' }}" style="display:none" name="cliente" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:360px;">
                                <input required value="{{$cliente['nome'] ?? '' }}" class="typeahead form-control" id="ttexto" style="margin:0px auto;width:250px;" type="text">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="of">OF</label>
                            <div class="input-group">
                                <input style="display:none" id="data" value="{{$hoje ?? ''}}" name="data" type="text" class="form-control">
                                <input style="display:none" id="ID_qualidade" name="ID_qualidade" type="text" class="form-control">
                                <input required id="of" name="of" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="codigo">Código</label>
                            <div class="input-group">
                                <input required id="codigo" name="codigo" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="qtde">Quantidade</label>
                            <div class="input-group">
                                <input required id="qtde" name="qtde" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="arame">Arame</label>
                            <div class="input-group">
                                <input required id="arame" name="arame" type="text" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="sobra">Sobra</label>
                            <div class="input-group">
                                <input required id="sobra" name="sobra" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="abertura">Abertura</label>
                            <div class="input-group">
                                <input required id="abertura" name="abertura" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="interno">Interno</label>
                            <div class="input-group">
                                <input required id="interno" name="interno" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="externo">Externo</label>
                            <div class="input-group">
                                <input required id="externo" name="externo" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="acabamento">Acabamento</label>
                            <div class="input-group">
                                <select required id="acabamento" name="acabamento" class="custom-select">
                                    <option value="Inox">Inox</option>
                                    <option value="Oleada">Oleada</option>
                                    <option value="Zincada">Zincada</option>
                                    <option value="Bicromatizada">Bicromatizada</option>
                                    <option value="Pintada">Pintada</option>
                                    <option value="Niquelada">Niquelada</option>
                                    <option value="Trivalente">Trivalente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    <div class="form-group col-md-2">
                            <label for="passo">Passo</label>
                            <div class="input-group">
                                <input required id="passo" name="passo" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lo_corpo">Lo(Corpo)</label>
                            <div class="input-group">
                                <input required id="lo_corpo" name="lo_corpo" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="lo_total">Lo(Total)</label>
                            <div class="input-group">
                                <input required id="lo_total" name="lo_total" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="espiras">Espiras</label>
                            <div class="input-group">
                                <input required id="espiras" name="espiras" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="obs">OBS</label>
                            <div class="input-group">
                                <textarea  id="obs" name="obs" class="form-control"></textarea>
                            </div>
                        </div>
                        

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
                        <div class="col-auto">Medidas Lançadas</div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                </form>
                <div>
                <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col" style="display:none">ID Qua</th>
                    <th scope="col" style="display:none">ID Cli</th>
                    <th scope="col">OF</th>
                    <th scope="col">Cdg</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Qtde</th>
                    <th scope="col">Sobra</th>
                    <th scope="col">Abtra</th>
                    <th scope="col">Arame</th>
                    <th scope="col">Inte</th>
                    <th scope="col">Exte</th>
                    <th scope="col">Passo</th>
                    <th scope="col">LO(Corpo)</th>
                    <th scope="col">LO(Total)</th>
                    <th scope="col">Espi</th>
                    <th scope="col">Acab</th>
                    <th scope="col">OBS</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medidas as $medida)
                <tr>
                    <td style="display:none">{{$medida->ID_qualidade}}</td>
                    <td style="display:none">{{$medida->ID_cliente}}</td>
                    <td>{{$medida->of}}</td>
                    <td>{{$medida->codigo}}</td>
                    <td>{{$medida->nome}}</td>
                    <td>{{$medida->qtde}}</td>
                    <td>{{$medida->sobra}}</td>
                    <td>{{$medida->abertura}}</td>
                    <td>{{$medida->arame}}</td>
                    <td>{{$medida->interno}}</td>
                    <td>{{$medida->externo}}</td>
                    <td>{{$medida->passo}}</td>
                    <td>{{$medida->lo_corpo}}</td>
                    <td>{{$medida->lo_total}}</td>
                    <td>{{$medida->espiras}}</td>
                    <td>{{$medida->acabamento}}</td>
                    <td>{{$medida->obs}}</td>
                    <td>{{$medida->data}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
                </div>
        </div>
    </div>
</div>
@stop