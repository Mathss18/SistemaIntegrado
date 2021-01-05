$(function () {

    $('#pedidoCompraForm').submit(function (e) {
        var route = $('#pedidoCompraForm').data('route');
        var form_data = new FormData(this);
        var codOrca = $('#cod_pedidoCompra').val();
        var codigo = $('#ttexto1').val();
        var qtde = $('#qtde_prod').val();
        //Variaveis para zerar
        var qtdee = document.getElementById('qtde_prod');
        var cdg = document.getElementById('ttexto1');
        var cdg2 = document.getElementById('codigo');
        var path = document.getElementsByClassName('path');
        var iframe = document.getElementById('fotoProduto');
        var idProdForne = document.getElementById('ID_produto_forncedor');

        $.ajax({
            type: 'POST',
            url: route,
            data: form_data,
            processData: false,
            contentType: false,
            success: function (response) {
                alert('Produto Adicionado!')
            
                //Conta a qtde de produtos
                $('#contadorProd').html(function (i, val) {
                    return val * 1 + 1;
                });
                //Adiciona os produtos na tabela de historico
                var content = "<tr><td>" + codOrca+ "</td><td>" +codigo+"</td><td>" + qtde + "</td></tr>";
                $("#tblProd").append(content);
                //Desabilita form
                $("#ID_fornecedor").attr('readonly', true);
                $("#ttexto").attr('readonly', true);
                $("#cod_pedidoCompr").attr('readonly', true);
                $("#ID_fornecedor").attr('readonly', true);
                $("#data").attr('readonly', true);
                $("#cond_pagto").attr('readonly', true);
                $("#prazo_entrega").attr('readonly', true);
                $("#obs").attr('readonly', true);

                //Zerando valores 
                qtdee.value = '';
                cdg.value = '';
                cdg2.value = '';
                iframe.src = "http://localhost/storage/Desenhos/semImagem2.png";
                path[0].value = '';
                path[1].value = '';
                idProdForne.value = '';

            }
        });

        e.preventDefault();

    });
});