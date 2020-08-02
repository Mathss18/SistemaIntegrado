$(document).ready(function() {
    var table = $('#tableDT').DataTable({
        select: {
            style: 'single',
        },
        "order": [[ 2, 'asc' ]],
        "language": {
            url: '../js/traducao.json',
            decimal: ",",
        }
    });

    $('#tableDT tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        console.log(data);
        
        //Coloca as Infos no Modal de ENTRADA
        var id = document.getElementById("iptID");
        var preco = document.getElementById("iptDoc");
        var nome = document.getElementById("TituloModalCentralizado");
        id.value = data[0];
        preco.value = data[1];
        nome.innerHTML = '<b>Entrada: </b>' + data[2];
        
        
        //Coloca as Infos no Modal de SAIDA
        var idExcluir = document.getElementById("iptIDDel");
        var precoExcluir = document.getElementById("iptDocDel");
        var nomeExcluir = document.getElementById("TituloModalCentralizadoDel");
        idExcluir.value = data[0];
        precoExcluir.value = data[1];
        nomeExcluir.innerHTML = '<b>Saída: </b>' + data[2];
  

    } );
} );