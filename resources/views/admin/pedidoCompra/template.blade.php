<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>Pedido Compra Flex-Mol</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/printable.css') }}">

</head>


<body>

    <br>
    <div class="container">
        <div class="row">
            <div class='mr-3'>
                <button class="btn btn-info" onClick="window.print()">IMPRIMIR</button>
            </div>
            <div>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalAprovar" onClick="valorFinal()">APROVAR</button>
            </div>
        </div>
    </div>
    <br>


    <div id="printable" class="corpoOrcamento">
        <div class="container card-body fundo " style="border: 1px solid black; border-radius: 15px;">
            <div class="row" style="border-bottom: 1px solid gray;">
                <div class="col-2">
                    <img src="https://i.imgur.com/DErSgKM.jpg" alt="">
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col">
                            <h4>FLEXMOL - INDUSTRIA E COMERCIO DE MOLAS LTDA - ME</h4>
                            <h6><b>Endereço:</b> RUA JOSE PASSARELA &nbsp;&nbsp;&nbsp;&nbsp; <b>Número:</b> 240</h6>
                            <h6><b>Bairro:</b> JARDIM SAO JORGE &nbsp;&nbsp;&nbsp;&nbsp; <b>Cidade:</b> Piracicaba</h6>
                        </div>
                        <div class="col-3">
                            <h4>PEDIDO DE COMPRA: <u>{{$ultimoPedidoCompra[0]->cod_pedidoCompra}}</u></h4>
                        </div>
                        @if($ultimoPedidoCompra[0]->status == 'Aprovado')
                        <div class="ml-3" style="z-index: 10; position: absolute; right: 50%; top:50%; left:10%">
                            <img src="{{asset('seloAprovado2.png')}}" alt="">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col">
                    <h6><b>FORNECEDOR: </b>{{$fornecedor[0]->nome}} &nbsp;&nbsp;&nbsp;&nbsp;<b>CPF/CNPJ:
                        </b>{{$fornecedor[0]->cpf_cnpj}}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card-body">
                        <table id="tableDT" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Qtde</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produtos as $produto)

                                <tr>
                                    <td>{{$produto[0]->cod_fabricacao}}</td>
                                    <td>{{$produto[0]->descricao}}</td>
                                    <td contenteditable class="editable">{{number_format($ultimoPedidoCompra[$loop->index]->qtde_prod,2,'.','')}}</td>
                                    <td contenteditable class="editable">{{number_format($produto[0]->preco_venda,2,'.',',')}}</td>
                                    <td class="total">{{number_format($ultimoPedidoCompra[$loop->index]->qtde_prod*$produto[0]->preco_venda,2,',','.')}}</td>
                                    <a style='display:none;'>{{$total += $ultimoPedidoCompra[$loop->index]->qtde_prod*$produto[0]->preco_venda}}</a>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>VALOR FINAL:</b></td>
                                    <td><a style="color: red; font-weight: bolder;">R$: </a><b style="color: red;" id="totalFinal">{{number_format($total,2,'.','')}}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
                @if($ultimoPedidoCompra[0]->obs != null)
                <div class="col">
                    <h6 contenteditable><b>Observações: </b>{{$ultimoPedidoCompra[0]->obs}} &nbsp;&nbsp;&nbsp;&nbsp;</h6>
                </div>
                @endif

                @if($ultimoPedidoCompra[0]->cond_pagto != null)
                <div class="col">
                    <h6 contenteditable><b>Condições de Pagamento: </b>{{$ultimoPedidoCompra[0]->cond_pagto}} &nbsp;&nbsp;&nbsp;&nbsp;</h6>
                </div>
                @endif

                @if($ultimoPedidoCompra[0]->prazo_entrega != null)
                <div class="col">
                    <h6 contenteditable><b>Prazo de entrega: </b>{{$ultimoPedidoCompra[0]->prazo_entrega}} &nbsp;&nbsp;&nbsp;&nbsp;</h6>
                </div>
                @endif

            </div>
            <br>
            <div class="row">
                <div class="col-md-8">
                    <h6 contenteditable>Data: {{$ultimoPedidoCompra[0]->data}}</h6>
                </div>
                <div class="col">
                    <a>Assinatura: _______________________________</a>
                </div>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalAprovar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Aprovar Pedido de Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('pedidoCompra.aprovar')}}" method="POST">
                        {!! method_field('POST') !!}
                        {!! csrf_field() !!}
                        <div class="row">
                            <!--
                            <div class="form-group col-md-4">
                                <label for="valor">Valor</label>
                                <div class="input-group">
                                    <input id="valor" name="valor" type="number" step="0.01" class="form-control">
                                </div>
                            </div>
                            !-->
                            <div class="form-group ml-2">
                                <input type="text" value="{{$ultimoPedidoCompra[0]->cod_pedidoCompra}}" name="codPedidoCompra" style="display: none;">
                                <input type="text" value="{{$fornecedor[0]->ID_fornecedor}}" name="ID_Fornecedor" style="display: none;">
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="parcelas">Número de  Parcelas</label>
                                        <div class="input-group">
                                            <input id="numParc" name="numParc" type="number" min="1" class="form-control" value="{{$nfe['numParc'] ?? '' }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="btnParcela" data-toggle="modal" data-target="#modalParcelas"><i class="fas fa-pen"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col">
                                        <label for="numeroNfe">Número Nota Fiscal</label>
                                        <div class="input-group">
                                            <input required id="numeroNfe" name="numeroNfe" type="text" class="form-control"">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <table id="tableParcelas" class="table table-striped table-bordered ml-2 mr-2" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Data Vencimento</th>
                                        <th scope="col">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>


                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
<script src="{{ asset('js/parcelaPedidoCompra.js') }}"></script>
<script>
    var linhas = document.getElementsByClassName('editable');

    // ADICIONA EVENTO NAS TD DA TABELA
    for (let i = 0; i < linhas.length; i++) {
        linhas[i].addEventListener("input", function() {
            calculaTotal(linhas);
        })
    }

    // ===== FAZ O CALCULO DO VALOR TOTAL ====
    function calculaTotal(linhas) {

        var totais = document.getElementsByClassName('total');
        var totalFinal = document.getElementById('totalFinal');
        var tableLength = linhas.length / 2;
        var aux = 0;
        var totalAux = 0.00;



        for (var i = 0; i < tableLength; i++) {
            totais[i].innerHTML = linhas[i + aux].innerHTML * linhas[i + 1 + aux].innerHTML

            totalAux = totalAux + parseFloat(totais[i].innerHTML);
            totalFinal.innerHTML = totalAux.toFixed(2);

            aux++;
        }
    }
    /*
    function valorFinal() {
        total = document.getElementById('totalFinal').innerHTML
        valor = document.getElementById('valor')
        console.log(valor);
        valor.value = total;

    }
    */
</script>

</html>