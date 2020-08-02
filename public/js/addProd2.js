var form = document.forms.namedItem("pedidoForm"); // high importance!, here you need change "yourformname" with the name of your form
var formdata = new FormData(form); // high importance!

$.ajax({
    async: true,
    type: "POST",
    dataType: "json", // or html if you want...
    contentType: false, // high importance!
    url: '{{ action('PedidoController@adicionar') }}', // you need change it.
    data: formdata, // high importance!
    processData: false, // high importance!
    success: function (data) {

        alert('oi')

    },
    timeout: 10000
});