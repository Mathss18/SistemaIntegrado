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
            </div>
        </div>
    </div>
    <br>


    <div id="printable" class="corpoOrcamento">
        <div class="container card-body fundo " style="border: 1px solid black; border-radius: 15px;">

            @if($firma == 'FM')
            <div class="row" style="border-bottom: 1px solid gray; border-radius: 15;">
                <div class="col-2">
                    <img src="https://i.imgur.com/DErSgKM.jpg" alt="">
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col">
                            <h4>FLEXMOL - INDUSTRIA E COMERCIO DE MOLAS LTDA - ME</h4>
                            <h6><b>Endereço:</b> RUA JOSE PASSARELA &nbsp;&nbsp;&nbsp;&nbsp; <b>Número:</b> 240 &nbsp;&nbsp;&nbsp;&nbsp; <b>Telefone:</b> (19) 3434-5840</h6>
                            <h6><b>Bairro:</b> JARDIM SAO JORGE &nbsp;&nbsp;&nbsp;&nbsp; <b>Cidade:</b> Piracicaba &nbsp;&nbsp;&nbsp;&nbsp; <b>Email:</b> flexmol@flexmol.com.br</h6>
                        </div>
                        <div class="col-2">
                            <h4>Venda: <u>{{$pedidoFull[0]->OF}}</u></h4>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row" style="border-bottom: 1px solid gray; border-radius: 15;">
                <div class="col-3">
                    <img src="https://i.imgur.com/WsHypqu.jpg" alt="">
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col">
                            <h4>METAL FLEX - INDUSTRIA E COMERCIO DE MOLAS LTDA - ME</h4>
                            <h6><b>Rua:</b> RUA PRINCESA ISABEL, 70 &nbsp;&nbsp; <b>Cidade:</b> Piracicaba &nbsp;&nbsp; <b>Telefone:</b> (19)3422-7978</h6>
                            <h6><b>Bairro:</b> JARDIM PACAEMBU &nbsp;&nbsp;<b>Email:</b> atendimento@metalflex.ind.br</h6>
                        </div>
                        <div class="col-2">
                            <h4>Venda: <u>{{$pedidoFull[0]->OF}}</u></h4>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="row">
                <div class="col-2">
                </div>
                <div class="col">
                    <h6><b>Cliente: </b>{{$cliente[0]->nome}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Telefone:</b>{{$cliente[0]->telefone}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Email: </b>{{$cliente[0]->email}}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                </div>
                @if($cliente[0]->logradouro != null)
                <div class="col">
                    <h6><b>Logradouro: </b>{{$cliente[0]->logradouro}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Número:</b> {{$cliente[0]->numero}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Cidade: </b> {{$cliente[0]->cidade}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Bairro: </b> {{$cliente[0]->bairro}}</h6>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col">
                    <div class="card-body" style=" height:400px;">
                        <table id="tableDT" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Qtde</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produtos as $produto)

                                <tr>
                                    <td contenteditable='true'>{{$produto->descricao}}</td>
                                    <td class="editable" contenteditable='true'>{{number_format($pedidoFull[$loop->index]->quantidade,2,'.',',')}}</td>
                                    <td class="editable" contenteditable='true'>{{number_format($produto->preco_venda,2,'.',',')}}</td>
                                    <td class='total'>{{number_format($pedidoFull[$loop->index]->quantidade*$produto->preco_venda,2,'.',',')}}</td>
                                    <a style='display:none;'>{{$total += $pedidoFull[$loop->index]->quantidade*$produto->preco_venda}}</a>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><b>VALOR FINAL:</b></td>
                                    <td contenteditable='true'><b style="color: red;">R$: <a id="totalFinal">{{number_format($total,2,'.',',')}}</a></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                </div>
            </div>
            <!--  Rodape   -->

            <div class="row">
                <div class="col-md-7">
                    <h6 contenteditable>Observação:&nbsp;</h6>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <h6>Data de hoje: {{$dataHoje}}</h6>
                </div>
                <div class="col">
                    <h6 contenteditable>Data de Vencimento:&nbsp;</h6>
                </div>
                <div class="col">
                    <a>Assinatura: ____________________________________</a>
                </div>
            </div>
            <!-- Fim Rodape   -->

        </div>


        <br><br><br>

        <!-- SEGUNDA VIA -->
        <div class="container card-body fundo " style="border: 1px solid black; border-radius: 15px;">

            @if($firma == 'FM')
            <div class="row" style="border-bottom: 1px solid gray; border-radius: 15;">
                <div class="col-2">
                    <img src="https://i.imgur.com/DErSgKM.jpg" alt="">
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col">
                            <h4>FLEXMOL - INDUSTRIA E COMERCIO DE MOLAS LTDA - ME</h4>
                            <h6><b>Endereço:</b> RUA JOSE PASSARELA &nbsp;&nbsp;&nbsp;&nbsp; <b>Número:</b> 240 &nbsp;&nbsp;&nbsp;&nbsp; <b>Telefone:</b> (19) 3434-5840</h6>
                            <h6><b>Bairro:</b> JARDIM SAO JORGE &nbsp;&nbsp;&nbsp;&nbsp; <b>Cidade:</b> Piracicaba &nbsp;&nbsp;&nbsp;&nbsp; <b>Email:</b> flexmol@flexmol.com.br</h6>
                        </div>
                        <div class="col-2">
                            <h4>Venda: <u>{{$pedidoFull[0]->OF}}</u></h4>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row" style="border-bottom: 1px solid gray; border-radius: 15;">
                <div class="col-3">
                    <img src="https://i.imgur.com/WsHypqu.jpg" alt="">
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col">
                            <h4>METAL FLEX - INDUSTRIA E COMERCIO DE MOLAS LTDA - ME</h4>
                            <h6><b>Rua:</b> RUA PRINCESA ISABEL, 70 &nbsp;&nbsp; <b>Cidade:</b> Piracicaba &nbsp;&nbsp; <b>Telefone:</b> (19)3422-7978</h6>
                            <h6><b>Bairro:</b> JARDIM PACAEMBU &nbsp;&nbsp;<b>Email:</b> atendimento@metalflex.ind.br</h6>
                        </div>
                        <div class="col-2">
                            <h4>Venda: <u>{{$pedidoFull[0]->OF}}</u></h4>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="row">
                <div class="col-2">
                </div>
                <div class="col">
                    <h6><b>Cliente: </b>{{$cliente[0]->nome}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Telefone:</b>{{$cliente[0]->telefone}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Email: </b>{{$cliente[0]->email}}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                </div>
                @if($cliente[0]->logradouro != null)
                <div class="col">
                    <h6><b>Logradouro: </b>{{$cliente[0]->logradouro}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Número:</b> {{$cliente[0]->numero}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Cidade: </b> {{$cliente[0]->cidade}} &nbsp;&nbsp;&nbsp;&nbsp;<b>Bairro: </b> {{$cliente[0]->bairro}}</h6>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col">
                    <div class="card-body" style=" height:400px;">
                        <table id="tableDT" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Qtde</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produtos as $produto)

                                <tr>
                                    <td contenteditable='true'>{{$produto->descricao}}</td>
                                    <td class="editable1" contenteditable='true'>{{number_format($pedidoFull[$loop->index]->quantidade,2,'.',',')}}</td>
                                    <td class="editable1" contenteditable='true'>{{number_format($produto->preco_venda,2,'.',',')}}</td>
                                    <td class='total1'>{{number_format($pedidoFull[$loop->index]->quantidade*$produto->preco_venda,2,'.',',')}}</td>
                                    <a style='display:none;'>{{$total += $pedidoFull[$loop->index]->quantidade*$produto->preco_venda}}</a>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><b>VALOR FINAL:</b></td>
                                    <td contenteditable='true'><b style="color: red;">R$: <a id="totalFinal1">{{number_format($total,2,'.',',')}}</a></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                </div>
            </div>
            <!--  Rodape   -->
            <div class="row">
                <div class="col-md-7">
                    <h6 contenteditable>Observação:&nbsp;</h6>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <h6>Data de hoje: {{$dataHoje}}</h6>
                </div>
                <div class="col">
                    <h6 contenteditable>Data de Vencimento:&nbsp;</h6>
                </div>
                <div class="col">
                    <a>Assinatura: ____________________________________</a>
                </div>
            </div>
            <!-- Fim Rodape   -->

        </div>

    </div>
    <br>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    var linhas = document.getElementsByClassName('editable');
    var linhas1 = document.getElementsByClassName('editable1');
    // ADICIONA EVENTO NAS TD DA TABELA
    for (let i = 0; i < linhas.length; i++) {
        linhas[i].addEventListener("input", function() {
            calculaTotal(linhas, linhas1);
        })
    }

    // ===== FAZ O CALCULO DO VALOR TOTAL ====
    function calculaTotal(linhas, linhas1) {

        var totais = document.getElementsByClassName('total');
        var totais1 = document.getElementsByClassName('total1');
        var totalFinal = document.getElementById('totalFinal');
        var totalFinal1 = document.getElementById('totalFinal1');
        var tableLength = linhas.length / 2;
        var aux = 0;
        var totalAux = 0.00;

        for (var i = 0; i < tableLength; i++) {
            totais[i].innerHTML = linhas[i + aux].innerHTML * linhas[i + 1 + aux].innerHTML

            totalAux = totalAux + parseFloat(totais[i].innerHTML);
            totalFinal.innerHTML = totalAux.toFixed(2);

            totais1[i].innerHTML = totais[i].innerHTML;
            linhas1[i + aux].innerHTML = linhas[i + aux].innerHTML;
            linhas1[i + 1 + aux].innerHTML = linhas[i + 1 + aux].innerHTML;
            totalFinal1.innerHTML = totalFinal.innerHTML;

            aux++;
        }
    }
</script>

</html>