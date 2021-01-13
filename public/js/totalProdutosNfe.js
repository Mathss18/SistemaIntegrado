$(function () {
    $("input[type='number']").on('input', function() {
        somarTotalPreco();
    });
})
function somarTotalPreco() {
    var tbody = document.getElementById("tableDT");
    var total = 0;
    var rowTotal = document.getElementById('total');
    var inputTotal = document.getElementById('inputTotal');

    var rowTotalQtde = document.getElementById('inputTotalProd');
    var inputTotalQtde = document.getElementById('totalProd');
    var totalProd = 0;
    
    
    for(var i = 1; i < (tbody.rows.length)-1; i++) {
        qtde = parseFloat(tbody.rows[i].childNodes[5].childNodes[0].value); // qtde
        preco = parseFloat(tbody.rows[i].childNodes[7].childNodes[0].value); // preco
        total = total + qtde*preco;
    }
    
    rowTotal.innerHTML = "TOTAL R$: " + total.toLocaleString('pt-BR');
    inputTotalProd.value = total;

    

    totalProd = (tbody.rows.length)-2;

    inputTotal.value = totalProd;
    inputTotalQtde.innerHTML = 'PRODUTOS: ' +totalProd;
    
}

function deletaRow(obj){
    var row = obj.parentNode.parentNode.remove();
    
    
    console.log(row);
    somarTotalPreco();
}

somarTotalPreco();