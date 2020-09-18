@extends('adminlte::page')

@section('title', 'Nota Fiscal')

@section('content_header')
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
<script type="text/javascript" charset="UTF-8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"></script>
<script>
    $(document).ready(function() {
        $('#tableDT').DataTable({
            "language": {
                url: '../js/traducao.json',
                decimal: ",",
                
            },
            "order": [[ 0, "desc" ]]
        });
    });
</script>
<script>
    $(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
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
@if (\Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {!! \Session::get('error') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-end">
        <h6>Gestão de NF-e</h6>
        <a href="{{route('nfe.emitirPasso1')}}" class="btn btn-success">
            <span class="glyphicon glyphicon-plus"></span>
            Emitir Nova NF-e por número da OF
        </a>
        <a href="{{url('storage/Nfe/UltimoXML/FM/last.txt')}}" target="_blank" class="btn btn-info">
            <span class="glyphicon glyphicon-plus"></span>
            ultimo XML
        </a>


    </div>
    <div class="card-body">
        <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Numero</th>
                    <th scope="col">OF</th>
                    <th scope="col">Chave</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Abertura</th>
                </tr>
            </thead>
            <tbody>
            @foreach($nfe as $nf)
                <tr class='clickable-row' data-href="{{route('nfe.edit',$nf->ID_nfe)}}">
                    <td>{{$nf->nNF}}</td>
                    <td>{{$nf->OF}}</td>
                    <td>{{$nf->chaveNF}}</td>
                    <td>{{$nf->nome}}</td>
                    <td>{{$nf->data_abertura}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>


@stop