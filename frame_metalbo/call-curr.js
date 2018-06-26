function nextButtonPessoal() {
    //   var errosPessoal = validaEtapaPessoal();
    //   if (errosPessoal > 0) {

    //  } else {
    $("#divPes").hide();
    $("#divFam").show();
    $("#etapa1").addClass("done");
    $("#etapa2").removeClass("disabled");
    $("#etapa2").addClass("current");
    //  }
}

function nextButtonFamilia() {
    $("#divFam").hide();
    $("#divEnd").show();
    $("#etapa2").addClass("done");
    $("#etapa3").removeClass("disabled");
    $("#etapa3").addClass("current");
}

function nextButtonEnd() {
    /*var errosEndereco = validaEtapaEndereco();
     if (errosEndereco > 0) {
     
     } else {*/
    $("#divEnd").hide();
    $("#divEmp").show();
    $("#etapa3").addClass("done");
    $("#etapa4").removeClass("disabled");
    $("#etapa4").addClass("current");
}
//}

function  backEmprego() {
    $("#divEmp").hide();
    $("#divEnd").show();
    $("#btnFim").hide();
    $("#btnNext").show();
    $("#etapa4").addClass("disabled");
    $("#etapa4").removeClass("current");
    $("#etapa3").removeClass("done");
    $("#etapa3").addClass("current");
}
function  backEnd() {
    $("#divEnd").hide();
    $("#divFam").show();
    $("#etapa3").removeClass("current");
    $("#etapa3").addClass("disabled");
    $("#etapa2").removeClass("done");
    $("#etapa2").addClass("current");
}
function  backFamilia() {
    $("#divFam").hide();
    $("#divPes").show();
    $("#etapa2").removeClass("done");
    $("#etapa2").addClass("disabled");
    $("#etapa1").addClass("current");
    $("#etapa1").removeClass("done");
}

