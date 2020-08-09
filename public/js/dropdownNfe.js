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
        $('#ID_cliente').val(datum.ID_cliente);
        $('#emailCli').val(datum.email);
        $('#ieCli').val(datum.IE);
        $('#nomeCli').val(datum.nome);
        $('#cpf_cnpjCli').val(datum.cpf_cnpj);
        $('#contatoCli').val(datum.contato);
        $('#ufCli').val(datum.ufCli);
        console.log(datum.nomeTransp);
    });                        
});


  
  