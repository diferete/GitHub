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


}(jQuery));

//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getES() {
    //Captura valor númerico do código do estado
    var ufNaturalidade = $("#ufNaturalidade").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + ufNaturalidade + '/municipios', function (result) {
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

//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getESMora() {
    //Captura valor númerico do código do estado
    var ufNaturalidade = $("#ufMora").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + ufNaturalidade + '/municipios', function (result) {
        //Variavel alimentada com o HTML criando os options do select de Cidades
        //Valor padrão do primeiro item do select usado como "legenda" do campo
        var htmlSelect = '<option value="0" disabled selected>Selecione a Cidade</option>';
        //For each utilizado para alimentar HTML do select com os options contendo nomes das cidades
        result.forEach(function (es) {
            htmlSelect = htmlSelect + '<option value="' + es['nome'] + '">' + es['nome'] + '</option>';
        });
        //Limpa e cria append do HTML do select de cidades
        $("#cidadeMora").empty().append(htmlSelect);
    });
}
//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getESAnt() {
    //Captura valor númerico do código do estado
    var ufNaturalidade = $("#ufAnt").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + ufNaturalidade + '/municipios', function (result) {
        //Variavel alimentada com o HTML criando os options do select de Cidades
        //Valor padrão do primeiro item do select usado como "legenda" do campo
        var htmlSelect = '<option value="0" disabled selected>Selecione a Cidade</option>';
        //For each utilizado para alimentar HTML do select com os options contendo nomes das cidades
        result.forEach(function (es) {
            htmlSelect = htmlSelect + '<option value="' + es['nome'] + '">' + es['nome'] + '</option>';
        });
        //Limpa e cria append do HTML do select de cidades
        $("#cidadeAnt").empty().append(htmlSelect);
    });
}
//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getESEmpresa1() {
    //Captura valor númerico do código do estado
    var ufNaturalidade = $("#ufEmpresa1").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + ufNaturalidade + '/municipios', function (result) {
        //Variavel alimentada com o HTML criando os options do select de Cidades
        //Valor padrão do primeiro item do select usado como "legenda" do campo
        var htmlSelect = '<option value="0" disabled selected>Selecione a Cidade</option>';
        //For each utilizado para alimentar HTML do select com os options contendo nomes das cidades
        result.forEach(function (es) {
            htmlSelect = htmlSelect + '<option value="' + es['nome'] + '">' + es['nome'] + '</option>';
        });
        //Limpa e cria append do HTML do select de cidades
        $("#cidadeEmpresa1").empty().append(htmlSelect);
    });
}
//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getESEmpresa2() {
    //Captura valor númerico do código do estado
    var ufNaturalidade = $("#ufEmpresa2").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + ufNaturalidade + '/municipios', function (result) {
        //Variavel alimentada com o HTML criando os options do select de Cidades
        //Valor padrão do primeiro item do select usado como "legenda" do campo
        var htmlSelect = '<option value="0" disabled selected>Selecione a Cidade</option>';
        //For each utilizado para alimentar HTML do select com os options contendo nomes das cidades
        result.forEach(function (es) {
            htmlSelect = htmlSelect + '<option value="' + es['nome'] + '">' + es['nome'] + '</option>';
        });
        //Limpa e cria append do HTML do select de cidades
        $("#cidadeEmpresa2").empty().append(htmlSelect);
    });
}
//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getESEmpresa3() {
    //Captura valor númerico do código do estado
    var ufNaturalidade = $("#ufEmpresa3").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + ufNaturalidade + '/municipios', function (result) {
        //Variavel alimentada com o HTML criando os options do select de Cidades
        //Valor padrão do primeiro item do select usado como "legenda" do campo
        var htmlSelect = '<option value="0" disabled selected>Selecione a Cidade</option>';
        //For each utilizado para alimentar HTML do select com os options contendo nomes das cidades
        result.forEach(function (es) {
            htmlSelect = htmlSelect + '<option value="' + es['nome'] + '">' + es['nome'] + '</option>';
        });
        //Limpa e cria append do HTML do select de cidades
        $("#cidadeEmpresa3").empty().append(htmlSelect);
    });
}

