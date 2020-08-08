$(document).ready(function(){               
    var pedidos = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/autocompleteCodigoProdNfe?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 10
    });
    pedidos.initialize();

    $("#ttexto").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "pedidos",
        displayKey: "text",
        source: pedidos.ttAdapter()
    }).bind("typeahead:selected", function(obj, datum, name) {
        console.log(datum);
        $(this).data("seletectedId", datum.value);
        $('#nomeCli').val(datum.nome);
        $('#cpf_cnpjCli').val(datum.cpf_cnpj);
        $('#contatoCli').val(datum.contato);
        console.log(datum.value);
    });                        
});


  
  