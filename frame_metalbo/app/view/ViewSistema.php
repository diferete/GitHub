<?php

/**
 * Classe que implementa as operações de tela referentes ao 
 * objeto SISTEMA
 * 
 * @author Avanei Martendal
 * @since 21/09/2015
 * 
 */
class ViewSistema extends View {
    /*
     * retorna a localização da tela principal do sistema
     */

    function retornaTelaInicial() {

        $telaInicial = 'window.location = "index.php?classe=Sistema&metodo=getTelaInicial";';
        return $telaInicial;
    }

    /*
     * Método que constroi a tela inicial do sistema
     */

    function constroiTelaInicial() {
        //verifica se há representantes atrelados
        if (isset($_SESSION['repsoffice'])) {
            $aRep = explode(',', $_SESSION['repsoffice']);


            $aPag = array_chunk($aRep, 5);
            foreach ($aPag as $key => $aValue) {
                $sRep .= '<h6 class="media-heading">Rep:';
                foreach ($aValue as $ikey => $sValue) {
                    $sRep .= $sValue;
                }
                $sRep .= '</h6>';
            }
        }
        /* traz a versão do sistema */
        $oVersao = Fabrica::FabricarPersistencia('VersaoSistema');
        $sVersao = $oVersao->mostraVersaoSistema();

        $oSetor = Fabrica::FabricarPersistencia('User');
        $sSetor = $oSetor->buscaSetor();

        date_default_timezone_set('America/Sao_Paulo');

        $sTela = '<!DOCTYPE html>'
                . '<html><!-- class="no-js" lang="en"-->'
                . '<head> '
                . '<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                . '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">'
                . '<meta name="description" content="bootstrap admin template">'
                . '<meta name="author" content="">'
                . '<title>Metalbo | Sistema</title>'
                . '<link rel="shortcut icon" href="biblioteca/assets/images/favicon.ico">'
                . '<!-- Stylesheets -->'
                . '<link rel="stylesheet" href="biblioteca/assets/css/bootstrap.min.css?' . time() . '">'
                . '<link rel="stylesheet" href="biblioteca/assets/css/bootstrap-extend.min.css?' . time() . '">'
                . '<link rel="stylesheet" href="biblioteca/assets/css/site.min.css?' . time() . '"><!-- ok-->'
                . '<!-- Estilo personalizado -->'
                . '<link rel="stylesheet" href="biblioteca/assets/css/estilo.css?' . time() . '">'
                . '<!-- FormValidation -->'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/formvalidation/formValidation.css">'
                . '<!-- Plugins -->'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/animsition/animsition.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/asscrollable/asScrollable.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/switchery/switchery.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/intro-js/introjs.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/slidepanel/slidePanel.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/flag-icon-css/flag-icon.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/bootstrap-sweetalert/sweet-alert.css">'
                . '<!--Tag input-->'
                . '<link rel="stylesheet" type="text/css" href="biblioteca/tagsinput/src/jquery.tagsinput.css" />'
                . '<!-- Datatables -->'
                . '<link rel="stylesheet" type="text/css" href="biblioteca/datatables/media/css/jquery.dataTables.css">'
                . '<link rel="stylesheet" type="text/css" href="biblioteca/datatables/extensions/Select/css/select.dataTables.min.css">'
                . '<link rel="stylesheet" type="text/css" href="biblioteca/datatables/extensions/Buttons/css/buttons.dataTables.min.css">'
                . '<!-- Fonts -->'
                . '<link rel="stylesheet" href="biblioteca/assets/fonts/web-icons/web-icons.min.css">'
                . '<link rel="stylesheet" href="biblioteca/assets/fonts/brand-icons/brand-icons.min.css">'
                //. '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic">'
                . '<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">'
                . '<link rel="stylesheet" href="biblioteca/assets/fonts/font-awesome/font-awesome.css">'
                . '<!-- Scripts -->'
                . '<script src="biblioteca/assets/vendor/modernizr/modernizr.js"></script>'
                . '<script src="biblioteca/assets/vendor/breakpoints/breakpoints.js"></script>'
                . '<script src="biblioteca/assets/vendor/jquery/jquery.js"></script>'
                . '<script type="text/javascript" src="biblioteca/datatables/media/js/jquery.dataTables.js"></script>'
                . '<script type="text/javascript" src="biblioteca/datatables/extensions/Select/js/dataTables.select.min.js"></script> '
                . '<script type="text/javascript" src="biblioteca/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>'
                . '<!-- Datepicker-->'
                . '<link href="biblioteca/assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>'
                . '<!-- Select2 -->'
                . '<link href="biblioteca/assets/css/select2.css" rel="stylesheet" type="text/css"/>'
                . '<!-- File upload -->'
                . '<link href="biblioteca/assets/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />'
                . '<!-- Toastr -->'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/toastr/toastr.css">'
                . '<!-- FormValidation -->'
                . '<script src="biblioteca/assets/vendor/formvalidation/formValidation.min.js"></script>'
                . '<script src="biblioteca/assets/vendor/formvalidation/framework/bootstrap.min.js"></script>'
                . '<script src="biblioteca/assets/vendor/formvalidation/language/pt_BR.js"></script>'
                . '<!-- FieldSet Collapse -->'
                . '<link href="biblioteca/assets/vendor/jquery-coolfieldset/css/jquery.coolfieldset.css" rel="stylesheet" type="text/css" />'
                . '<script src="biblioteca/assets/vendor/jquery-coolfieldset/js/jquery.coolfieldset.min.js"></script>'
                . '<!-- FileInput -->'
                . '<link href="biblioteca/assets/vendor/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>'
                . '<!-- Summernote - Editor de Texto-->'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/summernote/summernote.css">'
                . '<script src="biblioteca/assets/vendor/summernote/summernote.min.js"></script>'
                . '<script src="biblioteca/assets/vendor/summernote/lang/summernote-pt-BR.js"></script>'
                . '<script>'
                . 'Breakpoints();'
                . '</script>'
                . '</head>'
                . '<body id="body"><!--class="site-menubar-unfold" data-auto-menubar="false"-->'
                . '<script>'
                . 'var classeBusca;'
                . 'var metodoBusca;'
                . 'var idbusca;'
                . 'var campoBusca;'
                . 'var campoValor;'
                . 'var campoRetId;'
                . 'var controleRequest = "s";'
                . 'var abaSelecionada;'
                . '</script>'
                . '<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega " role="navigation">'
                . '<div class="navbar-header">'
                . '<button type="button" class="navbar-toggle hamburger hamburger-arrow-left navbar-toggle-left hided" data-toggle="menubar">'
                . '<span class="sr-only">Toggle navigation</span>'
                . '<span class="hamburger-bar"></span>'
                . '</button>'
                . '<button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">'
                . '<i class="icon wb-more-horizontal" aria-hidden="true"></i>'
                . '</button>'
                //.'<div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">'
                . '<a href="https://sistema.metalbo.com.br/" target="_blank" rel="noopener">'
                . '<img class="navbar-brand-logo" style ="margin-top:10px; margin-left:10px" id="logo" src="Uploads/' . $_SESSION['imgLogo'] . '" title="Metalbo"> </a>'
                //.'<span class="navbar-brand-text"> </span>'
                //.'</div>'
                /* .'<button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"'
                  .' data-toggle="collapse">'
                  .'<span class="sr-only">Toggle Search</span>'
                  .'<i class="icon wb-search" aria-hidden="true"></i>'
                  .'</button>' */
                . '</div>'
                . '<div class="navbar-container container-fluid">'
                . '<!-- Navbar Collapse -->'
                . '<div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">'
                . '<!-- Navbar Toolbar -->'
                . '<ul class="nav navbar-toolbar">'
                . '<li class="hidden-float" id="toggleMenubar">'
                . '<a data-toggle="menubar" href="#" role="button">'
                . '<i class="icon hamburger hamburger-arrow-left">'
                . '<span class="sr-only">Toggle menubar</span>'
                . '<span class="hamburger-bar"></span>'
                . '</i>'
                . '</a>'
                . '</li>'
                /*
                 * Tela Cheia
                  .'<li class="hidden-xs" id="toggleFullscreen">'
                  .'<a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">'
                  .'<span class="sr-only">Toggle fullscreen</span>'
                  .'</a>'
                  .'</li>'
                 */
                /*
                 * Pesquisar
                  .'<li class="hidden-float">'
                  .'<a class="icon wb-search" data-toggle="collapse" href="#" data-target="#site-navbar-search" role="button">'
                  .'<span class="sr-only">Toggle Search</span>'
                  .'</a>'
                  .'</li>'
                 */
                . '<!--INICIA O MENU SUPERIOR-->'
                . '<li class="dropdown dropdown-fw dropdown-mega"> '
                . '<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="fade" role="button">'
                . '<i class="icon fa-stack-overflow" aria-hidden="true">'
                . '</i> Módulos'
                . '</a>'
                . '<ul class="dropdown-menu" role="menu" style="width:20%">'
                . '<li role="presentation">'
                . '<div class="mega-content">'
                . '<div class="row">'
                . '<div class="col-lg-12">'
                . '<div class="list-group bg-blue-grey-100 bg-inherit">'
                . $this->montaModulo()
                . '</div>'
                . '</div> '
                . '</div>'
                . '</div>'
                . '</li>'
                . '</ul>'
                . '</li>'
                . '<!--fim acesso modulos-->'
                . '<li class="dropdown">'
                . '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-down" aria-expanded="false" role="button">'
                . '<span class="icon fa-star-o"></span>'
                . '</a>'
                . '<ul class="dropdown-menu" role="menu" id="favGeral-1">'
                . $this->favMenu()
                /* .'<li role="presentation">'
                  .'<a href="javascript:void(0)" role="menuitem">'
                  .'<span class="icon fa-star-o"></span>teste1</a>'
                  .'</li>'
                  .'<li role="presentation">'
                  .'<a href="javascript:void(0)" role="menuitem">'
                  .'<span class="icon fa-star-o"></span>teste2</a>'
                  .'</li>' */
                . '</ul>'
                . '</li>'
                /* .'<li class="dropdown dropdown-fw dropdown-mega">'
                  .'<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"'
                  .' data-animation="fade" role="button">Mega <i class="icon wb-chevron-down-mini" aria-hidden="true"></i></a>'
                  .'<ul class="dropdown-menu" role="menu">'
                  .'<li role="presentation">'
                  .'<div class="mega-content">'
                  .'<div class="row">'
                  .'<div class="col-sm-4">'
                  .'<h5>UI Kit</h5>'
                  .'<ul class="blocks-2">'
                  .'<li class="mega-menu margin-0">'
                  .'<ul class="list-icons">'
                  .'<li><i class="wb-chevron-right-mini" aria-hidden="true"></i>'
                  .'<a href="../advanced/animation.html">Animation</a>'
                  .'</li>'
                  .'</ul>'
                  .'</li>'
                  .'<li class="mega-menu margin-0">'
                  .'<ul class="list-icons">'
                  .'<li><i class="wb-chevron-right-mini" aria-hidden="true"></i>'
                  .'<a href="../uikit/modals.html">Modals</a>'
                  .'</li>'
                  .'</ul>'
                  .'</li>'
                  .'</ul>'
                  .'</div>'
                  .'<div class="col-sm-4">'
                  .'<h5>Media'
                  .'<span class="badge badge-success">4</span>'
                  .'</h5>'
                  .'<ul class="blocks-3">'
                  .'<li>'
                  .'<a class="thumbnail margin-0" href="javascript:void(0)">'
                  .'<img class="width-full" src="biblioteca/assets/photos/placeholder.png" alt="..." />'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a class="thumbnail margin-0" href="javascript:void(0)">'
                  .'<img class="width-full" src="biblioteca/assets/photos/placeholder.png" alt="..." />'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a class="thumbnail margin-0" href="javascript:void(0)">'
                  .'<img class="width-full" src="biblioteca/assets/photos/placeholder.png" alt="..." />'
                  .'</a>'
                  .'</li>'
                  .'</ul>'
                  .'</div>'
                  .'<div class="col-sm-4">'
                  .'<h5 class="margin-bottom-0">Accordion</h5>'
                  .'<!-- Accordion -->'
                  .'<div class="panel-group panel-group-simple" id="siteMegaAccordion" aria-multiselectable="true"'
                  .' role="tablist">'
                  .'<div class="panel">'
                  .'<div class="panel-heading" id="siteMegaAccordionHeadingOne" role="tab">'
                  .'<a class="panel-title" data-toggle="collapse" href="#siteMegaCollapseOne" data-parent="#siteMegaAccordion"'
                  .' aria-expanded="false" aria-controls="siteMegaCollapseOne">'
                  .' Collapsible Group Item #1'
                  .'</a>'
                  .'</div>'
                  .'<div class="panel-collapse collapse" id="siteMegaCollapseOne" aria-labelledby="siteMegaAccordionHeadingOne"'
                  .' role="tabpanel">'
                  .'<div class="panel-body">'
                  .'</div>'
                  .'</div>'
                  .'</div>'
                  .'<div class="panel">'
                  .'<div class="panel-heading" id="siteMegaAccordionHeadingTwo" role="tab">'
                  .'<a class="panel-title collapsed" data-toggle="collapse" href="#siteMegaCollapseTwo"'
                  .' data-parent="#siteMegaAccordion" aria-expanded="false"'
                  .' aria-controls="siteMegaCollapseTwo">'
                  .' Collapsible Group Item #2'
                  .'</a>'
                  .'</div>'
                  .'</div>'
                  .'</div>'
                  .'<!-- End Accordion -->'
                  .'</div>'
                  .'</div>'
                  .'</div>'
                  .'</li>'
                 */
                . '</ul>'
                . '</li>'
                . '</ul>'
                . '<!-- End Navbar Toolbar -->'
                . '<!--MENU DA DIREITA -->'
                . '<ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">'
                . '<li class="dropdown">'
                . '<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"'
                . ' aria-expanded="false" role="button">'
                . '<span class="flag-icon flag-icon-br"></span>'
                . '</a>'
                . '<ul class="dropdown-menu" role="menu">'
                . '<li role="presentation">'
                . '<a href="javascript:void(0)" role="menuitem">'
                . '<span class="flag-icon flag-icon-us"></span> English</a>'
                . '</li>'
                . '<li role="presentation">'
                . '<a href="javascript:void(0)" role="menuitem">'
                . '<span class="flag-icon flag-icon-ar"></span> Español</a>'
                . '</li>'
                . '</ul>'
                . '</li>'
                . '<li class="dropdown">'
                . '<a data-toggle="dropdown" href="javascript:void(0)" class="info-set" title="Informações do Usuário" aria-expanded="false"'
                . ' data-animation="scale-up" role="button">'
                . '<i class="icon wb-user" aria-hidden="true"></i>'
                . '<span class="badge badge-success up">1</span>'
                . '</a>'
                . '<ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">'
                . '<li class="dropdown-menu-header" role="presentation">'
                . '<h5>Informações do usuário</h5>'
                . '</li>'
                . '<li class="list-group" role="presentation">'
                . '<div data-role="container">'
                . '<div data-role="content">'
                . '<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                . '<div class="media">'
                . '<div class="media-left padding-right-10">'
                . '<i class="icon wb-user bg-green-600 white icon-circle" aria-hidden="true"></i>'
                . '</div>'
                . '<div class="media-body">'
                . '<h6 class="media-heading">Nome: ' . $_SESSION['nome'] . '</h6>'
                . '<h6 class="media-heading">Setor: ' . $sSetor . '</h6>'
                . '<h6 class="media-heading">Login: ' . $_SESSION['loginUser'] . '</h6>'
                . '<h6 class="media-heading">Código: ' . $_SESSION['codUser'] . '</h6>'
                . '<h6 class="media-heading">Email: ' . $_SESSION['email'] . '</h6>'
                . $sRep
                . '</div>'
                . '</div>'
                . '</a>'
                . '<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                . '<div class="media">'
                . '<div class="media-left padding-right-10">'
                . '<i class="icon wb-order bg-green-600 white icon-circle" aria-hidden="true"></i>'
                . '</div>'
                . '<div class="media-body">'
                . '<h6 class="media-heading">Base: ' . $_SESSION['nomeBanco'] . '</h6>'
                . '<h6 class="media-heading">Servidor: ' . $_SESSION['servidor'] . '</h6>'
                . '<h6 class="media-heading">Versão: ' . $sVersao . '</h6>'
                . '</div>'
                . '</div>'
                . '</a>'
                . '</li>'
                . '</ul>'
                . '<li class="dropdown">'
                . '<a class="navbar-avatar avatar-lg dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"'
                . ' data-animation="scale-up" role="button">'
                . '<span class="avatar avatar-online">'
                . '<img id="on-line" src="Uploads/' . $_SESSION["usuimagem"] . '" style="height: 30px;">'
                . '<i></i>'
                . '</span>'
                . '</a>'
                . '<ul class="dropdown-menu" role="menu">'
                . '<li role="presentation">'
                . '<a href="javascript:void(0)" role="menuitem" onclick="verificaTab(\'menu-1-p\',\'1-p\',\'Profile\',\'acaoMostraTelaPerfil\',\'usucodigo=' . $_SESSION["codUser"] . ',tabmenu-1-pcontrol\',\'Meu Perfil\');"><i class="icon wb-user" aria-hidden="true"></i> Perfil</a>'
                . '</li>'
                /* .'<li role="presentation">'
                  .'<a href="javascript:void(0)" role="menuitem"><i class="icon wb-payment" aria-hidden="true"></i> Billing</a>'
                  .'</li>'
                  .'<li role="presentation">'
                  .'<a href="javascript:void(0)" role="menuitem"><i class="icon wb-settings" aria-hidden="true"></i> Settings</a>'
                  .'</li>' */
                . '<li class="divider" role="presentation"></li>'
                . '<li role="presentation">'
                . '<a href="javascript:void(0)" role="menuitem" onclick="requestAjax(\'\',\'Usuario\',\'acaoLogout\',\'\')"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>'
                . '</li>'
                . '</ul>'
                . '</li>'
                // .'<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                // .'<div class="media">'
                // .'<div class="media-left padding-right-10">'
                // .'<i class="icon wb-settings bg-red-600 white icon-circle" aria-hidden="true"></i>'
                // .'</div>'
                // .'<div class="media-body">'
                // .'<h6 class="media-heading">Settings updated</h6>'
                // .'<time class="media-meta" datetime="2015-06-11T14:05:00+08:00">2 days ago</time>'
                // .'</div>'
                // .'</div>'
                // .'</a>'
                // .'<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                // .'<div class="media">'
                // .'<div class="media-left padding-right-10">'
                // .'<i class="icon wb-calendar bg-blue-600 white icon-circle" aria-hidden="true"></i>'
                // .'</div>'
                // .'<div class="media-body">'
                // .'<h6 class="media-heading">Event started</h6>'
                // .'<time class="media-meta" datetime="2015-06-10T13:50:18+08:00">3 days ago</time>'
                // .'</div>'
                // .'</div>'
                // .'</a>'
                // .'<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                // .'<div class="media">'
                // .'<div class="media-left padding-right-10">'
                // .'<i class="icon wb-chat bg-orange-600 white icon-circle" aria-hidden="true"></i>'
                // .'</div>'
                // .'<div class="media-body">'
                // .'<h6 class="media-heading">Message received</h6>'
                // .'<time class="media-meta" datetime="2015-06-10T12:34:48+08:00">3 days ago</time>'
                // .'</div>'
                // .'</div>'
                // .'</a>'
                // .'</div>'
                // .'</div>'
                // .'</li>'
                // .'<li class="dropdown-menu-footer" role="presentation">'
                // .'<a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">'
                // .'<i class="icon wb-settings" aria-hidden="true"></i>'
                // .'</a>'
                // .'<a href="javascript:void(0)" role="menuitem">'
                // .' All notifications'
                // .'</a>'
                // .'</li>'
                // .'</ul>'
                // .'</li>'
                // .'<li class="dropdown">'
                // .'<a data-toggle="dropdown" href="javascript:void(0)" title="Messages" aria-expanded="false"'
                // .' data-animation="scale-up" role="button">'
                // .'<i class="icon wb-envelope" aria-hidden="true"></i>'
                // .'<span class="badge badge-info up">3</span>'
                // .'</a>'
                // .'<ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">'
                // .'<li class="dropdown-menu-header" role="presentation">'
                // .'<h5>MESSAGES</h5>'
                // .'<span class="label label-round label-info">New 3</span>'
                // .'</li>'
                // .'<li class="list-group" role="presentation">'
                // .'<div data-role="container">'
                // .'<div data-role="content">'
                // .'<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                // .'<div class="media">'
                // .'<div class="media-left padding-right-10">'
                // .'<span class="avatar avatar-sm avatar-online">'
                // .'<img src="biblioteca/assets/portraits/2.jpg" alt="..." />'
                // .'<i></i>'
                // .'</span>'
                // .'</div>'
                // .'<div class="media-body">'
                // .'<h6 class="media-heading">Mary Adams</h6>'
                // .'<div class="media-meta">'
                // .'<time datetime="2015-06-17T20:22:05+08:00">30 minutes ago</time>'
                // .'</div>'
                // .'<div class="media-detail">Anyways, i would like just do it</div>'
                // .'</div>'
                // .'</div>'
                // .'</a>'
                // .'<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                // .'<div class="media">'
                // .'<div class="media-left padding-right-10">'
                // .'<span class="avatar avatar-sm avatar-off">'
                // .'<img src="biblioteca/assets/portraits/3.jpg" alt="..." />'
                // .'<i></i>'
                // .'</span>'
                // .'</div>'
                // .'<div class="media-body">'
                // .'<h6 class="media-heading">Caleb Richards</h6>'
                // .'<div class="media-meta">'
                // .'<time datetime="2015-06-17T12:30:30+08:00">12 hours ago</time>'
                // .'</div>'
                // .'<div class="media-detail">I checheck the document. But there seems</div>'
                // .'</div>'
                // .'</div>'
                // .'</a>'
                // .'<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                // .'<div class="media">'
                // .'<div class="media-left padding-right-10">'
                // .'<span class="avatar avatar-sm avatar-busy">'
                // .'<img src="biblioteca/assets/portraits/4.jpg" alt="..." />'
                // .'<i></i>'
                // .'</span>'
                // .'</div>'
                // .'<div class="media-body">'
                // .'<h6 class="media-heading">June Lane</h6>'
                // .'<div class="media-meta">'
                // .'<time datetime="2015-06-16T18:38:40+08:00">2 days ago</time>'
                // .'</div>'
                // .'<div class="media-detail">Lorem ipsum Id consectetur et minim</div>'
                // .'</div>'
                // .'</div>'
                // .'</a>'
                // .'<a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                // .'<div class="media">'
                // .'<div class="media-left padding-right-10">'
                // .'<span class="avatar avatar-sm avatar-away">'
                // .'<img src="biblioteca/assets/portraits/5.jpg" alt="..." />'
                // .'<i></i>'
                // .'</span>'
                // .'</div>'
                // .'<div class="media-body">'
                // .'<h6 class="media-heading">Edward Fletcher</h6>'
                // .'<div class="media-meta">'
                // .'<time datetime="2015-06-15T20:34:48+08:00">3 days ago</time>'
                // .'</div>'
                // .'<div class="media-detail">Dolor et irure cupidatat commodo nostrud nostrud.</div>'
                // .'</div>'
                // .'</div>'
                // .'</a>'
                // .'</div>'
                // .'</div>'
                // .'</li>'
                // .'<li class="dropdown-menu-footer" role="presentation">'
                // .'<a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">'
                // .'<i class="icon wb-settings" aria-hidden="true"></i>'
                // .'</a>'
                // .'<a href="javascript:void(0)" role="menuitem">'
                // .' See all messages'
                // .'</a>'
                // .'</li>'
                // .'</ul>'
                // .'</li>'
                // .'<li id="toggleChat">'
                // .'<a data-toggle="site-sidebar" href="javascript:void(0)" title="Chat" data-url="../site-sidebar.tpl">'
                // .'<i class="icon wb-chat" aria-hidden="true"></i>'
                // .'</a>'
                // .'</li>'
                . '</ul>'
                . '<!-- End Navbar Toolbar Right -->'
                . '</div>'
                . '<!-- End Navbar Collapse -->'
                . '<!-- Site Navbar Seach -->'
                . '<div class="collapse navbar-search-overlap" id="site-navbar-search">'
                . '<form role="search">'
                . '<div class="form-group">'
                . '<div class="input-search">'
                . '<i class="input-search-icon wb-search" aria-hidden="true"></i>'
                . '<input type="text" class="form-control" name="site-search" placeholder="Search...">'
                . '<button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"'
                . ' data-toggle="collapse" aria-label="Close"></button>'
                . '</div>'
                . '</div>'
                . '</form>'
                . '</div>'
                . '</div>'
                . '</nav>'
                . '</div>'
                . '<!-- End Site Navbar Seach -->'
                . '<div class="site-menubar">'
                . '<div class="site-menubar-body">'
                . '<div>'
                . '<div>'
                . '<ul class="site-menu" id="menu">'
                //chamar string do menu
                . $this->menuSistema()
                . '</ul>'
                . '</div>'
                . '</div>'
                . '</div>'
                // .'<div class="site-menubar-footer">'
                // .'<a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"'
                // .' data-original-title="Settings">'
                // .'<span class="icon wb-settings" aria-hidden="true"></span>'
                // .'</a>'
                // .'<a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">'
                // .'<span class="icon wb-eye-close" aria-hidden="true"></span>'
                // .'</a>'
                // .'<a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout" onclick="requestAjax(\'\',\'usuario\',\'acaoLogout\',\'\'>'
                // .'<span class="icon wb-power" aria-hidden="true"></span>'
                // .'</a>'
                // .'</div>'
                . '</div>'
                /* .'<div class="site-gridmenu">'
                  .'<div>'
                  .'<div>'
                  .'<ul>'
                  .'<li>'
                  .'<a href="../apps/mailbox/mailbox.html">'
                  .'<i class="icon wb-envelope"></i>'
                  .'<span>Mailbox</span>'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a href="../apps/calendar/calendar.html">'
                  .'<i class="icon wb-calendar"></i>'
                  .'<span>Calendar</span>'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a href="../apps/contacts/contacts.html">'
                  .'<i class="icon wb-user"></i>'
                  .'<span>Contacts</span>'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a href="../apps/media/overview.html">'
                  .'<i class="icon wb-camera"></i>'
                  .'<span>Media</span>'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a href="../apps/documents/categories.html">'
                  .'<i class="icon wb-order"></i>'
                  .'<span>Documents</span>'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a href="../apps/projects/projects.html">'
                  .'<i class="icon wb-image"></i>'
                  .'<span>Project</span>'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a href="../apps/forum/forum.html">'
                  .'<i class="icon wb-chat-group"></i>'
                  .'<span>Forum</span>'
                  .'</a>'
                  .'</li>'
                  .'<li>'
                  .'<a href="../index.html">'
                  .'<i class="icon wb-dashboard"></i>'
                  .'<span>Dashboard</span>'
                  .'</a>'
                  .'</li>'
                  .'</ul>'
                  .'</div>'
                  .'</div>'
                  .'</div>' */
                . '<!-- Page -->'
                . '<div class="page animsition">'
                . '<!-- <div class="page-header">'
                . '<h1 class="page-title">Menu Expended</h1>'
                . '</div>-->'
                . '<div class="page-content">'
                . '<div class="panel">'
                . '<div class="panel-body">'
                . '<div class="nav-tabs-horizontal nav-tabs-inverse">'
                . '<ul class="nav nav-tabs nav-tabs-solid" data-plugin="nav-tabs" role="tablist" id="tabmenusuperior">'
                . '</ul>'
                . '<div class="tab-content padding-top-15" id="tabmenucont">'/* ONDE VAMOS CRIAR A TELA */
                . $this->montMsgInicial()
                . '</div>'
                . '</div><!--final-->'
                . '</div>'
                . '</div>'
                . '</div>'
                . '</div>'
                . '<!-- End Page -->'
                . '<!-- Footer -->'
                . '<!-- File Input-->'
                . '<script src="biblioteca/assets/vendor/bootstrap-fileinput/js/plugins/canvas-to-blob.js" type="text/javascript"></script>'
                . '<script src="biblioteca/assets/vendor/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>'
                . '<script src="biblioteca/assets/vendor/bootstrap-fileinput/js/fileinput_locale_pt-BR.js" ></script>'
                . '<!-- Core -->'
                . '<script src="biblioteca/jquery-number/jquery.number.js"></script>'
                . '<script src="biblioteca/jquery-number/jquery.number.min.js"></script>'
                . '<script src="biblioteca/assets/vendor/bootstrap/bootstrap.js"></script>'
                . '<script src="biblioteca/assets/vendor/animsition/jquery.animsition.js"></script>'
                . '<script src="biblioteca/assets/vendor/asscroll/jquery-asScroll.js"></script>'
                . '<script src="biblioteca/assets/vendor/mousewheel/jquery.mousewheel.js"></script>'
                . '<script src="biblioteca/assets/vendor/asscrollable/jquery.asScrollable.all.js"></script>'
                . '<script src="biblioteca/assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>'
                . '<!-- Plugins -->'
                . '<script src="biblioteca/assets/vendor/switchery/switchery.min.js"></script>'
                . '<script src="biblioteca/assets/vendor/intro-js/intro.js"></script>'
                . '<script src="biblioteca/assets/vendor/screenfull/screenfull.js"></script>'
                . '<script src="biblioteca/assets/vendor/slidepanel/jquery-slidePanel.js"></script> '
                . '<script src="biblioteca/assets/vendor/bootstrap-sweetalert/sweet-alert.js"></script>'
                . '<!-- Scripts -->'
                . '<script src="biblioteca/assets/js/core.js"></script>'
                . '<script src="biblioteca/assets/js/site.js"></script>'
                . '<script src="biblioteca/assets/js/sections/menu.js"></script>'
                . '<script src="biblioteca/assets/js/sections/menubar.js"></script>'
                . '<script src="biblioteca/assets/js/sections/gridmenu.js"></script>'
                . '<script src="biblioteca/assets/js/sections/sidebar.js"></script>'
                . '<script src="biblioteca/assets/js/configs/config-colors.js"></script>'
                . '<script src="biblioteca/assets/js/configs/config-tour.js"></script>'
                . '<script src="biblioteca/assets/js/components/asscrollable.js"></script>'
                . '<script src="biblioteca/assets/js/components/animsition.js"></script>'
                . '<script src="biblioteca/assets/js/components/slidepanel.js"></script>'
                . '<script src="biblioteca/assets/js/components/switchery.js"></script>'
                . '<script src="biblioteca/assets/vendor/matchheight/jquery.matchHeight-min.js"></script>'
                . '<script src="biblioteca/assets/js/plugins/responsive-tabs.js"></script>'
                . '<script src="biblioteca/assets/js/plugins/closeable-tabs.js"></script>'
                . '<script src="biblioteca/assets/js/components/tabs.js"></script>'
                . '<script src="resources/js/funcoes.js?' . time() . '"></script>'
                . '<script src="resources/js/ajax.js"></script>'
                . '<!-- Datepicker-->'
                . '<script src="biblioteca/assets/js/moment.js" type="text/javascript"></script>'
                . '<script src="biblioteca/assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>'
                . '<script src="biblioteca/assets/js/locales/bootstrap-datepicker.pt-BR.min.js" type="text/javascript"></script>'
                . '<script src="biblioteca/assets/js/jquery.maskedinput.js" type="text/javascript"></script>'
                . '<!--Taginput-->'
                . '<script src="biblioteca/tagsinput/src/jquery.tagsinput.js"></script>'
                . '<!-- Select2 -->'
                . '<script src="biblioteca/assets/js/select2.min.js" type="text/javascript"></script>'
                . '<!-- Mascara de dinheiro -->'
                . '<script src="biblioteca/assets/js/jquery.maskMoney.js" type="text/javascript"></script>'
                . '<!-- Toastr -->'
                . '<script src="biblioteca/assets/vendor/toastr/toastr.js"></script> '
                . '<!-- Plugins For This Page -->'
                . '<link rel="stylesheet" href="biblioteca/assets/vendor/formvalidation/formValidation.css">'
                . '<script>'
                . ' (function(document, window, $) {'
                . ' "use strict";'
                . ' var Site = window.Site;'
                . ' $(document).ready(function() {'
                . ' Site.run();'
                . ' toastr["success"]("SISTEMA ON LINE", "PRONTO!");'
                . ' });'
                . ' })(document, window, jQuery);'
                . ' var menuRecolhido = false;'
                . ' $("#toggleMenubar").click(function(){'
                . ' if(!menuRecolhido){'
                . ' $("#logo").attr("src","biblioteca/assets/images/m.png");'
                . ' menuRecolhido = true;'
                . ' }else{'
                . ' $("#logo").attr("src","biblioteca/assets/images/logo.png");'
                . ' menuRecolhido = false;'
                . ' }'
                . ' });'
                . ' function carregapesq(){'
                . ' if (classeBusca !== undefined && classeBusca != ""){'
                . ' var cont = $("#carregapesq").val().length; '
                . ' if (cont > 4 ){ '
                . ' console.log(controleRequest);'
                . ' requestAjax("",classeBusca,metodoBusca,campoRetId+","+idbusca+","+campoBusca+","+campoValor+","+$("#carregapesq").val());'
                . ' controleRequest ="request";'
                //.' controleRequest ="n";'&& controleRequest === "s"
                //. ' console.log(controleRequest);'
                . ' }'
                . ' }'
                . ' };'
                . '</script>'
                . '</body>'
                . '<script>'
                . $this->MontaTab()
                . '</script>'
                . '<script> '
                . '$(document).ready(function() { '
                . 'document.body.style.zoom = "89%";  '
                . '}); '
                . '</script> '
                . '</html>';

        return $sTela;
    }

