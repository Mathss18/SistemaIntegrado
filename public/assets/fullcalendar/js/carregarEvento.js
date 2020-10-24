
$(function () {

    $('.date').mask('00/00/0000');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".deleteEvent").click(function(){
        let id = $("#id").val();
        let route;
        let newEvent = {
           id: id,
           _method: "DELETE"
        };
        route = routeEventsExcluir();
        sendEvent(route,newEvent,'DELETE');
    });

    $(".saveEvent").click(function(){
            
            let id = $("#id").val();
            let title = $("#title").val();
            let start = moment($("#start").val(),"DD/MM/YYYY").format("YYYY-MM-DD");
            let end = null;
            let description = $("#description").val();
            let ID_cliente = '';
            let ID_fornecedor = '';
            let favorecido = '';
            let tipoCliForne = $('#tipoCliForne').val();
            console.log(tipoCliForne);

            if(tipoCliForne == 'forne'){
                favorecido = $("#ttexto1").val();
                ID_fornecedor = $("#ID_fornecedor").val();
                ID_cliente = null;

            }
            else{
                favorecido = $("#ttexto").val();
                ID_cliente = $("#ID_cliente").val();
                ID_fornecedor = null;
            }

            
            
            

            let newEvent = {
                title: title,
                start: start,
                end: end,
                description: description,
                firma: 'FM',
                ID_cliente: ID_cliente,
                ID_fornecedor: ID_fornecedor,
                favorecido: favorecido
            };

            let route;
            if(id==''){
                route = routeEventsInserir();
                sendEvent(route,newEvent,'POST');
            }
            else{
                route = routeEventsAtualizar();
                newEvent.id = id;
                newEvent._method = 'PUT';
                console.log(newEvent);
                sendEvent(route,newEvent,'PUT');
            }
    });

});

function sendEvent(route, data_, type) {
    console.log(route, data_,type);
    $.ajax({
        url: route,
        data: data_,
        method: type,
        dataType: 'json',
        success: function (json) {
            if (json) {
                
                objCalendar.refetchEvents();
            }

        }
    });
}

function routeEventsCarregar() {
    return document.getElementById('calendar').dataset.routeCarregarEventos;
}

function routeEventsAtualizar() {
   return document.getElementById('calendar').dataset.routeAtualizarEvento;
}
function routeEventsInserir() {
    return document.getElementById('calendar').dataset.routeInserirEvento;
}
function routeEventsExcluir() {
    return document.getElementById('calendar').dataset.routeExcluirEvento;
}

function resetarForm(form){
    $(form)[0].reset();

    $('#ttexto').attr('type','text');
    $('#ID_cliente').attr('type','text');
    $('#ID_cliente').css('display','none');
    $('#clienteModal').css('display','block');

    $('#ttexto1').attr('type','text');
    $('#ID_fornecedor').attr('type','text');
    $('#ID_fornecedor').css('display','none');
    $('#fornecedorModal').css('display','block');
}