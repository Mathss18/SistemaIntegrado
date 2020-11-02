$(document).ready(function(){               
    var funcionario = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/autocompletefuncionarios?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 10
    });
    funcionario.initialize();

    $("#ttexto3").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "funcionario",
        displayKey: "text",
        source: funcionario.ttAdapter()
    }).bind("typeahead:selected", function(obj, datum, name) {
        console.log(datum);
        $(this).data("seletectedId", datum.value);
        $('#ID_funcionario').val(datum.ID_funcionario);
        console.log(datum.ID_funcionario);
        console.log('VALOR '+$('#ID_funcionario').val());
    });                        
});