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
                            <h4>OF número: <u>{{$pedidoFull[0]->OF}}</u></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                </div>
                <div class="col">
                    <h6><b>CLIENTE: </b>{{$cliente[0]->nome}}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card-body">
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
                                    <td class="editable"  contenteditable='true'>{{number_format($pedidoFull[$loop->index]->quantidade,2,'.',',')}}</td>
                                    <td class="editable"  contenteditable='true'>{{number_format($produto->preco_venda,2,'.',',')}}</td>
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
                <div class="col-md-8">
                    <h6>Data: {{$dataHoje}}</h6>
                </div>
                <div class="col">
                    <a>Assinatura: _______________________________</a>
                </div>
            </div>
            <!-- Fim Rodape   -->
            
        </div>
        

        <br>

    </div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    var linhas = document.getElementsByClassName('editable');
    // ADICIONA EVENTO NAS TD DA TABELA
    for(let i = 0; i < linhas.length; i++) {
        linhas[i].addEventListener("input", function() {
            calculaTotal(linhas);
    })
    }

    // ===== FAZ O CALCULO DO VALOR TOTAL ====
    function calculaTotal(linhas){
       
        var totais = document.getElementsByClassName('total');
        var totalFinal = document.getElementById('totalFinal');
        var tableLength = linhas.length/2;
        var aux=0;
        var totalAux = 0.00;

       for (var i = 0; i < tableLength; i++) {
            totais[i].innerHTML = linhas[i+aux].innerHTML * linhas[i+1+aux].innerHTML 
            aux++;
            totalAux = totalAux + parseFloat(totais[i].innerHTML);
            totalFinal.innerHTML = totalAux.toFixed(2);
            
       }
    }

</script>
</html>