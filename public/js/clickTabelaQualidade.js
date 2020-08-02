$(document).ready(function() {
    var table = $('#tableDT').DataTable({
        select: {
            style: 'single',
        },
        "order": [[ 0, 'desc' ]],
        "language": {
            "decimal": ",",
            "thousands": ".",
            url: '../../js/traducao.json',
        },
    });
     
    $('#tableDT tbody').on('click', 'tr', function () {
        var dataa = table.row( this ).data();
        var off = document.getElementById('of');
        var codigo = document.getElementById('codigo');
        var qtde = document.getElementById('qtde');
        var arame = document.getElementById('arame');
        var sobra = document.getElementById('sobra');
        var abertura = document.getElementById('abertura');
        var interno = document.getElementById('interno');
        var externo = document.getElementById('externo');
        var acabamento = document.getElementById('acabamento');
        var passo = document.getElementById('passo');
        var lo_corpo = document.getElementById('lo_corpo');
        var lo_total = document.getElementById('lo_total');
        var espiras = document.getElementById('espiras');
        var obs = document.getElementById('obs');
        var data = document.getElementById('data');
        var cliente = document.getElementById('ttexto');
        var clienteID = document.getElementById('ID_cliente');
        var qualidadeID = document.getElementById('ID_qualidade');

        qualidadeID.value = dataa[0];
        clienteID.value = dataa[1];
        off.value = dataa[2];
        codigo.value = dataa[3];
        cliente.value = dataa[4];
        qtde.value = dataa[5];
        sobra.value = dataa[6];
        abertura.value = dataa[7];
        arame.value = dataa[8];
        interno.value = dataa[9];
        externo.value = dataa[10];
        passo.value = dataa[11];
        lo_corpo.value = dataa[12];
        lo_total.value = dataa[13];
        espiras.value = dataa[14];
        acabamento.value = dataa[15];
        obs.value = dataa[16];
        data.value = dataa[17];
        console.log(data);
        
    } );
} );