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

$.getJSON("https://sistema.metalbo.com.br/index.php?classe=NoticiaSite&metodo=getNoticias&filcgc=metalbo", function (data) {
    console.log(data);
    var html = '';
    data.forEach(function (o) {
        html = html + '<div class="col-lg-12 col-md-12 col-sm-12">'
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
    $("#divNoticias").append(html);
});


