$(document).ready(function () {
    var table = $('#tableDT').DataTable({
        select: {
            style: 'single',
        },
        "order": [[1, 'desc']],
        "language": {
            url: '../../../../js/traducao.json',
            decimal: ",",
        }
    });

    $('#tableDT tbody').on('click', 'tr', function () {

        var data = table.row(this).data();
        console.log(data);

        //========RESETAR FORM==============
        resetarForm("#formEvt");
        //=======ABRE O MODAL PARA ALTERAR EVENTO===========
        $("#modalCalendario").modal('show');
        $("#modalCalendario #tituloModalCalendar").text('Alterar Evento');
        $("#modalCalendario button.deleteEvent").css('display', 'flex');

        //=======PEGA AS INFOS DO EVT E COLOCA NAS VARIAVEIS===========
        let id = data[0];
        let title =data[8];
        let start = moment(data[1]).format("DD/MM/YYYY");
        let description = data[2];
        let favorecido = data[3];
        let tipoFav = data[4];
        let ID_banco = data[5];
        let valor = data[10];
        let numero = data[6];
        let situacao = data[7];

        //=======PEGA O TIPO DE FAVORECIDO E COLOCA DENTO DO INPUT 'tipoClieForne'==========
        $('#tipoCliForne').val(tipoFav);

        //=======SE O TIPO FOR CLI TIRA INPUT FORNE==========
        switch (tipoFav) {
            case 'fornecedor':

                $("#fornecedorModal").show();
                $("#ID_fornecedor").prop("disabled", false);
                $("#ttexto1").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'fornecedor');

                $("#ttexto1").val(favorecido);
                $("#categoria").val(tipoFav);
                break;
            case 'transportadora':
                $("#transportadoraModal").show();
                $("#ID_transportadora").prop("disabled", false);
                $("#ttexto2").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'transportadora');
                $("#ttexto2").val(favorecido);
                $("#categoria").val(tipoFav);
                break;
            case 'funcionario':
                $("#funcionarioModal").show();
                $("#ID_funcionario").prop("disabled", false);
                $("#ttexto3").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'funcionario');
                $("#ttexto3").val(favorecido);
                $("#categoria").val(tipoFav);
                break;
            case 'imposto':
                $("#impostoModal").show();
                $("#ID_imposto").prop("disabled", false);
                $("#ttexto4").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'imposto');
                $("#ttexto4").val(favorecido);
                $("#categoria").val(tipoFav);
                break;
            case 'investimento':
                $("#investimentoModal").show();
                $("#ID_investimento").prop("disabled", false);
                $("#ttexto5").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'investimento');
                $("#ttexto5").val(favorecido);
                $("#categoria").val(tipoFav);
                break;
            case 'cliente':
                $("#clienteModal").show();
                $("#ID_cliente").prop("disabled", false);
                $("#ttexto").prop("disabled", false);

                $("#inputsModal").show();
                $("#categoria").prop("disabled", true);
                $('#tipoCliForne').attr('value', 'cliente');
                $("#ttexto").val(favorecido);
                $("#categoria").val(tipoFav);
                break;
            default:
            // code block
        }

        //=======COLOCA O RESTO DOS VALORES NO FORM==========
        $("#title").val(title);
        $("#start").val(start);
        $("#id").val(id);
        $("#description").val(description);
        $("#valor").val(valor);
        $("#numero").val(numero);
        $("#situacao").bootstrapToggle(situacao);
        $("#situacao").val(situacao);
        console.log('Atual ' + situacao);
        $('#banco>option[value=' + ID_banco + ']').attr("selected", true);


    });
});

