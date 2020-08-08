$(document).ready(function() {
    $("#btnParcela").on("click", function(){
        
        $('#tableParcelas > tbody').empty();
        var qtdeParcelas = $('#numParc').val();
        
        for (let i = 0; i < qtdeParcelas; i++) {
            $('#tableParcelas > tbody:last-child').append("<tr><td><input class='form-control parcela' name='dias[]' type='text'></td><td><input class='form-control' name='datas[]' readonly type='date'></td></tr>");
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
                alert('Parcelas adicionadas com sucesso!')

            }
        });

        e.preventDefault();

    });
});
