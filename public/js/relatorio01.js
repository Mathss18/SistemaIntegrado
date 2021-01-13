function routeGerarRelatorio() {
    console.log(document.getElementById('rotas').dataset.routeGerarRalatorio01);
    return document.getElementById('rotas').dataset.routeGerarRalatorio01;
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
            fim: fim
            },
        success: function (data) {
            console.log("SUCCESS : ", data);
            alert('oi');

        },
        error: function (e) {
            console.log("ERROR : ", e);

        }
    });
}

