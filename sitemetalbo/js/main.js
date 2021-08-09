(function ($) {

    "use strict";

    /* 
     CounterUp
     ========================================================================== */
    $('.counter').counterUp({
        time: 500
    });

    /* 
     MixitUp
     ========================================================================== */
    $('#portfolio').mixItUp();

    /* 
     Clients Sponsor 
     ========================================================================== */
    var owl = $("#clients-scroller");
    owl.owlCarousel({
        items: 5,
        itemsTablet: 3,
        margin: 90,
        stagePadding: 90,
        smartSpeed: 450,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [768, 3],
        itemsTablet: [767, 2],
        itemsTabletSmall: [480, 2],
        itemsMobile: [479, 1],
    });


    /* 
     Touch Owl Carousel
     ========================================================================== */
    var owl = $(".touch-slider");
    owl.owlCarousel({
        navigation: false,
        pagination: true,
        slideSpeed: 1000,
        stopOnHover: true,
        autoPlay: true,
        items: 1,
        itemsDesktopSmall: [1024, 1],
        itemsTablet: [600, 1],
        itemsMobile: [479, 1]
    });

    $('.touch-slider').find('.owl-prev').html('<i class="fa fa-chevron-left"></i>');
    $('.touch-slider').find('.owl-next').html('<i class="fa fa-chevron-right"></i>');

    /* 
     Sticky Nav
     ========================================================================== */
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 200) {
            $('.header-top-area').addClass('menu-bg');
        } else {
            $('.header-top-area').removeClass('menu-bg');
        }
    });

    /* 
     VIDEO POP-UP
     ========================================================================== */
    $('.video-popup').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
    });

    /* 
     Back Top Link
     ========================================================================== */
    var offset = 200;
    var duration = 500;
    $(window).scroll(function () {
        if ($(this).scrollTop() > offset) {
            $('.back-to-top').fadeIn(400);
        } else {
            $('.back-to-top').fadeOut(400);
        }
    });

    $('.back-to-top').on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 600);
        return false;
    })

    /* 
     One Page Navigation & wow js
     ========================================================================== */
    //Initiat WOW JS
    new WOW().init();

    // one page navigation 
    $('.main-navigation').onePageNav({
        currentClass: 'active'
    });

    $(window).on('load', function () {

        $('body').scrollspy({
            target: '.navbar-collapse',
            offset: 195
        });

        $(window).on('scroll', function () {
            if ($(window).scrollTop() > 200) {
                $('.fixed-top').addClass('menu-bg');
            } else {
                $('.fixed-top').removeClass('menu-bg');
            }
        });

    });
    /* Nivo Lightbox
     ========================================================*/
    $('.lightbox').nivoLightbox({
        effect: 'fadeScale',
        keyboardNav: true,
    });

    /* Map Form Toggle
     ========================================================*/
    $('.map-icon').on('click', function (e) {
        $('#google-map').toggleClass('panel-show');
        e.preventDefault();
    });

    /* stellar js
     ========================================================*/
    $.stellar({
        horizontalScrolling: false,
        verticalOffset: 40,
        responsive: true
    });

    /* 
     Page Loader
     ========================================================================== */
    $(window).on('load', function () {
        "use strict";
        $('#loader').fadeOut();
    });

}(jQuery));

//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getES() {
    //Captura valor númerico do código do estado
    var uf = $("#uf").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + uf + '/municipios', function (result) {
        //Variavel alimentada com o HTML criando os options do select de Cidades
        //Valor padrão do primeiro item do select usado como "legenda" do campo
        var htmlSelect = '<option value="0" disabled selected>Selecione a Cidade</option>';
        //For each utilizado para alimentar HTML do select com os options contendo nomes das cidades
        result.forEach(function (es) {
            htmlSelect = htmlSelect + '<option value="' + es['nome'] + '">' + es['nome'] + '</option>';
        });
        //Limpa e cria append do HTML do select de cidades
        $("#cidade").empty().append(htmlSelect);
    });
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
/*
 $("#nome").one("click", function mensagemAlert() {
 var campo = $("#nome").val();
 if (campo == '') {
 var sTit = "Caro usuário!";
 var sMsg = "A Metalbo trabalha diretamente com Representantes para suas vendas por isso solicitamos entre em contato com eles para fazer suas COTAÇÕES e ORÇAMENTOS. Acesse a área de Representantes no site, clique em 'SELECIONE SEU ESTADO(UF)' e encontre o Representante que pode lhe atender ;)."
 sweetAlert(sTit, sMsg, "info");
 }
 });*/

(() => {
    if (!localStorage.pureJavaScriptCookies) {
        document.querySelector(".box-cookies").classList.remove('hide');
    }

    const acceptCookies = () => {
        document.querySelector(".box-cookies").classList.add('hide');
        localStorage.setItem("pureJavaScriptCookies", "accept");
    };

    const btnCookies = document.querySelector(".btn-cookies");

    btnCookies.addEventListener('click', acceptCookies);
})();


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
