$(document).ready(function(){               
    var codigo = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/autocompleteCodigoProdCli?query=%QUERY",
            wildcard: '%QUERY'
        },
        limit: 15
    });
    codigo.initialize();

    $("#ttexto1").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "codigo",
        displayKey: "text",
        source: codigo.ttAdapter()
    }).bind("typeahead:selected", function(obj, datum, name) {
        $(this).data("seletectedId", datum.value);
        $('#codigo').val(datum.value);
        var teste = document.getElementById('fotoProduto').src;
        $('#fotoProduto').attr("src", 'http://sistemaintegrado.ddns.net:8080/storage/Desenhos'+'/'+datum.value);
        $('#ID_produto_cliente').val(datum.ID_produto_cliente);
        console.log(datum.value);
        console.log(teste);
        
    });                        
});


  
  