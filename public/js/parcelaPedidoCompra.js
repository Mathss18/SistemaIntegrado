$(document).ready(function() {
    $("#btnParcela").on("click", function(){
        
        $('#tableParcelas > tbody').empty();
        var qtdeParcelas = $('#numParc').val();
        var total = document.getElementById('totalFinal').innerHTML
        //Variavel Diff para adicionar os centavos na ultima fatura
        var diff = format(total/qtdeParcelas);
        var diff = format(total - diff*qtdeParcelas);

        var valor = total/qtdeParcelas;
        for (let i = 0; i < qtdeParcelas; i++) {
            if(i == qtdeParcelas-1){
                valor+=parseFloat(diff);
            }
            $('#tableParcelas > tbody:last-child').append("<tr><td><input class='form-control parcela' name='datas[]' type='date' required></td><td><input class='form-control' name='valores[]' type='number' step='0.01'></td></tr>");
            var aux = document.getElementById('tableParcelas')
            console.log(aux.rows[i+1].getElementsByTagName("td")[1].getElementsByTagName("input")[0]);
            aux.rows[i+1].getElementsByTagName("td")[1].getElementsByTagName("input")[0].value = format(valor);

            
        }
    });

   
});

$(document).on('keyup', '.parcela', function(){
    
    var agora = new Date();
    var dia = this.value;
    dia = parseInt(dia);

    var day = ("0" + agora.getDate()).slice(-2);
    var month = ("0" + (agora.getMonth() + 1)).slice(-2);

    var hoje = agora.getFullYear()+"-"+(month)+"-"+(day) ;

    var dataInput = this.parentNode.nextElementSibling.childNodes[0];

    dataInput.value = addDays(agora,dia);
    
    
    
});

function addDays(date, days) {
    var numberOfDaysToAdd = days;
    var result = date.setDate(date.getDate() + numberOfDaysToAdd);
    
    var dd = ("0" + date.getDate()).slice(-2);
    var mm = ("0" + (date.getMonth() + 1)).slice(-2);
    var y = date.getFullYear();

    var someFormattedDate = y + '-'+ mm + '-'+ dd;
    console.log(someFormattedDate);
    
    return someFormattedDate;
}

function format(number){
    number = number.toFixed(2);
    return number;
}


  $(function () {

    $('#formParcela').submit(function (e) {
        var route = $('#formParcela').data('route');
        var form_data = new FormData(this);
        $.ajax({
            type: 'POST',
            url: route,
            data: form_data,
            processData: false,
            contentType: false,
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
                    title: 'Parcelas adicionadas com sucesso!'
                  })
                  $('#modalParcelas').modal('hide');
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();

            }
        });

        e.preventDefault();

    });
});
