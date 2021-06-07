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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('js/dropdownNfe.js') }}"></script>
<script src="{{ asset('js/dropdownTransp.js') }}"></script>
<script src="{{ asset('js/parcela.js') }}"></script>

@if(isset($nfe))

<script>
    $("#tpNF>option[value={{$nfe['OF']}}]").attr("selected", true);
    $("#tpNF>option[value={{$nfe['tpNF']}}]").attr("selected", true);
    $("#finNFe>option[value={{$nfe['finNFe']}}]").attr("selected", true);
    $("#natOp>option[value={{$nfe['natOp']}}]").attr("selected", true);
    $("#finNFe>option[value={{$nfe['finNFe']}}]").attr("selected", true);
    $("#formaPag>option[value={{$nfe['formaPag']}}]").attr("selected", true);
    $("#modFrete>option[value={{$nfe['modFrete']}}]").attr("selected", true);
    $("#meioPagto>option[value={{$nfe['meioPagto']}}]").attr("selected", true);
</script>
@endif
@endsection



<!------ Include the above in your HEAD tag ---------->
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <hr>
        </div>
        <div class="col-auto">Informações da Nota Fiscal Eletrônica</div>
        <div class="col">
            <hr>
        </div>
    </div>

    <form class="form-horizontal" method='POST' action="{{route('nfe.postEmitirPasso1')}}">
        {!! method_field('POST') !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group col-md-2">
                <label for="OF">Número da OF</label>
                <div class="input-group">
                    <input required value="{{$nfe['ID_cliente'] ?? '' }}" style="display:none" name="ID_cliente" id="ID_cliente" type="text" class="typeahead form-control " style="margin:0px auto;width:360px;">
                    <input required value="{{$nfe['OF'] ?? '' }}" class="typeahead form-control" name="OF" id="ttexto" style="margin:0px auto;width:150px;" type="text">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="tpNF">Tipo da nota</label>
                <div class="input-group">
                    <select id="tpNF" name="tpNF" class="custom-select">
                        <option value=1>Saída</option>
                        <option value=0>Entrada</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="finNFe">Finalidade da nota</label>
                <div class="input-group">
                    <select id="finNFe" name="finNFe" class="custom-select">
                        <option value=1>NFe Normal</option>
                        <option value=2>NFe Complementar</option>
                        <option value=3>NFe de Ajuste</option>
                        <option value=4>Devolução de mercadoria</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-5">
                <label for="natOp">CFOP</label>
                <div class="input-group">
                    <select id="natOp" name="natOp" class="custom-select">
                        <option value="5101">5101 - VENDA DENTRO DO ESTADO</option>
                        <option value="6101">6101 - VENDAS FORA DO ESTADO</option>
                        <option value="5902">5902 - RETORNO DE MERCADORIA</option>
                        <option value="5124">5124 - INDUSTRIALIZAÇÃO</option>
                        <option value="5901">5901 - REMESSA P/INDUSTRIALIZAÇÃO POR ENCOMENDA</option>
                        <option value="6910">6910 - REMESSA EM BONIFICAÇÃO, DOAÇÃO OU BRINDE</option>
                        <option value="5202 ">5202 - DEVOLUÇÃO DE COMPRA PARA COMERCIALIZAÇÃO</option>
                        <option value="5949 ">5949 - REMESSA OU RETORNO DE LOCAÇÃO DE BENS</option>

                        <option value="2209">2209 - DEVOLUCAO DE MERCADORIA</option>
                        <option value="1201">1201 - NOTA ENTRADA</option>
                        <option value="5903">5903 - RETORNO DE MERC RECEBIDA IND NAO APLIC REFER PROCESSO</option>
                        <option value="5124">5124 - INDUSTRIALIZACAO</option>
                        
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-5">
                <hr>
            </div>
            <div class="col-auto">Informações do Cliente</div>
            <div class="col">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label for="nomeCli">Nome do Cliente</label>
                <div class="input-group">
                    <input readonly id="nomeCli" name="nomeCli" type="text" class="form-control" value="{{$nfe['nomeCli'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-3">
                <label for="cpf_cnpjCli">CPF / CNPJ</label>
                <div class="input-group">
                    <input readonly id="cpf_cnpjCli" name="cpf_cnpjCli" type="text" class="form-control" value="{{$nfe['cpf_cnpjCli'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-3">
                <label for="emailCli">Email</label>
                <div class="input-group">
                    <input readonly id="emailCli" name="emailCli" type="text" class="form-control" value="{{$nfe['emailCli'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="ieCli">Inscrição Estadual</label>
                <div class="input-group">
                    <input readonly id="ieCli" name="ieCli" type="text" class="form-control" value="{{$nfe['ieCli'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-1">
                <label for="ufCli">UF</label>
                <div class="input-group">
                    <input readonly id="ufCli" name="ufCli" type="text" class="form-control" value="{{$nfe['ufCli'] ?? '' }}">
                </div>
            </div>

        </div>
        <br>

        <div class="row">
            <div class="col-md-5">
                <hr>
            </div>
            <div class="col-auto">Forma de Pagamento</div>
            <div class="col">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-2">
                <label for="formaPag">Forma de Pag</label>
                <div class="input-group">
                    <select id="formaPag" name="formaPag" class="custom-select">
                        <option value=1>A vista</option>
                        <option value=2>A prazo</option>
                        <option value=3>Outros</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="numParc">N° de Parcelas</label>
                <div class="input-group">
                    <input id="numParc" name="numParc" type="number" min="1" class="form-control" value="{{$nfe['numParc'] ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="btnParcela" data-toggle="modal" data-target="#modalParcelas"><i class="fas fa-pen"></i></button>
                    </div>
                </div>
            </div>



            <div class="form-group col-md-2">
                <label for="modFrete">Frete por Conta</label>
                <div class="input-group">
                    <select id="modFrete" name="modFrete" class="custom-select">
                        <option value=0>Emitente</option>
                        <option value=1>Destinatario</option>
                        <option value=2>Terceiros</option>
                        <option value=9>Sem Frete</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="valorFrete">Valor do Frete</label>
                <div class="input-group">
                    <input id="valorFrete" name="valorFrete" type="number" min="0" step="0.01" class="form-control" value="{{$nfe['valorFrete'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-3">
                <label for="meioPagto">Meio de Pagamento</label>
                <div class="input-group">
                    <select id="meioPagto" name="meioPagto" class="custom-select">
                        <option value='Boleto'>Boleto Bancario</option>
                        <option value='Dinheiro'>Dinheiro</option>
                        <option value='Credito'>Cartão de Crédito</option>
                        <option value='Debito'>Cartão de Débito</option>
                        <option value='Outros'>Outros</option>
                    </select>
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-5">
                <hr>
            </div>
            <div class="col-auto">Transportadora</div>
            <div class="col">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="nomeTransp">Nome da Transportadora</label>
                <div class="input-group">
                    <input value="{{$nfe['ID_transp'] ?? '' }}" style="display:none" name="ID_transp" id="ID_transp" type="text" class="typeahead form-control " style="margin:0px auto;width:360px;">
                    <input value="{{$nfe['nomeTransp'] ?? '' }}" class="typeahead form-control" name="nomeTransp" id="nomeTransp" style="margin:0px auto;width:260px;" type="text">
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="cpf_cnpjTransp">CPF / CNPJ</label>
                <div class="input-group">
                    <input readonly id="cpf_cnpjTransp" name="cpf_cnpjTransp" type="text" class="form-control" value="{{$nfe['cpf_cnpjTransp'] ?? '' }}">
                </div>
            </div>

            <div class="form-group col-md-4">
                <label for="contatoTransp">Contato</label>
                <div class="input-group">
                    <input readonly id="contatoTransp" name="contatoTransp" type="text" class="form-control" value="{{$nfe['contatoTransp'] ?? '' }}">
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