function resetarForm(form) {
    $(form)[0].reset();

    $('#id').val('');

    //ESCONDENDO OS INPUTS
    $("option:selected").removeAttr("selected");
    $("#inputsModal").css('display', 'none');

    //RESETANDO PARTE DO CLIENTE
    $("#clienteModal").hide();
    $("#ID_cliente").prop("disabled", true);
    $("#ttexto").prop("disabled", true);

    //RE-HABILITANDO O SELECT DE CATEGORIAS
    $("#categoria").val('');
    $("#categoria option").removeAttr("selected");
    $("#categoria option").attr('disabled', false);

    //DESABILITANDO E ESCONDENDO OS  DEMAIS INPUTS
    $("#fornecedorModal").hide();
    $("#ID_fornecedor").prop("disabled", true);
    $("#ttexto").prop("disabled", true);

    $("#transportadoraModal").hide();
    $("#ID_transportadora").prop("disabled", true);
    $("#ttexto2").prop("disabled", true);

    $("#funcionarioModal").hide();
    $("#ID_funcionario").prop("disabled", true);
    $("#ttexto3").prop("disabled", true);

    $("#impostoModal").hide();
    $("#ID_imposto").prop("disabled", true);
    $("#ttexto4").prop("disabled", true);

    $("#investimentoModal").hide();
    $("#ID_investimento").prop("disabled", true);
    $("#ttexto5").prop("disabled", true);

    $("#categoria").prop("disabled", false);

    $('#situacao').bootstrapToggle('on');
    $("#situacao").val('on');

}

function showState(){
    console.log('entrei');
    console.log($('#situacao').val());
    if($('#situacao').val()=='on'){
      $('#situacao').val('off')
      $('valor').prop( "disabled", true );

    }
    else{
      $('#situacao').val('on')
      $('valor').prop( "disabled", true );
      
    }
    $('valor').prop( "enabled", true );
    
  }

function abrirModalPergunta(){
        Swal.fire({
            title: 'Qual o tipo da transação?',
            icon: 'question',
            showDenyButton: true,
            showCancelButton: true,
            cancelButtonText: `Sair`,
            confirmButtonText: `Conta a Receber`,
            denyButtonText: `Conta a Pagar`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                //RESETA MODAL
                resetarForm("#formEvt");
                //DEIXA VISIVEL INPUTS MODAL
                $("#inputsModal" ).show();
                //DEIXA INPUT DO BANCO PADRAO
                $("#banco>option[value="+banco['ID_banco']+"]").attr("selected", true);
                //COLOCANDO DATA DE HOJE NO INPUT DATA
                inicio = document.getElementById("start");
                var data=new Date()
                var dataFormat = moment(data).format("DD/MM/YYYY");
                inicio.value = dataFormat;
                //ABRE MODAL
                $("#modalCalendario").modal('show');
                $("#modalCalendario #tituloModalCalendar").text('Adicionar Evento');
                $("#modalCalendario button.deleteEvent").css('display','none');
                //HABILITA OS INPUTS CLIENTE
                $( "#clienteModal" ).show();
                $( "#ID_cliente" ).prop( "disabled", false );
                $( "#ttexto" ).prop( "disabled", false );
                //SELECIONA CATEGORIA CLIENTE E DESABILITA AS OUTRAS
                $("#categoria").val('cliente');
                $('#categoria option:not(:selected)').attr('disabled', true);
                $('#optionCli').attr('disabled', false);
                //TIPO FAV = CLI
                $('#tipoCliForne').attr('value','cliente');

                $( "#categoria" ).prop( "disabled", true );
      
                //let start = moment(element.start).format("DD/MM/YYYY");
                //$("#start").val(start);

            } else if (result.isDenied) {
                //RESETA MODAL
                resetarForm("#formEvt");
                //DEIXA INPUT DO BANCO PADRAO
                $("#banco>option[value="+banco['ID_banco']+"]").attr("selected", true);
                //COLOCANDO DATA DE HOJE NO INPUT DATA
                inicio = document.getElementById("start");
                var data=new Date()
                var dataFormat = moment(data).format("DD/MM/YYYY");
                inicio.value = dataFormat;
                //ABRE MODAL
                $("#modalCalendario").modal('show');
                $("#modalCalendario #tituloModalCalendar").text('Adicionar Evento');
                $("#modalCalendario button.deleteEvent").css('display','none');

                //DESABILITA CATEGORIA CLIENTE 
                $('#optionCli').attr('disabled', true);

                //TIPO FAV = Forne
                $('#tipoCliForne').attr('value','fornecedor');
           
                let start = moment(element.start).format("DD/MM/YYYY");
                $("#start").val(start);
    
                calendar.unselect();
            }
          })
        
    
}