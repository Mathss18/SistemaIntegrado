@extends('adminlte::page')

@section('title', 'Rastreabilidade')

@section('content_header')
@stop



<!------ Inclui arquivos CSS *no inicio* ---------->
@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
@stop

<!------ Inclui arquivos JS *no fim*---------->

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="{{ asset('js/autoPreencher.js') }}"></script>
@stop


<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Cor</th>
                        <th scope="col">Código</th>
                        <th scope="col">Data</th>
                        <th scope="col">Nota</th>
                        <th scope="col">Cleinte</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{Session::get('RastreCor') ?? ''}}</td>
                    <td>{{Session::get('RastreCodigo') ?? ''}}</td>
                    <td>{{Session::get('RastreData') ?? ''}}</td>
                    <td>{{Session::get('RastreNota') ?? ''}}</td>
                    <td>{{Session::get('RastreNomeCliente') ?? ''}}</td>
                    <td>{{Session::get('RastreQtde') ?? ''}}</td>
                </tr>
            </tbody>
        </table>
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Cadastro de Lacres</div>
        <div class="col">
            <hr>
        </div>
    </div>


    <form class="form-horizontal" method='POST' action="../rastreabilidade/cadastrarLacres">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        <div class="row">
        @for ($i = 0; $i < $qtde; $i++)
            <div class="form-group col-md-2">
                <label for="data">{{$i+1}}</label>
                <div class="input-group">
                <div class="input-group prefix">   
                <span class="input-group-addon" style="color:{{$cor ?? ''}}">{{$prefixo}}</span>
                    <input style="border: 2px solid {{$cor ?? ''}}; border-radius: 4px;" id="data" value="" name="lacre[]" type="text" class="form-control" required>
                    </div>
                </div>
            </div>
            @endfor
        </div>
        <input id="prefixo" value="{{$prefixo ?? ''}}" name="prefixo" type="hidden" class="form-control">

        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Cadastrar Lacres</button>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAutoPreencher">
            Auto Preencher
            </button>
        </div>

    </form>
</div>



<!-- Modal -->
<div class="modal fade" id="ModalAutoPreencher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Auto Preencher Lacres</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-3">
                    <label for="de">De:</label>
                        <input required min="0" id="de" type="number" class="form-control">
      </div>
      <div class="form-group col-md-3">
                    <label for="ate">Até:</label>
                        <input required id="ate" type="number" class="form-control">
      </div>
        <div class="form-group col-md-4">
                    <label for="lacreInicio" >Lacre Inicial</label>
                        <input required id="lacreInicio" type="number" class="form-control" style="border: 2px solid {{$cor ?? ''}}; border-radius: 4px;">
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="autoPreencher();">Confirmar</button>
      </div>
    </div>
  </div>
</div>
@stop