    /*
     * Método que retorna a string do menu inicial 
     * respeitando os modulos liberado para o usuário 
     * e os módulo inicial
     */

    public function menuSistema() {
        $oMod = Fabrica::FabricarController('ModUsuario');
        $aModulo = $oMod->modSistema(true, NULL);
        $oMenu = Fabrica::FabricarController('Menu');
        $aMenu = $oMenu->getMenu($aModulo[1]);
        $sEstruturaMenu = '<li class="site-menu-category">' . $aModulo[0] . '</li>';
        $oItemMenu = Fabrica::FabricarController('ItemMenu');

        $iCont = 1;
        foreach ($aMenu as $key => $aMenuSup) {
            $sEstruturaMenu .= '<li class="site-menu-item has-sub">'
                    . '<a href="javascript:void(0)" data-slug="layout">'
                    . '<i class="site-menu-icon wb-layout" aria-hidden="true"></i>'
                    . '<span class="site-menu-title">' . $aMenuSup[0] . '</span>'
                    . '<span class="site-menu-arrow"></span>'
                    . '</a>'
                    . '<ul class="site-menu-sub"> ';
            $aSub = $oItemMenu->getItemMenu($aModulo[1], $aMenuSup[1]);
            $iContSub = 1;
            $iMenuId = '';
            if (!empty($aSub)) {
                foreach ($aSub as $key => $aSupItem) {
                    $iMenuId = $iCont . '-' . $iContSub;
                    $sEstruturaMenu .= '<li class="site-menu-item" id="menu-' . $iMenuId . '"> '
                            . '<a href="#" data-slug="layout-menu-collapsed" title="Abre a tela ' . $aSupItem[0] . '" onclick="verificaTab(\'menu-' . $iMenuId . '\',\'' . $iMenuId . '\',\'' . $aSupItem[1] . '\',\'' . $aSupItem[2] . '\',\'tabmenu-' . $iMenuId . '\'); ">' //requestAjax(\''.$iMenuId.'\',\''.$aSupItem[1].'\',\''.$aSupItem[2].'\',\'tabmenu-'.$iMenuId.'\');
                            . '<i class="site-menu-icon icon fa-star-o " title="Adiciona a Favoritos!" aria-hidden="true" onclick="requestAjax(\'menu-' . $iMenuId . '\',\'FavMenu\',\'msgInsFav\',\'' . utf8_encode($aSupItem[0]) . ',' . utf8_encode($aSupItem[1]) . ',' . utf8_encode($aSupItem[2]) . '\');";></i>'
                            . '<span class="site-menu-title"> ' . $aSupItem[0] . '</span>'
                            . '</a>'
                            . '</li>';
                    ++$iContSub;
                }
            }
            $sEstruturaMenu .= '</ul></li> '; //wb-check-mini
            ++$iCont;
        }
        return $sEstruturaMenu;
    }

