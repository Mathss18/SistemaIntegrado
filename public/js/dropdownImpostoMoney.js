var fornecedores = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: "/autocompletefornecedor?query=%QUERY",
        wildcard: '%QUERY'
    },
    limit: 10
});
fornecedores.initialize();

$("#ttexto4").typeahead({
    hint: true,
    highlight: true,
    minLength: 1
},
{
    name: "fornecedores",
    displayKey: "text",
    source: fornecedores.ttAdapter()
}).bind("typeahead:selected", function(obj, datum, name) {
    console.log(datum);
    $(this).data("seletectedId", datum.value);
    $('#ID_imposto').val(datum.value);
    console.log(datum.value);
});