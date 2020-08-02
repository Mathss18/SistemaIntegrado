$(document).ready(function() {
    var table = $('#tableDT').DataTable({
        select: {
            style: 'single',
        },
        "order": [[ 0, 'desc' ]],
        "language": {
            url: '../../js/traducao.json',
            "decimal": ",",
        },
    });
     
    $('#tableDT tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        var vale = document.getElementById('vale');
        var nfe = document.getElementById('nfe');
        var situacao = document.getElementById('situacao');
        var stauts = document.getElementById('status');
        var peso = document.getElementById('peso');
        var valor = document.getElementById('valor');
        var cliente = document.getElementById('ttexto');
        var clienteID = document.getElementById('ID_cliente');
        var faturamentoID = document.getElementById('ID_faturamento');

        faturamentoID.value = data[0];
        clienteID.value = data[1];
        vale.value = data[2];
        nfe.value = data[3];
        cliente.value = data[6];
        peso.value = data[7];
        valor.value = data[8];
        situacao.value = data[4];
        status.value = data[5];
        
        
    } );
} );