    /*
     * Método para montar o jquery para a montagem das abas do sistema
     * 
     */

    public function MontaTab() {


        $sTab = "function verificaTab(id, iMenuId, SupItem1, SupItem2, tab, tela,parametros){"
                //."alert(parametros);"
                . "var addnewtab='s'; "
                . "if(typeof tela == 'undefined'){tela = ''} "
                . " var tabname = 'tab'+id;"
                . " $('#perfilPrincipal').hide();"
                . "$('#tabmenusuperior > li').each(function(){"
                . " if(tabname == $(this).attr('id')){ "
                . " addnewtab='n';"
                . " } "
                . " }); "
                . "if(addnewtab=='s'){ "
                . " newTab(id,tela);"
                . "requestAjax(iMenuId, SupItem1, SupItem2, tab,parametros);"
                . "}"
                . " else{ "
                . "ativaTab(tabname); "
                . "}"
                . "}"
                . "function newTab(id,nomeTela){ var titulo=''; "
                . "titulo = $('#'+id+' span').text()+nomeTela; "
                . "titulo2 = $('#'+id+' > a').text()+nomeTela; "
                // ."alert(id);"
                // ."alert(titulo2);"
                . "if(titulo==''){"
                // ."alert('entrou');"
                . "titulo=titulo2;};"
                . "var tabmenu = 'tab'+id;"
                . "controleAbas(tabmenu);"
                . "$('#tabmenusuperior > li').removeClass(\"active\");"
                . "$('#tabmenucont > div').removeClass(\"active\");"
                . "$('#tabmenusuperior').append('<li class=\"active\" role=\"presentation\" id='+tabmenu+' onclick=\"controleAbas(\''+tabmenu+'\')\" > '+ "
                . "'<a data-toggle=\"tab\" href=\"#'+tabmenu+'control\" aria-controls=\"'+tabmenu+'control\" '+"
                . "'role=\"tab\"> '+"
                . "'<span class=\"close\" data-close=\"tab\" aria-label=\"Close\"> '+"
                . "'<strong title=\"FECHAR\" onclick=\"ativaPerfil()\">×</strong> '+"
                . "'</span> '+"
                . "' '+titulo+' '+"
                . "' </a> '+"
                . "' </li>');"
                . "$('#tabmenucont').append( '<div class=\"tab-pane active\" id=\"'+tabmenu+'control\" role=\"tabpanel\"> '+"
                . " '<div class=\"carregando\" id=\"'+tabmenu+'control-carregando\"></div> '+ "
                . " ' '+ "
                . " '</div>'"
                . ");"
                . "};"
                //. "function FechaCarregando(tabId) {"
                //. "var abaAtiva = $('#'+ tabID +'-carregando');"
                //. "var abaAtiva = $('.carregando');"
                //. "alert('Fecha:'+ tabId+ '-carregando');"
                //. "abaAtiva.hide();"
                . "function ativaTab(tabname){"
                . "$('#tabmenusuperior > li').removeClass(\"active\");"
                . "$('#tabmenucont > div').removeClass(\"active\");"
                . "$('#tabmenusuperior > #'+tabname).addClass(\"active\");"
                . "$('#tabmenucont > #'+tabname+'control').addClass(\"active\");"
                . "}"
                . "function controleAbas(tabId){"
                . "abaSelecionada = tabId;"
                . "}"
                . "function ativaPerfil(){"
                //. "alert('Ativou');"
                . "var countTabs=0;"
                . "$('#tabmenusuperior > li').each(function(){"
                //. "alert('Entrou each');"
                . "countTabs++;"
                //. "alert(countTabs);"
                . "});"
                . "if (countTabs > 1) {"
                . "abaSelecionada = tabId;"
                . "}"
                . " if(countTabs == 1){"
                . "showPerfil();"
                . "} "
                . "}"
                . "function showPerfil(){"
                //. "alert('chegou no show perfil');"
                . "$('#perfilPrincipal').show();"
                . "}";

        /*
         * '$("#' . $sIdTela . 'consulta tbody .selected").each(function(){'
          . 'contChave[contP]=$(this).find(".chave").html();'
          . 'contP++;'
          . '});';
         */


        return $sTab;
    }

