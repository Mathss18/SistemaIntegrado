$(function () {

    $('#pedidoForm').submit(function (e) {
        var route = $('#pedidoForm').data('route');
        var form_data = new FormData(this);
        var OF = $('#OF').val();
        var codigo = $('#ttexto1').val();
        var qtde = $('#quantidade').val();
        var tipo = $('#tipo option:selected').text();
        //Variaveis para zerar
        var qtdee = document.getElementById('quantidade');
        var cdg = document.getElementById('ttexto1');
        var cdg2 = document.getElementById('codigo');
        var path = document.getElementsByClassName('path');
        var iframe = document.getElementById('fotoProduto');
        $.ajax({
            type: 'POST',
            url: route,
            data: form_data,
            processData: false,
            contentType: false,
            success: function (Response) {
                alert('Produto Adicionado!')
                //Conta a qtde de produtos
                $('#contadorProd').html(function (i, val) {
                    return val * 1 + 1;
                });
                //Adiciona os produtos na tabela de historico
                var content = "<tr><td>" + OF+ "</td><td>" +codigo+"</td><td>" + qtde + "</td><td>" + tipo + "</td></tr>";
                $("#tblProd").append(content);
                //Desabilita form
                $("#ID_cliente").attr('readonly', true);
                $("#ttexto").attr('readonly', true);
                $("#OF").attr('readonly', true);
                $("#ID_cliente").attr('readonly', true);
                //$("#data_entrega").attr('readonly', true);

                //Zerando valores 
                qtdee.value = '';
                cdg.value = '';
                cdg2.value = '';
                iframe.src = "http://localhost/storage/Desenhos/semImagem2.png";
                path[0].value = '';
                path[1].value = '';

            }
        });

        e.preventDefault();

    });
});