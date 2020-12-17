<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>OF {{$pedidoFull[0]->OF}}</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/printable.css') }}">

</head>


<body>

    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-info" onClick="window.print()">IMPRIMIR</button>

                <div class="input-group">
                    <input required id="numParc" name="numParc" type="number" min="1" class="form-control" value="{{$nfe['numParc'] ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="btnParcela" data-toggle="modal" data-target="#modalParcelas"><i class="fas fa-pen"></i></button>
                    </div>
                </div>

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
                            <h4>FLEXMOL - INDUSTRIA E COMERCIO DE MOLAS LTDA</h4>
                        </div>
                        <div class="col-3">
                            <h4>OF número: <u>{{$pedidoFull[0]->OF}}</u></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col">
                    <h6><b>CLIENTE: </b>{{$cliente[0]->nome}} &nbsp;&nbsp;&nbsp;&nbsp;<b>CPF/CNPJ:
                        </b>{{$cliente[0]->cpf_cnpj}}</h6>
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
                                    <td>{{$produto->cod_fabricacao}}</td>
                                    <td>{{$produto->descricao}}</td>
                                    <td>{{number_format($pedidoFull[$loop->index]->quantidade,2,',','.')}}</td>
                                    <td>{{number_format($produto->preco_venda,2,',','.')}}</td>
                                    <td>{{number_format($pedidoFull[$loop->index]->quantidade*$produto->preco_venda,2,',','.')}}</td>
                                    <a style='display:none;'>{{$total += $pedidoFull[$loop->index]->quantidade*$produto->preco_venda}}</a>
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
        </div>

        <br>

        <div class="container card-body fundo " style="border: 1px solid black; border-radius: 15px;">
            <div class="row" style="border-bottom: 1px solid gray;">
                <div class="col-2">
                    <img src="https://i.imgur.com/DErSgKM.jpg" alt="">
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col">
                            <h4>FLEXMOL - INDUSTRIA E COMERCIO DE MOLAS LTDA</h4>
                        </div>
                        <div class="col-3">
                            <h4>OF número: <u>{{$pedidoFull[0]->OF}}</u></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col">
                    <h6><b>CLIENTE: </b>{{$cliente[0]->nome}} &nbsp;&nbsp;&nbsp;&nbsp;<b>CPF/CNPJ:
                        </b>{{$cliente[0]->cpf_cnpj}}</h6>
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
                                    <td>{{$produto->cod_fabricacao}}</td>
                                    <td>{{$produto->descricao}}</td>
                                    <td>{{number_format($pedidoFull[$loop->index]->quantidade,2,',','.')}}</td>
                                    <td>{{number_format($produto->preco_venda,2,',','.')}}</td>
                                    <td>{{number_format($pedidoFull[$loop->index]->quantidade*$produto->preco_venda,2,',','.')}}</td>

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
        </div>
    </div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</html>