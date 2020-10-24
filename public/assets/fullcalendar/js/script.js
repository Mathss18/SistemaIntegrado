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
            resetarForm("#formEvt");
            $("#modalCalendario").modal('show');
            $("#modalCalendario #tituloModalCalendar").text('Alterar Evento');
            $("#modalCalendario button.deleteEvent").css('display','flex');
        
            let id = element.event.id;
            let title = element.event.title;
            let start = moment(element.event.start).format("DD/MM/YYYY");
            let description = element.event.extendedProps.description;
            $("#title").val(title);
            $("#start").val(start);
            $("#id").val(id);
            $("#description").val(description);

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
                title: 'Qual tipo o da transação?',
                icon: 'question',
                showDenyButton: true,
                showCancelButton: true,
                cancelButtonText: `Sair`,
                confirmButtonText: `Conta a Receber`,
                denyButtonText: `Conta a Pagar`,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    resetarForm("#formEvt");
                    $("#modalCalendario").modal('show');
                    $("#modalCalendario #tituloModalCalendar").text('Adicionar Evento');
                    $("#modalCalendario button.deleteEvent").css('display','none');
                    //$('#labelCliForne').text('Cliente');

                    $('#ttexto1').attr('type','hidden');
                    $('#ttexto1').attr('value',null);

                    $('#ID_fornecedor').attr('type','hidden');
                    $('#ID_fornecedor').attr('value',null);

                    $('#fornecedorModal').css('display','none');
                    $('#tipoCliForne').attr('value','cli');
                    
               
                    let start = moment(element.start).format("DD/MM/YYYY");
                    $("#start").val(start);
        
                    calendar.unselect();
                } else if (result.isDenied) {
                    resetarForm("#formEvt");
                    $("#modalCalendario").modal('show');
                    $("#modalCalendario #tituloModalCalendar").text('Adicionar Evento');
                    $("#modalCalendario button.deleteEvent").css('display','none');
                    //$('#labelCliForne').text('Fornecedor');

                    $('#ttexto').attr('type','hidden');
                    $('#ttexto').attr('value',null);

                    $('#ID_cliente').attr('type','hidden');
                    $('#ID_cliente').attr('value',null);

                    $('#clienteModal').css('display','none');
                    $('#tipoCliForne').attr('value','forne');
               
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
