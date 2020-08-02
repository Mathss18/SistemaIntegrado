function pegarID(button,opt) {
    var row = button.closest('tr').childNodes[1].innerHTML;
    console.log(row);
        if(opt==1){
            console.log(button.closest('tr').childNodes);
            var id = document.getElementById("iptID");
            var preco = document.getElementById("iptDoc");
            var nome = document.getElementById("TituloModalCentralizado");
        
            id.value = button.closest('tr').childNodes[1].innerHTML;
            preco.value = button.closest('tr').childNodes[3].innerHTML;
            nome.innerHTML = '<b>Entrada: </b>' + button.closest('tr').childNodes[5].innerHTML;

            
            
        }else{
            console.log(button.closest('tr').childNodes);
            var id = document.getElementById("iptIDDel");
            var preco = document.getElementById("iptDocDel");
            var nome = document.getElementById("TituloModalCentralizadoDel");
        
            id.value = button.closest('tr').childNodes[1].innerHTML;
            preco.value = button.closest('tr').childNodes[3].innerHTML;
            nome.innerHTML = '<b>Saída: </b>' + button.closest('tr').childNodes[5].innerHTML;
            
        }
    }