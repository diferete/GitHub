$("#contactForm").validator().on("submit", function (event) {

    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        formError();
        submitMSG(false, "Preencha os campos do formulário!");
    } else {
        alert('we in, boys');
        // everything looks good!
        event.preventDefault();
        submitForm();
    }
});


function submitForm() {
    // Initiate Variables With Form Content
    var nome = $("#nome").val();
    var email = $("#email").val();
    var assunto = $("#assunto").val();
    var mensagem = $("#mensagem").val();
    var uf = $("#uf").val();
    var cidade = $("#cidade").val();

    switch (uf) {
        case '12':
            uf = 'Acre';
            break;
        case '27':
            uf = 'Alagoas';
            break;
        case '16':
            uf = 'Amapá';
            break;
        case '13':
            uf = 'Amazonas';
            break;
        case '29':
            uf = 'Bahia';
            break;
        case '23':
            uf = 'Ceará';
            break;
        case '53':
            uf = 'Distrito Federal';
            break;
        case '32':
            uf = 'Espírito Santo';
            break;
        case '52':
            uf = 'Goiás';
            break;
        case '21':
            uf = 'Maranhão';
            break;
        case '51':
            uf = 'Mato Grosso';
            break;
        case '50':
            uf = 'Mato Grosso do Sul';
            break;
        case '31':
            uf = 'Minas Gerais';
            break;
        case '41':
            uf = 'Paraná';
            break;
        case '25':
            uf = 'Paraíba';
            break;
        case '15':
            uf = 'Pará';
            break;
        case '26':
            uf = 'Pernambuco';
            break;
        case '22':
            uf = 'Piauí';
            break;
        case '33':
            uf = 'Rio de Janeiro';
            break;
        case '24':
            uf = 'Rio Grande do Norte';
            break;
        case '43':
            uf = 'Rio Grande do Sul';
            break;
        case '11':
            uf = 'Rondônia';
            break;
        case '14':
            uf = 'Roraima';
            break;
        case '42':
            uf = 'Santa Catarina';
            break;
        case '28':
            uf = 'Sergipe';
            break;
        case '35':
            uf = 'São Paulo';
            break;
        case '17':
            uf = 'Tocantins';
            break;
    }

    switch (assunto) {
        case '1':
            assunto = 'Cotações';
            break;
        case '2':
            assunto = 'Apresentações';
            break;
        case '3':
            assunto = 'NFe';
            break;
        case '4':
            assunto = 'Compras';
            break;
        case '5':
            assunto = 'Outros';
            break;
        default:
            break;
    }



    console.log(nome + ' nome');
    console.log(email + ' e-mail');
    console.log(assunto + ' assunto');
    console.log(uf + ' estado');
    console.log(cidade + ' cidade');    
    console.log(mensagem + ' mensagem');

    $.ajax({
        type: "POST",
        url: "php/form-process.php",
        data: "nome=" + nome + "&email=" + email + "&assunto=" + assunto + "&mensagem=" + mensagem + "&uf=" + uf + "&cidade=" + cidade,
        success: function (text) {
            if (text == "success") {
                formSuccess();
            } else {
                formError();
                submitMSG(false, text);
            }
        }
    });
}

function formSuccess() {
    $("#contactForm")[0].reset();
    sweetAlert('Sucesso!', 'Sua mensagem foi enviada para Metalbo.', "info");
    submitMSG(true, "Messagem enviada com sucesso!");
}

function formError() {
    $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
        $(this).removeClass();
    });
}

function submitMSG(valid, msg) {
    if (valid) {
        var msgClasses = "h3 text-center tada animated text-success";
        $("#msgSubmit").removeClass().addClass(msgClasses).text( msg);
    } else {
        var msgClasses = "h3 text-center text-danger";
        $("#msgSubmit").removeClass().addClass(msgClasses).text('Por favor preencha esses campos: ' + msg);
    }
}


function newsletter() {
    // Initiate Variables With Form Content
    var email = $("#letter").val();

    if (email == "") {
        $("#validaletter").show();
    } else {
        $("#validaletter").hide();

        $.ajax({
            type: "POST",
            url: "php/letter-process.php",
            data: "email=" + email,
            success: function (text) {
                if (text == "success") {
                    $("#validaSucesso").show();
                } else {
                    $("#validaBackphp").show();
                }
            }
        });


    }

}

function desabilita() {
    $("#validaletter").hide();
    $("#validaSucesso").hide();
    $("#validaBackphp").hide();
}

function mensagemErro(sTitulo, sMensagem) {
    sweetAlert(sTitulo, sMensagem, "info");
}



