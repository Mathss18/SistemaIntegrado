document.addEventListener('DOMContentLoaded', function () {

    /* initialize the external events
    -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    new FullCalendar.Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function (eventEl) {
            return {
                title: eventEl.innerText.trim()
            }
        }
    });

    //// the individual way to do it
    // var containerEl = document.getElementById('external-events-list');
    // var eventEls = Array.prototype.slice.call(
    //   containerEl.querySelectorAll('.fc-event')
    // );
    // eventEls.forEach(function(eventEl) {
    //   new FullCalendar.Draggable(eventEl, {
    //     eventData: {
    //       title: eventEl.innerText.trim(),
    //     }
    //   });
    // });

    /* initialize the calendar
    -----------------------------------------------------------------*/

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay,listWeek',

        },
        locale: 'pt-br',
        editable: true,
        navLinks: true,
        dayMaxEventRows: true,
        selectable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function (arg) {
            // is the "remove after drop" checkbox checked?
            if (document.getElementById('drop-remove').checked) {
                // if so, remove the element from the "Draggable Events" list
                arg.draggedEl.parentNode.removeChild(arg.draggedEl);
            }
        },
        windowResize: function(arg) {
            objCalendar.refetchEvents();
        },
        eventDrop: function(element){
            let startDate = moment(element.event.start).format("YYYY-MM-DD");
            let endDate = moment(element.event.end).format("YYYY-MM-DD");

            if(endDate=='Invalid date')
                endDate=null;

            let newEvent = {
                _method:'PUT',
                id: element.event.id,
                start: startDate,
                end: endDate

            };

            sendEvent(routeEventsAtualizar(),newEvent,'PUT');
            console.log(element);
        },
        eventClick: function(element){
            //========RESETAR FORM==============
            resetarForm("#formEvt");
            //=======ABRE O MODAL PARA ALTERAR EVENTO===========
            $("#modalCalendario").modal('show');
            $("#modalCalendario #tituloModalCalendar").text('Alterar Evento');
            $("#modalCalendario button.deleteEvent").css('display','flex');
        
            //=======PEGA AS INFOS DO EVT E COLOCA NAS VARIAVEIS===========
            let id = element.event.id;
            let title = element.event.title;
            let start = moment(element.event.start).format("DD/MM/YYYY");
            let description = element.event.extendedProps.description;
            let favorecido = element.event.extendedProps.favorecido;
            let tipoFav = element.event.extendedProps.tipoFav;
            let ID_banco = element.event.extendedProps.ID_banco;
            let valor = element.event.extendedProps.valor;
            let numero = element.event.extendedProps.numero;
            let situacao = element.event.extendedProps.situacao;

            //=======PEGA O TIPO DE FAVORECIDO E COLOCA DENTO DO INPUT 'tipoClieForne'==========
            $('#tipoCliForne').val(tipoFav);

            //=======SE O TIPO FOR CLI TIRA INPUT FORNE==========
            switch(tipoFav) {
                case 'fornecedor':
                    
                    $( "#fornecedorModal" ).show();
                    $( "#ID_fornecedor" ).prop( "disabled", false );
                    $( "#ttexto1" ).prop( "disabled", false );
    
                    $( "#inputsModal" ).show();
                    $( "#categoria" ).prop( "disabled", true );
                    $('#tipoCliForne').attr('value','fornecedor');
                    
                    $("#ttexto1").val(favorecido);
                    $("#categoria").val(tipoFav);
                  break;
                case 'transportadora':
                    $( "#transportadoraModal" ).show();
                    $( "#ID_transportadora" ).prop( "disabled", false );
                    $( "#ttexto2" ).prop( "disabled", false );
    
                    $( "#inputsModal" ).show();
                    $( "#categoria" ).prop( "disabled", true );
                    $('#tipoCliForne').attr('value','transportadora');
                    $("#ttexto2").val(favorecido);
                    $("#categoria").val(tipoFav);
                  break;
                case 'funcionario':
                    $( "#funcionarioModal" ).show();
                    $( "#ID_funcionario" ).prop( "disabled", false );
                    $( "#ttexto3" ).prop( "disabled", false );
    
                    $( "#inputsModal" ).show();
                    $( "#categoria" ).prop( "disabled", true );
                    $('#tipoCliForne').attr('value','funcionario');
                    $("#ttexto3").val(favorecido);
                    $("#categoria").val(tipoFav);
                break;  
                case 'imposto':
                    $( "#impostoModal" ).show();
                    $( "#ID_imposto" ).prop( "disabled", false );
                    $( "#ttexto4" ).prop( "disabled", false );
    
                    $( "#inputsModal" ).show();
                    $( "#categoria" ).prop( "disabled", true );
                    $('#tipoCliForne').attr('value','imposto');
                    $("#ttexto4").val(favorecido);
                    $("#categoria").val(tipoFav);
                break;
                case 'investimento':
                    $( "#investimentoModal" ).show();
                    $( "#ID_investimento" ).prop( "disabled", false );
                    $( "#ttexto5" ).prop( "disabled", false );
    
                    $( "#inputsModal" ).show();
                    $( "#categoria" ).prop( "disabled", true );
                    $('#tipoCliForne').attr('value','investimento');
                    $("#ttexto5").val(favorecido);
                    $("#categoria").val(tipoFav);
                break;   
                case 'cliente':
                    $( "#clienteModal" ).show();
                    $( "#ID_cliente" ).prop( "disabled", false );
                    $( "#ttexto" ).prop( "disabled", false );
    
                    $( "#inputsModal" ).show();
                    $( "#categoria" ).prop( "disabled", true );
                    $('#tipoCliForne').attr('value','cliente');
                    $("#ttexto").val(favorecido);
                    $("#categoria").val(tipoFav);
                break; 
                default:
                  // code block
              }

            //=======COLOCA O RESTO DOS VALORES NO FORM==========
            $("#title").val(title);
            $("#start").val(start);
            $("#id").val(id);
            $("#description").val(description);
            $("#valor").val(valor);
            $("#numero").val(numero);
            $("#situacao").bootstrapToggle(situacao);
            $("#situacao").val(situacao);
            console.log('Atual '+situacao);
            $('#banco>option[value='+ID_banco+']').attr("selected", true);

        },
        eventResize: function(element){
            let startDate = moment(element.event.start).format("YYYY-MM-DD");
            let endDate = moment(element.event.end).format("YYYY-MM-DD");

            if(endDate=='Invalid date')
                endDate=null;
                
            let newEvent = {
                _method:'PUT',
                id: element.event.id,
                start: startDate,
                end: endDate

            };

            sendEvent(routeEventsAtualizar(),newEvent,'PUT');
            console.log(element);
        },
        select: function(element){
            Swal.fire({
                title: 'Qual o tipo da transação?',
                icon: 'question',
                showDenyButton: true,
                showCancelButton: true,
                cancelButtonText: `Sair`,
                confirmButtonText: `Conta a Receber`,
                denyButtonText: `Conta a Pagar`,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    //RESETA MODAL
                    resetarForm("#formEvt");
                    //DEIXA VISIVEL INPUTS MODAL
                    $("#inputsModal" ).show();
                    //ABRE MODAL
                    $("#modalCalendario").modal('show');
                    $("#modalCalendario #tituloModalCalendar").text('Adicionar Evento');
                    $("#modalCalendario button.deleteEvent").css('display','none');
                    //HABILITA OS INPUTS CLIENTE
                    $( "#clienteModal" ).show();
                    $( "#ID_cliente" ).prop( "disabled", false );
                    $( "#ttexto" ).prop( "disabled", false );
                    //SELECIONA CATEGORIA CLIENTE E DESABILITA AS OUTRAS
                    $("#categoria").val('cliente');
                    $('#categoria option:not(:selected)').attr('disabled', true);
                    $('#optionCli').attr('disabled', false);
                    //TIPO FAV = CLI
                    $('#tipoCliForne').attr('value','cliente');

                    $( "#categoria" ).prop( "disabled", true );
          
                    let start = moment(element.start).format("DD/MM/YYYY");
                    $("#start").val(start);
        
                    calendar.unselect();
                } else if (result.isDenied) {
                    //RESETA MODAL
                    resetarForm("#formEvt");
                    //ABRE MODAL
                    $("#modalCalendario").modal('show');
                    $("#modalCalendario #tituloModalCalendar").text('Adicionar Evento');
                    $("#modalCalendario button.deleteEvent").css('display','none');
 
                    //DESABILITA CATEGORIA CLIENTE 
                    $('#optionCli').attr('disabled', true);

                    //TIPO FAV = Forne
                    $('#tipoCliForne').attr('value','fornecedor');
               
                    let start = moment(element.start).format("DD/MM/YYYY");
                    $("#start").val(start);
        
                    calendar.unselect();
                }
              })
            
        },
        events: routeEventsCarregar(),
        
    });
    objCalendar = calendar;

    calendar.render();


    
});