$(window).load(function () {
// Animate loader off screen
    $("#loading").remove(), 3000;
});
/*
 function validacao(idcampo) {
 //validar se campo = nada
 var vlrcampo = $('#' + idcampo).val();
 var icont = vlrcampo.length;
 console.log(vlrcampo);
 if (icont <= 3) {
 addError(idcampo);
 } else {
 addSuccess(idcampo);
 }
 }
 
 function valNumber(idcampo) {
 //validar se campo = nada
 var vlrcampo = $('#' + idcampo).val();
 var icont = vlrcampo.length;
 console.log(vlrcampo);
 if (icont <= 3) {
 addError(idcampo);
 } else {
 addSuccess(idcampo);
 }
 }
 
 
 function addSuccess(idcampo) {
 console.log('vai passar');
 $('#' + idcampo + '-blok').css('display', 'none');
 $('#' + idcampo + '-group').addClass("has-success");
 $('#' + idcampo + '-group').removeClass("has-error");
 // $('#btnNext').attr("disabled",false); 
 }
 function addError(idcampo) {
 console.log('menos 3 carac bloqueia');
 $('#' + idcampo + '-blok').css('display', 'block');
 $('#' + idcampo + '-group').removeClass("has-success");
 $('#' + idcampo + '-group').addClass("has-error");
 // $('#btnNext').attr("disabled",true);
 }
 
 function validaEtapaPessoal() {
 var erros = 0;
 //valida o nome
 var nomepessoal = $('#nomecomp').val();
 var icont = nomepessoal.length;
 if (icont <= 6) {
 addError('nomecomp');
 erros++;
 } else {
 addSuccess('nomecomp');
 }
 //valida naturalidade
 var naturalidade = $('#naturalidade').val();
 icont = naturalidade.length;
 if (icont <= 3) {
 addError('naturalidade');
 erros++;
 } else {
 addSuccess('naturalidade');
 }
 //valida nascimento
 var nascimento = $('#nascimento').val();
 icont = nascimento.length;
 if (icont <= 3) {
 addError('nascimento');
 erros++;
 } else {
 addSuccess('nascimento');
 }
 //valida altura
 var altura = $('#altura').val();
 icont = altura.length;
 if (icont <= 3) {
 addError('altura');
 erros++;
 } else {
 addSuccess('altura');
 }
 //valida peso
 var peso = $('#peso').val();
 icont = peso.length;
 if (icont <= 1) {
 addError('peso');
 erros++;
 } else {
 addSuccess('peso');
 }
 //valida rg
 var rg = $('#rg').val();
 icont = rg.length;
 if (icont <= 3) {
 addError('rg');
 erros++;
 } else {
 addSuccess('rg');
 }
 //valida cpf
 var cpf = $('#cpf').val();
 icont = cpf.length;
 if (icont <= 6) {
 addError('cpf');
 erros++;
 } else {
 addSuccess('cpf');
 }
 //valida titulo
 var titulo = $('#titulo').val();
 icont = titulo.length;
 if (icont <= 6) {
 addError('titulo');
 erros++;
 } else {
 addSuccess('titulo');
 }
 //valida ctps
 var ctps = $('#ctps').val();
 icont = ctps.length;
 if (icont <= 6) {
 addError('ctps');
 erros++;
 } else {
 addSuccess('ctps');
 }
 //valida seriectps
 var seriectps = $('#seriectps').val();
 icont = seriectps.length;
 if (icont <= 6) {
 addError('seriectps');
 erros++;
 } else {
 addSuccess('seriectps');
 }
 //valida pis
 var pis = $('#pis').val();
 icont = pis.length;
 if (icont <= 6) {
 addError('pis');
 erros++;
 } else {
 addSuccess('pis');
 }
 
 //retorna erros
 return erros;
 }
 
 function validaEtapaEndereco() {
 var erros = 0;
 //valida o nome
 var fone = $('#fone').val();
 var icont = fone.length;
 if (icont <= 6) {
 addError('fone');
 erros++;
 } else {
 addSuccess('fone');
 }
 //valida rua
 var rua = $('#rua').val();
 icont = rua.length;
 if (icont <= 3) {
 addError('rua');
 erros++;
 } else {
 addSuccess('rua');
 }
 //bairro
 var bairro = $('#bairro').val();
 icont = bairro.length;
 if (icont <= 3) {
 addError('bairro');
 erros++;
 } else {
 addSuccess('bairro');
 }
 //valida cep
 var cep = $('#cep').val();
 icont = cep.length;
 if (icont <= 5) {
 addError('cep');
 erros++;
 } else {
 addSuccess('cep');
 }
 //valida peso
 var peso = $('#peso').val();
 icont = peso.length;
 if (icont <= 1) {
 addError('peso');
 erros++;
 } else {
 addSuccess('peso');
 }
 //valida cidade
 var cidade = $('#cidade').val();
 icont = cidade.length;
 if (icont <= 3) {
 addError('cidade');
 erros++;
 } else {
 addSuccess('cidade');
 }
 //valida cpf
 var cpf = $('#cpf').val();
 icont = cpf.length;
 if (icont <= 6) {
 addError('cpf');
 erros++;
 } else {
 addSuccess('cpf');
 }
 //valida estado
 var estado = $('#estado').val();
 icont = estado.length;
 if (icont <= 3) {
 addError('estado');
 erros++;
 } else {
 addSuccess('estado');
 }
 //valida numero
 var numero = $('#numero').val();
 icont = numero.length;
 if (icont <= 2) {
 addError('numero');
 erros++;
 } else {
 addSuccess('numero');
 }
 //valida moradia
 var moradia = $('#moradia').val();
 icont = moradia.length;
 if (icont <= 1) {
 addError('moradia');
 erros++;
 } else {
 addSuccess('moradia');
 }
 //retorna erros
 return erros;
 }
 
 
 function validaEtapaEmpresa() {
 var erros = 0;
 //valida emp1
 var emp1 = $('#emp1').val();
 var icont = emp1.length;
 if (icont <= 6) {
 addError('emp1');
 erros++;
 } else {
 addSuccess('emp1');
 }
 //valida cargo1
 var cargo1 = $('#cargo1').val();
 icont = cargo1.length;
 if (icont <= 3) {
 addError('cargo1');
 erros++;
 } else {
 addSuccess('cargo1');
 }
 //contato1
 var contato1 = $('#contato1').val();
 icont = contato1.length;
 if (icont <= 3) {
 addError('contato1');
 erros++;
 } else {
 addSuccess('contato1');
 }
 //valida cidade1
 var cidade1 = $('#cidade1').val();
 icont = cidade1.length;
 if (icont <= 3) {
 addError('cidade1');
 erros++;
 } else {
 addSuccess('cidade1');
 }
 //valida contrato1
 var contrato1 = $('#contrato1').val();
 icont = contrato1.length;
 if (icont <= 1) {
 addError('contrato1');
 erros++;
 } else {
 addSuccess('contrato1');
 }
 //valida recisao1
 var recisao1 = $('#recisao1').val();
 icont = recisao1.length;
 if (icont <= 3) {
 addError('recisao1');
 erros++;
 } else {
 addSuccess('recisao1');
 }
 //valida emp2
 var emp2 = $('#emp2').val();
 var icont = emp2.length;
 if (icont <= 6) {
 addError('emp2');
 erros++;
 } else {
 addSuccess('emp2');
 }
 //valida cargo2
 var cargo2 = $('#cargo2').val();
 icont = cargo2.length;
 if (icont <= 3) {
 addError('cargo2');
 erros++;
 } else {
 addSuccess('cargo2');
 }
 //contato2
 var contato2 = $('#contato2').val();
 icont = contato2.length;
 if (icont <= 3) {
 addError('contato2');
 erros++;
 } else {
 addSuccess('contato2');
 }
 //valida cidade2
 var cidade2 = $('#cidade2').val();
 icont = cidade2.length;
 if (icont <= 3) {
 addError('cidade2');
 erros++;
 } else {
 addSuccess('cidade2');
 }
 //valida contrato2
 var contrato2 = $('#contrato2').val();
 icont = contrato2.length;
 if (icont <= 2) {
 addError('contrato2');
 erros++;
 } else {
 addSuccess('contrato2');
 }
 //valida recisao2
 var recisao2 = $('#recisao2').val();
 icont = recisao2.length;
 if (icont <= 3) {
 addError('recisao2');
 erros++;
 } else {
 addSuccess('recisao2');
 }
 //valida emp3
 var emp3 = $('#emp3').val();
 var icont = emp3.length;
 if (icont <= 6) {
 addError('emp3');
 erros++;
 } else {
 addSuccess('emp3');
 }
 //valida cargo3
 var cargo3 = $('#cargo3').val();
 icont = cargo3.length;
 if (icont <= 3) {
 addError('cargo3');
 erros++;
 } else {
 addSuccess('cargo3');
 }
 //contato3
 var contato3 = $('#contato3').val();
 icont = contato3.length;
 if (icont <= 3) {
 addError('contato3');
 erros++;
 } else {
 addSuccess('contato3');
 }
 //valida cidade3
 var cidade3 = $('#cidade3').val();
 icont = cidade3.length;
 if (icont <= 3) {
 addError('cidade3');
 erros++;
 } else {
 addSuccess('cidade3');
 }
 //valida contrato3
 var contrato3 = $('#contrato3').val();
 icont = contrato3.length;
 if (icont <= 3) {
 addError('contrato3');
 erros++;
 } else {
 addSuccess('contrato3');
 }
 //valida recisao3
 var recisao3 = $('#recisao3').val();
 icont = recisao3.length;
 if (icont <= 3) {
 addError('recisao3');
 erros++;
 } else {
 addSuccess('recisao3');
 }
 //retorna erros
 return erros;
 }
 */

$("#formWizzard").submit(function (e) {
    e.preventDefault();
    var myDropzone = Dropzone.forElement("#meuId");
    myDropzone.processQueue();

    (function ($) {
        $.fn.serializeFormJSON = function () {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
    })(jQuery);
    var data = $(this).serializeFormJSON();
    console.log(data);

    var str_json = JSON.stringify(data);

    request = new XMLHttpRequest();
    request.open("POST", "http://localhost/frame_metalbo/index.php?classe=UploadCurr&metodo=UploadCurr", true);
    request.setRequestHeader("Content-type", "application/json");
    request.send(str_json);

    console.log(str_json);


});

