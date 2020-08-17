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


    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <iframe style="border: 2px solid black;" src="{{url('storage/'.$nfe->path_nfe.'.pdf')}}" width="600" height="780" style="border: none;"></iframe>

                <div class="row">
                    <form action="{{route('nfe.enviarEmail')}}" method="post">
                    {!! method_field('POST') !!}
                    {!! csrf_field() !!}
                    <div class="container-fluid ml-3">
                        <div class="row mb-2">
                            <div>
                                <input readonly id="ID_nfe" name="ID_nfe" type="hidden" class="form-control" value="{{$nfe->ID_nfe ?? '' }}">
                                <input readonly id="ID_cliente" name="ID_cliente" type="hidden" class="form-control" value="{{$cliente->ID_cliente ?? '' }}">
                                <button type="submit" class="btn btn-success ml-3" value='true' name='email'>
                                <i class="fas fa-paper-plane"></i>
                                Enviar nota por Email
                                </button>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div>
                                <button type="submit" class="btn btn-info ml-3" value='true' name='cartaCorrecao1'>
                                <i class="fas fa-eraser"></i>
                                Carta de Correção
                                </button>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div>
                                <button type="submit" class="btn btn-danger ml-3" value='true' name='cancelarNfe'>
                                <i class="fas fa-ban"></i>
                                Cancelar Nota
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop