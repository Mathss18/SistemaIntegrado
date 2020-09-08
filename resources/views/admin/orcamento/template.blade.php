<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>Orçamento Flex-Mol</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container card-body" style="border: 1px solid black; border-radius: 15px;">
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
                    <div class="col-2">
                        <h4>ORÇAMENTO: N°: <u>{{$ultimoOrca[0]->cod_orcamento}}</u></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col">
                <h6><b>CLIENTE: </b>JETWELLNESS IND E COM DE EQUIPAMENTOS &nbsp;&nbsp;&nbsp;&nbsp;<b>CPF/CNPJ:
                    </b>24.313.053/0001-20</h6>
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
                        @foreach($ultimoOrca as $orca)
                            <tr>
                                <td>{{$orca->ID_produto_cliente}}</td>
                                <td>{{$orca->ID_produto_cliente}}</td>
                                <td>{{$orca->qtde_prod}}</td>
                                <td>{{$orca->ID_produto_cliente}}</td>
                                <td>{{$orca->ID_produto_cliente}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>VALOR FINAL:</b></td>
                                <td><b style="color: red;">448,00</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h6><b>Observações: </b>Autorizado Flex Mol &nbsp;&nbsp;&nbsp;&nbsp;</h6>
                <h6>Data: 25/08/2020</h6>
            </div>
        </div>
    </div>

    

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
    crossorigin="anonymous"></script>

</html>