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
            }
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
        <h6>Gestão de NF-e</h6>


    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <iframe style="border: 2px solid black;" src="{{url('notaFimDanfe.pdf')}}" width="600" height="780" style="border: none;"></iframe>

                <div class="row">
                    <div class="container-fluid ml-3">
                        <div class="row mb-2">
                            <div>
                                <a href="#" class="btn btn-success ml-3"><i class="fas fa-paper-plane"></i>
                                    Enviar nota por Email
                                </a>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div>
                                <a href="#" class="btn btn-info ml-3"><i class="fas fa-eraser"></i></i>
                                    Carta de Correção
                                </a>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div>
                                <a href="#" class="btn btn-danger ml-3"><i class="fas fa-ban"></i></i>
                                    Cancelar Nota
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop