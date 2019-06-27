$("#contactForm").validator().on("submit", function (event) {

    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        formError();
        submitMSG(false, "Preencha os campos do formulário!");
    } else {
        // everything looks good!
        event.preventDefault();
        submitForm();
    }
});


function submitForm() {
    // Initiate Variables With Form Content
    var name = $("#name").val();
    var email = $("#email").val();
    var msg_subject = $("#msg_subject").val();
    var message = $("#message").val();
    var msg_estado = $("#msg_estado").val();
    var cidade = $("#cidade").val();

    $.ajax({
        type: "POST",
        url: "php/form-process.php",
        data: "name=" + name + "&email=" + email + "&msg_subject=" + msg_subject + "&message=" + message + "&msg_estado=" + msg_estado + "&cidade=" + cidade,
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
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
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




$.getJSON("https://sistema.metalbo.com.br/index.php?classe=NoticiaSite&metodo=getFeed&filcgc=metalbo", function (data) {
    var html = '';
    data.forEach(function (o) {
        html = html + '<div class="col-lg-4 col-md-4 col-sm-6">'
                + '<div class="blog-item-wrapper">'
                + '<div class="blog-item-img">'
                + '</div>'
                + '<div class="blog-item-text"> '
                + '<h3>'
                + '<span>' + (o['titulo']) + '</span>'
                + '</h3>'
                + '<hr class="lines">'
                + '<div class="meta-tags">'
                + '<span class="date"><i class="lnr lnr-calendar-full"></i>' + (o['data']) + '</span>'
                + '</div>'
                + '<p>' + (o['texto']) + '</p>'
                + '</div>'
                + '</div>'
                + '</div>';
    });
    setTimeout(function () {
        $("#loading").remove();
        $("#divFeed").append(html);
    }, 3000);

});


/*
 $(function () {
 $("#selEstado").hide();
 $("#toggler").on("click", function () {
 $("#repImg, #selEstado").toggle("5000");
 });
 });
 */

$("#name").one("click", function mensagemAlert() {
    var campo = $("#name").val();
    if (campo == '') {
        var sTit = "Caro usuário!";
        var sMsg = "Antes de entrar em contato, dê uma olhadinha na nossa área de Representantes. Clique em SELECIONE SEU ESTADO(UF) e encontre o Representante por estado, mais próximo de você para fazer suas COTAÇÕES e ORÇAMENTOS ;)"
        sweetAlert(sTit, sMsg, "info");
    }
});




$(document).ready(function () {
    $("#estado").change(function () {
        var uf = $("#estado").val();
        $("#modalrep").empty();
        $.getJSON("https://sistema.metalbo.com.br/index.php?classe=BuscaRepSite&metodo=buscaRep" + "&uf=" + uf, function (result) {
            var modal = '';
            result.forEach(function (dados) {
                modal = modal + '<div class="pricing-table">'
                        + '<div class="blog-item-wrapper">'
                        + '<div class="blog-item-img">'
                        + '<a href="single-post.html">'
                        + '</a>'
                        + '</div>'
                        + '<div class="blog-item-text">'
                        + '<h5>' + (dados['nome']) + '</span></h5>'
                        + '<hr>'
                        + '<div class="meta-tags">'
                        + '<span>' + (dados['estado']) + '</span>'
                        + '</div>'
                        + '<p>'
                        + (dados['endereco']) + '<br/>'
                        + (dados['bairro']) + ' - ' + (dados['cidade']) + '<br/>'
                        + (dados['ufrep']) + ' - ' + (dados['pais']) + '<br/>'
                        + 'CEP ' + (dados['cep']) + '<br/>'
                        + 'Fone <a style="color:black !important" href ="tel:' + (dados['fone1']) + '">' + (dados['fone1']) + '</a><br/>'
                        + 'Fone 2 <a style="color:black !important" href ="tel:' + (dados['fone2']) + '">' + (dados['fone2']) + '<br/>'
                        + 'Email <a style="color:red" href="mailto:' + (dados['email1']) + '">' + (dados['email1']) + '</a><br/>'
                        + '</p>'
                        + '<a href="https://' + (dados['website']) + '" target="new" class="modal-site">' + (dados['website']) + '</a>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '<br/>';
            });
            $("#modalrep").append(modal);
            $("#callbtn").trigger("click");
        });
    });
});
