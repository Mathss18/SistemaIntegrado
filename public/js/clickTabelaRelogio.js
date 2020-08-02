$(document).ready(function() {
    var table = $('#tableDT').DataTable({
        select: {
            style: 'single',
        },
        "order": [[ 0, 'desc' ]],
        "language": {
            url: '../../js/traducao.json',
            decimal: ",",
        },
    });
     
    $('#tableDT tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        console.log(data);
    } );
} );

$(document).ready(function() {
    var table = $('#tableDT2').DataTable({
        select: {
            style: 'single'
        },
        "order": [[ 0, 'desc' ]],
        "language": {
            url: '../../js/traducao.json',
            decimal: ",",
        },
    });
     
    $('#tableDT2 tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        console.log(data);
    } );
} );