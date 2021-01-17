function routeGerarRelatorio() {
    console.log(document.getElementById('rotas').dataset.routeGerarRalatorio01);
    return document.getElementById('rotas').dataset.routeGerarRalatorio01;
}

function gerarRelatorio(){
    var form = $('#formData')[0];
    var inicio = $('#inicio').val();
    var fim = $('#fim').val();
    var situacao =  $('#situacao').val();
    var data = new FormData(form);
    console.log(form);
    var route = routeGerarRelatorio();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: route,
        data: {
            inicio: inicio,
            fim: fim,
            situacao: situacao
            },
        success: function (data) {
            console.log("SUCCESS : ", data);
            //REFRESH TABELA 01
            $('div.table-container01').fadeOut();
            setTimeout(function(){ 
                $('div.table-container01').html(data.tabela01);
            }, 300); 
            $('div.table-container01').fadeIn();

            //REFRESH TABELA 02
            $('div.table-container02').fadeOut();
            setTimeout(function(){ 
                $('div.table-container02').html(data.tabela02);
            }, 300); 
            $('div.table-container02').fadeIn();

            //REFRESH TABELA 03
            $('div.table-container3').fadeOut();
            setTimeout(function(){ 
                $('div.table-container03').html(data.tabela03);
            }, 300); 
            $('div.table-container03').fadeIn();
            
            

        },
        error: function (e) {
            console.log("ERROR : ", e);
            alert('Erro ao trazer relatório.');

        }
    });
}

