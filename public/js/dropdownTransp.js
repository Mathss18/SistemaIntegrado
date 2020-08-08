$(document).ready(function(){               
    var trasnportadora = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/autocompletetransp?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 10
    });
    trasnportadora.initialize();

    $("#nomeTransp").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "trasnportadora",
        displayKey: "text",
        source: trasnportadora.ttAdapter()
    }).bind("typeahead:selected", function(obj, datum, name) {
        console.log(datum);
        $(this).data("seletectedId", datum.value);
        $('#ID_transp').val(datum.value);
        $('#cpf_cnpjTransp').val(datum.cpf_cnpj);
        $('#contatoTransp').val(datum.contato);
        console.log(datum.value);
    });                        
});

  
  