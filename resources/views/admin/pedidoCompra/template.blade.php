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
            <div class="ml-3">
                <button class="btn btn-dark" onClick="atualizarDados()" id="converter-tabela">SALVAR</button>
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
                        <div class="col-3">
                            <h4>PEDIDO DE COMPRA: <u>{{$ultimoPedidoCompra[0]->cod_pedidoCompra}}</u></h4>
                        </div>
                        @if($ultimoPedidoCompra[0]->status == 'Aprovado')
                        <div class="ml-3" style="z-index: 10; position: absolute; right: 50%; top:50%; left:10%; opacity: 75%;">
                            <img src="{{asset('seloAprovado2.png')}}" alt="">
                        </div>
                        @endif
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
                        <div class="col-3">
                            <h4>PEDIDO DE COMPRA: <u>{{$ultimoPedidoCompra[0]->cod_pedidoCompra}}</u></h4>
                        </div>
                        @if($ultimoPedidoCompra[0]->status == 'Aprovado')
                        <div class="ml-3" style="z-index: 10; position: absolute; right: 50%; top:50%; left:10%; opacity: 75%;">
                            <img src="{{asset('seloAprovado2.png')}}" alt="">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif


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
                                    <th scope="col" style="display: none;">ID_Prod</th>
                                    <th scope="col" style="display: none;">ID</th>
                                    <th scope="col" style="display: none;">cod_pedidoCompra</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Qtde</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Total</th>
                                    <th scope="col" class="no-print"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produtos as $produto)
                                <tr>
                                    <td style="display: none;">{{$produto[0]->ID_produto_fornecedor}}</td>
                                    <td style="display: none;">{{$ultimoPedidoCompra[$loop->index]->ID_pedidoCompra}}</td>
                                    <td style="display: none;">{{$ultimoPedidoCompra[$loop->index]->cod_pedidoCompra}}</td>
                                    <td>{{$produto[0]->cod_fabricacao}}</td>
                                    <td>{{$produto[0]->descricao}}</td>
                                    <td contenteditable class="editable">{{number_format($ultimoPedidoCompra[$loop->index]->qtde_prod,2,'.','')}}</td>
                                    <td contenteditable class="editable">{{number_format($produto[0]->preco_venda,2,'.',',')}}</td>
                                    <td contenteditable class="total">{{number_format($ultimoPedidoCompra[$loop->index]->qtde_prod*$produto[0]->preco_venda,2,',','.')}}</td>
                                    <td><a class="no-print" onclick="deletaRow(this);" href="#"><i class="fas fa-trash"></i></a></td>
                                    <a style='display:none;'>{{$total += $ultimoPedidoCompra[$loop->index]->qtde_prod*$produto[0]->preco_venda}}</a>
                                    
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><p style="display: none;">{{$ultimoPedidoCompra[0]->cod_pedidoCompra}}</p></td>
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

    <div id="rotas" style="display: none;" data-route-atualizar-pedidoCompra="{{route('pedidoCompra.atualizar')}}">
    </div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/table-to-json/1.0.0/jquery.tabletojson.min.js" integrity="sha512-kq3madMG50UJqYNMbXKO3loD85v8Mtv6kFqj7U9MMpLXHGNO87v0I26anynXAuERIM08MHNof1SDaasfw9hXjg==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
    function deletaRow(obj){
    var row = obj.parentNode.parentNode.remove();
    
    var linhas = document.getElementsByClassName('editable');
    console.log(row);
    calculaTotal(linhas);
    }
</script>

<script>
    function routeAtualizarPedidoCompra() {
        console.log(document.getElementById('rotas').dataset.routeAtualizarPedidocompra);
        return document.getElementById('rotas').dataset.routeAtualizarPedidocompra;
    }
</script>

<script>
    function atualizarDados(){
        var table = $('#tableDT').tableToJSON();
        console.log(table);
        var route = routeAtualizarPedidoCompra();

        $.ajax({
        type: 'POST',
        url: route,
        data: {json: JSON.stringify(table), _token: '{{csrf_token()}}'},
        dataType: 'json',
        success: function (Response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })
                  Toast.fire({
                    icon: 'success',
                    title: 'Alterações salvas com sucesso!'
                  })
            },
            error: function (Response) {
                console.log(Response);
                if(Response.status == 500){
                    let timerInterval
                    Swal.fire({
                    title: 'Excluindo Pedido de Compra',
                    html: 'Excluindo Arquivos <b></b>.',
                    timer: 3500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                            b.textContent = Swal.getTimerLeft()
                            }
                        }
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                    }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.history.back();
                        window.history.back();
                    }
                    })
                }
                else{
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'error',
                        title: 'Erro ao salvar alterações, nada foi feito!'
                    })
                }
            }
        });
    }
</script>

</html>