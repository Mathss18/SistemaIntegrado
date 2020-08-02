$(document).ready(function() {
    var table = $('#tableDT').DataTable({
        select: {
            style: 'single',
        },
        "order": [[ 0, 'desc' ]],
        "language": {
            "decimal": ",",
            url: '../../js/traducao.json',
        },
    });
     
    $('#tableDT tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        var ID = document.getElementById('iptID');
        ID.value = data[0];

        var iFrame = document.getElementById('iframe');
        var aux = document.getElementById('iptID2');
        
        
        path = aux.value+"/"+data[8];
        console.log(path);
        iFrame.src = "";
        iFrame.src = path;
	


        

    } );
} );