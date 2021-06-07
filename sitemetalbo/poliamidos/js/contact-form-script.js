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

    $.ajax({
        type: "POST",
        url: "php/form-process.php",
        data: "name=" + name + "&email=" + email + "&msg_subject=" + msg_subject + "&message=" + message + "&msg_estado=" + msg_estado,
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
	submitMSG(true, "Messagem enviada com sucesso!");
    $("#contactForm")[0].reset();
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

$.getJSON("https://sistema.metalbo.com.br/index.php?classe=NoticiaSite&metodo=getFeed&filcgc=poliamidos", function (data) {

    console.log(data);
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
    $("#divFeed").append(html);
});