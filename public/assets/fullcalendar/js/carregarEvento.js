
$(function () {

    $('.date').mask('00/00/0000');

    $('#categoria').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        console.log(valueSelected);
        switch (valueSelected) {
            case 'fornecedor':

                $("#fornecedorModal").show();
                $("#ID_fornecedor").prop("disabled", false);
                $("#ttexto1").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'fornecedor');
                break;
            case 'transportadora':
                $("#transportadoraModal").show();
                $("#ID_transportadora").prop("disabled", false);
                $("#ttexto2").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'transportadora');
                break;
            case 'funcionario':
                $("#funcionarioModal").show();
                $("#ID_funcionario").prop("disabled", false);
                $("#ttexto3").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'funcionario');
                break;
            case 'imposto':
                $("#impostoModal").show();
                $("#ID_imposto").prop("disabled", false);
                $("#ttexto4").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'imposto');
                break;
            case 'investimento':
                $("#investimentoModal").show();
                $("#ID_investimento").prop("disabled", false);
                $("#ttexto5").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'investimento');
                break;
            case 'cliente':
                $("#clienteModal").show();
                $("#ID_cliente").prop("disabled", false);
                $("#ttexto").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'cliente');
                break;
            default:
            // code block
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".deleteEvent").click(function () {
        Swal.fire({
            title: 'Tem Certeza?',
            text: "Isso não poderá ser revertido!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $("#id").val();
                let route;
                let newEvent = {
                    id: id,
                    _method: "DELETE"
                };
                route = routeEventsExcluir();
                sendEvent(route, newEvent, 'DELETE');

            }
        })

    });

    $(".saveEvent").click(function () {

        //============= VARIAVEIS COMUNS AOS 2 TIPOS DE TRANSAÇÃO ==============
        let id = $("#id").val();
        let title = $("#title").val();
        let start = moment($("#start").val(), "DD/MM/YYYY").format("YYYY-MM-DD");
        let end = null;
        let description = $("#description").val();
        let ID_banco = $('#banco').val();
        let tipoCliForne = $('#tipoCliForne').val();
        let valor = $('#valor').val();
        let numero = $('#numero').val();
        let situacao = $('#situacao').val();

        let corEntrada = '#8cf19f';
        let corSaida = '#f1948c'
        //console.log(situacao.val());
        //break;
        //============= VARIAVEIS DIFERENTES AOS 2 TIPOS DE TRANSAÇÃO ==============
        let ID_cliente = '';
        let ID_fornecedor = '';
        let ID_funcionario = '';
        let ID_transportadora = '';
        let favorecido = '';
        let color = '';
        let tipoFav = '';



        if (tipoCliForne == 'fornecedor') {
            favorecido = $("#ttexto1").val();
            ID_fornecedor = $("#ID_fornecedor").val();
            color = corSaida;
            tipoFav = 'fornecedor';

        }
        else if (tipoCliForne == 'transportadora') {
            favorecido = $("#ttexto2").val();
            ID_transportadora = $("#ID_transportadora").val();
            color = corSaida;
            tipoFav = 'transportadora';

        }
        else if (tipoCliForne == 'funcionario') {
            favorecido = $("#ttexto3").val();
            ID_funcionario = $("#ID_funcionario").val();
            color = corSaida;
            tipoFav = 'funcionario';

        }
        else if (tipoCliForne == 'imposto') {
            favorecido = $("#ttexto4").val();
            color = corSaida;
            tipoFav = 'imposto';

        }
        else if (tipoCliForne == 'investimento') {
            favorecido = $("#ttexto5").val();
            color = corSaida;
            tipoFav = 'investimento';

        }
        else if (tipoCliForne == 'cliente') {
            favorecido = $("#ttexto").val();
            ID_cliente = $("#ID_cliente").val();
            color = corEntrada;
            tipoFav = 'cliente';
        }
        let newEvent = {
            title: title,
            start: start,
            end: end,
            color: color,
            description: description,
            firma: 'FM',
            ID_cliente: ID_cliente,
            ID_fornecedor: ID_fornecedor,
            ID_funcionario: ID_funcionario,
            ID_transportadora: ID_transportadora,
            tipoFav: tipoFav,
            favorecido: favorecido,
            ID_banco: ID_banco,
            valor: valor,
            numero: numero,
            situacao: situacao

        };

        let route;
        if (id == '') {
            route = routeEventsInserir();
            sendEvent(route, newEvent, 'POST');

            $('#modalCalendario').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
        else {
            route = routeEventsAtualizar();
            newEvent.id = id;
            newEvent._method = 'PUT';
            sendEvent(route, newEvent, 'PUT');

            $('#modalCalendario').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();

        }
    });

});

function sendEvent(route, data_, type) {
    console.log('SendEvt: ' + route, data_, type);
    $.ajax({
        url: route,
        data: data_,
        method: type,
        dataType: 'json',
        success: function (json) {
            if (json) {
                try {
                    objCalendar.refetchEvents();
                } catch (error) {
                    location.reload();
                }
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: 'Executado com sucesso!'
                })
            }

        },
        error: function () {
            try {
                objCalendar.refetchEvents();
            } catch (error) {
                location.reload();
            }
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                title: 'Erro, nada foi feito!'
            })
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

function resetarForm(form) {
    $(form)[0].reset();

    $('#id').val('');

    //ESCONDENDO OS INPUTS
    $("option:selected").removeAttr("selected");
    $("#inputsModal").css('display', 'none');

    //RESETANDO PARTE DO CLIENTE
    $("#clienteModal").hide();
    $("#ID_cliente").prop("disabled", true);
    $("#ttexto").prop("disabled", true);

    //RE-HABILITANDO O SELECT DE CATEGORIAS
    $("#categoria").val('');
    $("#categoria option").removeAttr("selected");
    $("#categoria option").attr('disabled', false);

    //DESABILITANDO E ESCONDENDO OS  DEMAIS INPUTS
    $("#fornecedorModal").hide();
    $("#ID_fornecedor").prop("disabled", true);
    $("#ttexto").prop("disabled", true);

    $("#transportadoraModal").hide();
    $("#ID_transportadora").prop("disabled", true);
    $("#ttexto2").prop("disabled", true);

    $("#funcionarioModal").hide();
    $("#ID_funcionario").prop("disabled", true);
    $("#ttexto3").prop("disabled", true);

    $("#impostoModal").hide();
    $("#ID_imposto").prop("disabled", true);
    $("#ttexto4").prop("disabled", true);

    $("#investimentoModal").hide();
    $("#ID_investimento").prop("disabled", true);
    $("#ttexto5").prop("disabled", true);

    $("#categoria").prop("disabled", false);

    $('#situacao').bootstrapToggle('on');
    $("#situacao").val('on');

}

