$(document).ready(function(){               
    var trasnportadora = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/autocompletetransp?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 50
    });
    trasnportadora.initialize();

    $("#ttexto2").typeahead({
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
        $(this).data("seletectedId", datum.ID_transp);
        $('#ID_transportadora').val(datum.ID_transp);

        
        console.log(datum.text);
    });                        
});

  
  