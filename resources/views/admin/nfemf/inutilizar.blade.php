@extends('adminlte::page')

@section('title', 'Nota Fiscal')

@section('content_header')
@stop

@section('css')
@stack('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
@endsection



<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Inutilizar Nota Fiscal Eletronica (IR NO CONTROLLER)</div>
        <div class="col">
            <hr>
        </div>
    </div>

    <form class="form-horizontal" method='POST' action="{{route('nfe.inutilizar')}}">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}


            

        <div class="row">
            <div class="form-group col-md-3">
                <label for="nomeCli">Qualquer coisa</label>
                <div class="input-group">
                    <input id="nomeCli" name="nomeCli" type="text" class="form-control" value="{{$nfe['nomeCli'] ?? '' }}">
                </div>
            </div>
        </div>

            
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Próximo Passo</button>
        </div>

    </form>
    <br>
</div>


<!-- Modal -->
<div class="modal fade" id="modalParcelas" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">Parcelas da nota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
            <form data-route="{{route('nfe.addParcela')}}" method="post" id="formParcela">
            {!! method_field('POST') !!}
            {!! csrf_field() !!}
                <table id="tableParcelas" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Dias</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>  
                    </tbody>
                </table>
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button name='submit' type="submit" class="btn btn-primary">Salvar mudanças</button>
      </div>
      </form>
    </div>
  </div>
</div>
@stop