//Função para gerar e enviar o PDF via e-mail para Metalbo com cópia do PDF para o usuário
function sendPdfEmail() {
//Variaveis para pegar valores

    var nomeCurr = $('#nomeCurr').val();
    var dataNasc = $('#dataNasc').val();
    var pais = $('#pais').val();
    var ufNaturalidade = $('#ufNaturalidade').val();
    var cidade = $('#cidade').val();
    var genero = $('#genero').val();
    var altura = $('#altura').val();
    var peso = $('#peso').val();
    var estCivil = $('#estCivil').val();
    var conjuge = $('#conjuge').val();
    var dateNascConj = $('#dateNascConj').val();
    var filhos = $('#filhos').val();
    var menor14 = $('#menor14').val();
    var mae = $('#mae').val();
    var pai = $('#pai').val();
    var pcd = $('#pcd').val();
    var tipopcd = $('#tipopcd').val();
    var email = $('#email').val();
    var fone = $('#fone').val();
    var rua = $('#rua').val();
    var bairro = $('#bairro').val();
    var numero = $('#numero').val();
    var cep = $('#cep').val();
    var ufMora = $('#ufMora').val();
    var cidadeMora = $('#cidadeMora').val();
    var tempoMora = $('#tempoMora').val();
    var ufAnt = $('#ufAnt').val();
    var cidadeAnt = $('#cidadeAnt').val();
    var rg = $('#rg').val();
    var cpf = $('#cpf').val();
    var ctps = $('#ctps').val();
    var seriectps = $('#seriectps').val();
    var titeleitor = $('#titeleitor').val();
    var pis = $('#pis').val();
    var escolaridade = $('#escolaridade').val();
    var entidade = $('#entidade').val();
    var curso = $('#curso').val();
    var Empresa1 = $('#Empresa1').val();
    var ufEmpresa1 = $('#ufEmpresa1').val();
    var cidadeEmpresa1 = $('#cidadeEmpresa1').val();
    var foneEmpresa1 = $('#foneEmpresa1').val();
    var date1Empresa1 = $('#date1Empresa1').val();
    var date2Empresa1 = $('#date2Empresa1').val();
    var Empresa2 = $('#Empresa2').val();
    var ufEmpresa2 = $('#ufEmpresa2').val();
    var cidadeEmpresa2 = $('#cidadeEmpresa2').val();
    var foneEmpresa2 = $('#foneEmpresa2').val();
    var date1Empresa2 = $('#date1Empresa2').val();
    var date2Empresa2 = $('#date2Empresa2').val();
    var Empresa3 = $('#Empresa3').val();
    var ufEmpresa3 = $('#ufEmpresa3').val();
    var cidadeEmpresa3 = $('#cidadeEmpresa3').val();
    var foneEmpresa3 = $('#foneEmpresa3').val();
    var date1Empresa3 = $('#date1Empresa3').val();
    var date2Empresa3 = $('#date2Empresa3').val();

    var dataToSend = JSON.stringify({
        "nomeCurr": nomeCurr,
        "dataNasc": dataNasc,
        "pais": pais,
        "ufNaturalidade": ufNaturalidade,
        "cidade": cidade,
        "genero": genero,
        "altura": altura,
        "peso": peso,
        "estCivil": estCivil,
        "conjuge": conjuge,
        "dateNascConj": dateNascConj,
        "filhos": filhos,
        "menor14": menor14,
        "mae": mae,
        "pai": pai,
        "pcd": pcd,
        "tipopcd": tipopcd,
        "email": email,
        "fone": fone,
        "rua": rua,
        "bairro": bairro,
        "numero": numero,
        "cep": cep,
        "ufMora": ufMora,
        "cidadeMora": cidadeMora,
        "tempoMora": tempoMora,
        "ufAnt": ufAnt,
        "cidadeAnt": cidadeAnt,
        "rg": rg,
        "cpf": cpf,
        "ctps": ctps,
        "seriectps": seriectps,
        "titeleitor": titeleitor,
        "pis": pis,
        "escolaridade": escolaridade,
        "entidade": entidade,
        "curso": curso,
        "Empresa1": Empresa1,
        "ufEmpresa1": ufEmpresa1,
        "cidadeEmpresa1": cidadeEmpresa1,
        "foneEmpresa1": foneEmpresa1,
        "date1Empresa1": date1Empresa1,
        "date2Empresa1": date2Empresa1,
        "Empresa2": Empresa2,
        "ufEmpresa2": ufEmpresa2,
        "cidadeEmpresa2": cidadeEmpresa2,
        "foneEmpresa2": foneEmpresa2,
        "date1Empresa2": date1Empresa2,
        "date2Empresa2": date2Empresa2,
        "Empresa3": Empresa3,
        "ufEmpresa3": ufEmpresa3,
        "cidadeEmpresa3": cidadeEmpresa3,
        "foneEmpresa3": foneEmpresa3,
        "date1Empresa3": date1Empresa3,
        "date2Empresa3": date2Empresa3
    });

    if (nomeCurr === '' || cidade === 0 || pcd === 0 || rg === '' || cpf === '' || ctps === '' || seriectps === '' || pis === '' || fone === '') {
        //Caso erro, mostra mensagem vermelha com mensagem de erro
        $("#waiting-msg").text('Atenção, alguns dados importantes não foram preenchidos. Tente preencher o máximo de campos possíveis!').addClass('email-error').removeClass('shake animated hidden email-success').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $("#waiting-msg").removeClass('shake animated');
        });
    } else {
        $("#waiting-msg").text('Olá, aguarde enquanto enviamos seu currículo para a Metalbo.').removeClass('shake animated hidden email-error email-success').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $("#waiting-msg").removeClass('shake animated');
        });
        $.getJSON("http://localhost/github/frame_metalbo/index.php?classe=MET_RH_Curriculo&metodo=getDadosCurriculo" + "&dados=" + dataToSend, function (result) {
            if (result === 'success') {
                //Caso sucesso, mostra mensagem verde com mensagem de sucesso
                $("#waiting-msg").text('Um e-mail com o seu currículo em anexo foi enviado com sucesso para a Metalbo, cheque sua caixa de entrada para uma cópia!').addClass('email-success').removeClass('shake animated hidden email-error').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $("#waiting-msg").removeClass('shake animated');
                });
            } else {
                //Caso erro, mostra mensagem vermelha com mensagem de erro
                $("#waiting-msg").text('Erro ao tentar enviar o currículo para a Metalbo, tente novamente mais tarde ou confira os campos preenchidos!').addClass('email-error').removeClass('shake animated hidden email-success').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $("#waiting-msg").removeClass('shake animated');
                });
            }
        });
    }

}