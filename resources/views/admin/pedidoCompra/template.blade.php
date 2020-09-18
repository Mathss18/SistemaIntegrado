<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>Pedido Compra Flex-Mol</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/printable.css') }}">

</head>


<body>
    
        <br>
        <div class="container">
            <div class="row">
                <div class="col">
                    <button class="btn btn-info" onClick="window.print()">IMPRIMIR</button>
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
                            <h4>PEDIDO DE COMPRA: N°: <u>{{$ultimoPedidoCompra[0]->cod_pedidoCompra}}</u></h4>
                        </div>
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
                                    <td>{{number_format($ultimoPedidoCompra[$loop->index]->qtde_prod,2,',','.')}}</td>
                                    <td>{{number_format($produto[0]->preco_venda,4,',','.')}}</td>
                                    <td>{{number_format($ultimoPedidoCompra[$loop->index]->qtde_prod*$produto[0]->preco_venda,4,',','.')}}</td>
                                    <a style='display:none;'>{{$total += $ultimoPedidoCompra[$loop->index]->qtde_prod*$produto[0]->preco_venda}}</a>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>VALOR FINAL:</b></td>
                                    <td><b style="color: red;">R$: {{number_format($total,2,',','.')}}</b></td>
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
                    <h6><b>Observações: </b>{{$ultimoPedidoCompra[0]->obs}} &nbsp;&nbsp;&nbsp;&nbsp;</h6>
                </div>
                @endif

                @if($ultimoPedidoCompra[0]->cond_pagto != null)
                <div class="col">
                    <h6><b>Condições de Pagamento: </b>{{$ultimoPedidoCompra[0]->cond_pagto}} &nbsp;&nbsp;&nbsp;&nbsp;</h6>
                </div>
                @endif

                @if($ultimoPedidoCompra[0]->prazo_entrega != null)
                <div class="col">
                    <h6><b>Prazo de entrega: </b>{{$ultimoPedidoCompra[0]->prazo_entrega}} &nbsp;&nbsp;&nbsp;&nbsp;</h6>
                </div>
                @endif

            </div>
            <br>
            <div class="row">
                <div class="col-md-8">
                    <h6>Data: {{$ultimoPedidoCompra[0]->data}}</h6>
                </div>
                <div class="col">
                    <a>Assinatura: _______________________________</a>
                </div>
            </div>
        </div>

    </div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</html>