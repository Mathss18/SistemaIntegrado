$(document).ready(function(){               
    var codigo = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/codigoFabProdCli?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 10
    });
    codigo.initialize();

    $("#cod_fabricacao").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "codigo",
        displayKey: "text",
        source: codigo.ttAdapter()
    }).bind("typeahead:selected", function(obj, datum, name) {
        console.log(datum);
        console.log(datum.value);
    });                        
});