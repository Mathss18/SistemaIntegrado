@extends('adminlte::page')

@section('title', 'Clientes')

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
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-end">
        <h6>Gestão de Lacres</h6>
    </div>
    <div class="card-body">
        <table id="tableDT" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col" style="display:none">ID</th>
                    <th scope="col">Lacre</th>
                    <th scope="col">Cor</th>
                    <th scope="col">Código</th>
                    <th scope="col">Data</th>
                    <th scope="col">Nota</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lacres as $lacre)
                <tr>
                    <td style="display:none">{{$lacre->ID_rastreabilidade}}</td>
                    <td>{{$lacre->lacre}}</td>
                    <td>{{$lacre->cor}}</td>
                    <td>{{$lacre->codigo}}</td>
                    <td>{{$lacre->data}}</td>
                    <td>{{$lacre->nota}}</td>
                    <td>{{$lacre->nome}}</td>
                    <td>{{$lacre->qtde}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>


@stop