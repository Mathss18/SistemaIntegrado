function routeGerarRelatorio() {
    console.log(document.getElementById('rotas').dataset.routeGerarRalatorio04);
    return document.getElementById('rotas').dataset.routeGerarRalatorio04;
}

function gerarRelatorio(){
    var form = $('#formData')[0];
    var inicio = $('#inicio').val();
    var fim = $('#fim').val();
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
            },
        success: function (data) {
            console.log(data);
            if(data.message == 'error'){
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Nenhum valor encontrado.',
                  })
            }
            else{
                //REFRESH LISTA 01
                $('div.list-container01').fadeOut();
                setTimeout(function(){ 
                    $('div.list-container01').html(data.lista01);
                }, 300); 
                $('div.list-container01').fadeIn();

                //REFRESH LISTA 02
                $('div.list-container02').fadeOut();
                setTimeout(function(){ 
                    $('div.list-container02').html(data.lista02);
                }, 300); 
                $('div.list-container02').fadeIn();

        }

        },
        error: function (e) {
            console.log("ERROR : ", e);
            alert('Erro de comunicação com o banco de dados.');

        }
    });
}



