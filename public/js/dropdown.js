$(document).ready(function(){               
    var clientes = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/autocompleteclientes?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 10
    });
    clientes.initialize();

    $("#ttexto").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "clientes",
        displayKey: "text",
        source: clientes.ttAdapter()
    }).bind("typeahead:selected", function(obj, datum, name) {
        console.log(datum);
        $(this).data("seletectedId", datum.value);
        $('#ID_cliente').val(datum.value);
        console.log(datum.value);
    });                        
});

$(function () {
    $('#Cmbfuncionario').multipleSelect()
  })

  
  