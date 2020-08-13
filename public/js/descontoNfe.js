$(document).ready(function() {

    var valorFinalNota = document.getElementById('precoFinal');
    var valorFinalNotaAux = document.getElementById('precoFinalAux');
    var desconto = document.getElementById('desconto');
    var porcento = document.getElementById('porcento');

    $('input:radio[name=tipoDesc]').change(function() {
        if (this.value == 'valorCheio') {
            var resp = 0.0;
            var desc = 0.0;

            resp = valorFinalNotaAux.value - desconto.value;
            resp = (Math.round(resp * 100) / 100).toFixed(4);
            valorFinalNota.value = resp;

            porcento.value = (100*valorFinalNota.value)/valorFinalNotaAux.value;
            porcento.value = 100-porcento.value;
            
        }
        else if (this.value == 'porcentagem') {
            var resp = 0.0;
            var desc = 0.0;

            porcento.value = desconto.value;
            console.log(porcento);
            
            resp = valorFinalNotaAux.value - (valorFinalNotaAux.value*desconto.value)/100;
            //resp = (Math.round(resp * 100) / 100);
            valorFinalNota.value = resp.toFixed(4);
            console.log(resp);
            desc = valorFinalNotaAux.value - valorFinalNota.value;
            //desc = (Math.round(desc * 100) / 100);
            desconto.value = desc;
            
            
        }
    });
});