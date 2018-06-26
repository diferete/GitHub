
    $("#btnFim").hide();
    function nextButton() {
        var controle = $('#inputControle').val();
        if (controle == 'pessoal') {
            $("#divPes").hide();
            $("#divFam").show();
            $("#etapa2").removeClass("disabled");
            $("#etapa1").addClass("done");
            $("#etapa2").addClass("current");
        }
        if (controle == 'familia') {
            $("#divFam").hide();
            $("#divEnd").show();
            $("#etapa3").removeClass("disabled");
            $("#etapa2").addClass("done");
            $("#etapa3").addClass("current");
        }
        if (controle == 'endereco') {
            $("#divEnd").hide();
            $("#divEmp").show();
            $("#etapa4").removeClass("disabled");
            $("#etapa3").addClass("done");
            $("#etapa4").addClass("current");
            $("#btnFim").show();
            $("#btnNext").hide();
        }
        
        switch (controle) {
            case 'pessoal':
                $('#inputControle').val('familia');
                break;
            case 'familia':
                $('#inputControle').val('endereco');
                break;
            case 'endereco':
                $('#inputControle').val('empresas');
                break;
            default:
                $('#inputControle').val('pessoal');
                break;
        }
    };

$(function () {
    $("#btnBack").click(function () {
        var controle = $('#inputControle').val();
        if (controle == 'empresas') {
            $("#divEmp").hide();
            $("#divEnd").show();
            $("#btnFim").hide();
            $("#btnNext").show();
            $("#etapa4").addClass("disabled");
            $("#etapa3").removeClass("done");
            $("#etapa3").addClass("current");
        }
        if (controle == 'endereco') {
            $("#divEnd").hide();
            $("#divFam").show();
            $("#etapa3").removeClass("done");
            $("#etapa3").addClass("disabled");
            $("#etapa2").removeClass("done");
            $("#etapa2").addClass("current");
        }
        if (controle == 'familia') {
            $("#divFam").hide();
            $("#divPes").show();
            $("#etapa2").removeClass("current");
            $("#etapa2").addClass("disabled");
            $("#etapa1").addClass("current");
            $("#etapa1").removeClass("done");
        }


        switch (controle) {
            case 'familia':
                $('#inputControle').val('pessoal');
                break;
            case 'endereco':
                $('#inputControle').val('familia');
                break;
            case 'empresas':
                $('#inputControle').val('endereco');
                break;
            default:
                $('#inputControle').val('pessoal');
                break;
        }
    });
});
$(window).load(function () {
// Animate loader off screen
    $("#loading").remove(), 3000;
});
$("input[name=data]").datepicker({
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    language: "pt-BR",
    autoclose: true,
    todayHighlight: true,
    selectOtherMonths: true,
    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    changeMonth: true,
    changeYear: true
});


function validacao(idcampo) {
    //validar se campo = nada
    var vlrcampo = $('#' + idcampo).val();
    var icont = vlrcampo.length;
    console.log(vlrcampo);
    if (icont <= 3) {
        console.log('menos 3 carac bloqueia');
        $('#' + idcampo + '-blok').css('display', 'block');
        $('#' + idcampo + '-group').removeClass("has-success");
        $('#' + idcampo + '-group').addClass("has-error");
        $('#btnNext').attr("disabled",true);
    } else {
        console.log('vai passar');
        $('#' + idcampo + '-blok').css('display', 'none');
        $('#' + idcampo + '-group').addClass("has-success");
        $('#' + idcampo + '-group').removeClass("has-error");
        $('#btnNext').attr("disabled",false);
    }
}

