$(function() {
    $('#toggle-event').change(function() {
        var texto = document.getElementById("change");
        if(texto.innerHTML == 'ORÇAMENTO'){
            texto.innerHTML = 'VENDA';
        }
        else if(texto.innerHTML == 'VENDA'){
            texto.innerHTML = 'ORÇAMENTO';
        }
    })
  })