//Script para saber o consumo do relógio de BAIXO
var consumoTotal2 = 0; 
var totalLinhas2 = document.getElementById("tableDT2").rows.length - 1;
var textoConsumoBaixo = document.getElementById("consumoBaixo");
    totalLinhas2 = (totalLinhas2 * 2 ) - 1;

    for(var i = 0; i <= totalLinhas2; i++){
        if(i%2!=0){
            var inicio2 = document.getElementById("tableDT2").childNodes[3].childNodes[i].childNodes[3];
            var fim2 = document.getElementById("tableDT2").childNodes[3].childNodes[i].childNodes[5];
            var consumo2 = document.getElementById("tableDT2").childNodes[3].childNodes[i].childNodes[7];

            consumo2.innerHTML = (parseFloat(fim2.innerHTML) - parseFloat(inicio2.innerHTML))/100;
            consumoTotal2 += parseFloat(consumo2.innerHTML);

        }      
    }
    
    
    textoConsumoBaixo.innerHTML = "Consumo Total: "+consumoTotal2.toFixed(2).replace(".", ",");



//Script para saber o consumo do relógio de CIMA
var consumoTotal = 0;
var totalLinhas = document.getElementById("tableDT").rows.length - 1;
var textoConsumoCima = document.getElementById("consumoCima");
    totalLinhas = (totalLinhas * 2 ) - 1;


    for(var i = 0; i <= totalLinhas; i++){
        if(i%2!=0){
            var inicio = document.getElementById("tableDT").childNodes[3].childNodes[i].childNodes[3];
            var fim = document.getElementById("tableDT").childNodes[3].childNodes[i].childNodes[5];
            var consumo = document.getElementById("tableDT").childNodes[3].childNodes[i].childNodes[7];

            consumo.innerHTML = (parseFloat(fim.innerHTML) - parseFloat(inicio.innerHTML))/100;
            consumoTotal += parseFloat(consumo.innerHTML);
        
            
        }      
    }
    textoConsumoCima.innerHTML = "Consumo Total: "+consumoTotal.toFixed(2).replace(".", ",");
    



    //Pegar ID para o modal de editar
    function pegarID(button,opt) {
        var row = button.closest('tr').childNodes[1].innerHTML;
        console.log(row);
            if(opt==1){
                console.log(button.closest('tr').childNodes);
                var id = document.getElementById("iptID");
                var inicio = document.getElementById("iptInicio");
                var fim = document.getElementById("iptFim");
                var nome = document.getElementById("TituloModalCentralizado");
                
                
 
            
                id.value = button.closest('tr').childNodes[1].innerHTML;
                inicio.value = button.closest('tr').childNodes[3].innerHTML;
                fim.value = button.closest('tr').childNodes[5].innerHTML;
                nome.innerHTML = '<b>Alterar Valores Relógio <hr>Data: </b>' + button.closest('tr').childNodes[9].innerHTML;
                
    
                
                
            }else{
                console.log(button.closest('tr').childNodes);
                var id = document.getElementById("iptIDE");
                var inicio = document.getElementById("iptInicioE");
                var fim = document.getElementById("iptFimE");
                var nome = document.getElementById("TituloModalCentralizadoE");
                
                
 
            
                id.value = button.closest('tr').childNodes[1].innerHTML;
                inicio.value = button.closest('tr').childNodes[3].innerHTML;
                fim.value = button.closest('tr').childNodes[5].innerHTML;
                nome.innerHTML = '<b>Excluir Relógio <hr>Data: </b>' + button.closest('tr').childNodes[9].innerHTML;
                
                
            }
        }