    /*
     * Método que retorna os módulos no sistema
     * para a tela inicial
     */

    public function montaModulo() {
        $oModuloUsuario = Fabrica::FabricarController('ModUsuario');
        $aModulos = $oModuloUsuario->modSistema(false, null);
        foreach ($aModulos as $value) {
            $sModulos .= '<a class="list-group-item blue-grey-500" href="javascript:void(0)" onclick="requestAjax(\'\',\'Menu\',\'recarregaMenu\',\'' . $value[1] . '\')">'
                    . '<i class="icon fa-stack-overflow" aria-hidden="true"></i> ' . $value[0] . ''
                    . '</a> ';
        }
        return $sModulos;
    }

    /**
     * Monta mensagem inicial do sistema
     */
    public function montMsgInicial() {
        $sMsg = '<div class="example-wrap" id="perfilPrincipal">'
                . '<div class="example example-well">'
                . '<div class="page-header text-center">'
                . '<h1 class="page-title">Bem-vindo, ' . $_SESSION["nome"] . '!</h1>'
                . '<p class="page-description"><a target="_blank" href="https://www.metalbo.com.br">www.metalbo.com.br</a></br>'
                . '<a target="_blank" href="https://facebook.com/metalbo.oficial"> '
                . '<button type="button" class="btn btn-labeled btn-xs social-facebook">'
                . '<span class="btn-label"><i class="icon bd-facebook" aria-hidden="true"></i></span>Facebook</button>'
                . '</a>'
                . '</br>'
                . '</br>'
                . '<a target="_blank" href="https://www.youtube.com/channel/UCO6rJtl4ePqsWRTztRFkE5w">'
                . '<button type="button" class="btn btn-labeled btn-xs social-youtube">'
                . '<span class="btn-label"><i class="icon bd-youtube" aria-hidden="true"></i></span>Treinamentos</button>'
                . '</a>'
                . '</br>'
                . '</br><img class="img-circle img-bordered img-bordered-primary" width="150" height="150" src="Uploads/' . $_SESSION["usuimagem"] . '" id="img-perfil1"></p>'
                . '</div>'
                . '</div>'
                . '</div>';
        return $sMsg;
    }

    /**
     * Traz o menus favoritos do sistema
     */
    public function favMenu() {
        $oFavMenu = Fabrica::FabricarController('FavMenu');
        $sString = $oFavMenu->getFavMenu(false);
        return $sString;
    }

}

?>