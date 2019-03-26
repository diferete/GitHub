<?php

class ViewCurriculo extends View {

    public function criaTela() {
        parent::criaTela();

        $oNr = new campo('', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBOculto(true);

        $oNome = new Campo('Nome Completo', 'nome', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oNatural = new Campo('Naturalidade', 'natural', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNacional = new Campo('Nacionalidade', 'nacional', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNasc = new Campo('Nascimento', 'nasc', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oNasc->setSValor(Util::getDataAtual());
        $oNasc->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oSexo = new Campo('Sexo', 'sexo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSexo->addItemSelect('masculino', 'Masculino');
        $oSexo->addItemSelect('feminino', 'Feminino');

        $oAltura = new Campo('Altura em Cm', 'altura', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPeso = new Campo('Peso', 'peso', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oEstCiv = new Campo('Estado Civil', 'estciv', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oEstCiv->addItemSelect('solteiro', 'Solteiro(a)');
        $oEstCiv->addItemSelect('casado', 'Casado(a)');
        $oEstCiv->addItemSelect('divorciado', 'Divorciado(a)');
        $oEstCiv->addItemSelect('viuvo', 'Viuvo(a)');
        $oEstCiv->addItemSelect('separado', 'Separado(a)');
        $oEstCiv->addItemSelect('outro', 'Outro');

        $oConjuge = new Campo('Conjuge', 'conjuge', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oNascConj = new Campo('Nascimento do Conjuge', 'nascconj', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oNasc->setSValor(Util::getDataAtual());
        $oNasc->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oNrFilhos = new Campo('Nrº de Filhos', 'nrfilhos', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNrFilhosMenor = new Campo('Menores de 14', 'menor', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oContato = new Campo('Fone para contato', 'contato', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmail = new Campo('Email', 'email', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRua = new Campo('Rua', 'rua', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNumero = new Campo('Número', 'numero', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oBairro = new Campo('Bairro', 'bairro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCep = new Campo('Cep', 'cep', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCidade = new Campo('Cidade', 'cidade', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEstado = new Campo('Estado', 'estado', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oEstado->addItemSelect('AC', 'ACRE');
        $oEstado->addItemSelect('AL', 'ALAGOAS');
        $oEstado->addItemSelect('AP', 'AMAPA');
        $oEstado->addItemSelect('AM', 'AMAZONAS');
        $oEstado->addItemSelect('BA', 'BAHIA');
        $oEstado->addItemSelect('CE', 'CEARA');
        $oEstado->addItemSelect('DF', 'DISTRITO FEDERAL');
        $oEstado->addItemSelect('ES', 'ESPIRITO SANTO');
        $oEstado->addItemSelect('GO', 'GOIAS');
        $oEstado->addItemSelect('MA', 'MARANHAO');
        $oEstado->addItemSelect('MT', 'MATO GROSSO');
        $oEstado->addItemSelect('MS', 'MATO GROSSO DO SUL');
        $oEstado->addItemSelect('MG', 'MINAS GERAIS');
        $oEstado->addItemSelect('PA', 'PARA');
        $oEstado->addItemSelect('PB', 'PARAIBA');
        $oEstado->addItemSelect('PR', 'PARANA');
        $oEstado->addItemSelect('PE', 'PERNAMBUCO');
        $oEstado->addItemSelect('PI', 'PIAUI');
        $oEstado->addItemSelect('RJ', 'RIO DE JANEIRO');
        $oEstado->addItemSelect('RN', 'RIO GRANDE DO NORTE');
        $oEstado->addItemSelect('RS', 'RIO GRANDE DO SUL');
        $oEstado->addItemSelect('RO', 'RONDONIA');
        $oEstado->addItemSelect('RR', 'RORAIMA');
        $oEstado->addItemSelect('SC', 'SANTA CATARINA');
        $oEstado->addItemSelect('SP', 'SAO PAULO');
        $oEstado->addItemSelect('SE', 'SERGIPE');
        $oEstado->addItemSelect('TO', 'TOCANTINS');

        $oMoraTempo = new Campo('Tempo de morada', 'moratempo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oNomePai = new Campo('Nome do Pai', 'nomepai', Campo::TIPO_TEXTO, 4, 2, 12, 12);

        $oNomeMae = new Campo('Nome da Mãe', 'nomemae', Campo::TIPO_TEXTO, 4, 2, 12, 12);

        $oFacebook = new Campo('Perfil do Facebook *caso tenha', 'facebook', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oNrRG = new Campo('Nº do RG', 'nrident', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCPF = new Campo('Nº do CPF', 'cpf', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oTitEleit = new Campo('Nrº do Titulo de Eleitor', 'titeleit', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oNrCTPS = new Campo('Nº da Carteira de Trabalho', 'nrctps', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oNrSerieCTPS = new Campo('Nº Série da Carteira de Trabalho', 'nrseriectps', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oNrPis = new Campo('Nº do PIS', 'nrpis', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEscolaridade = new Campo('Escolaridade', 'escolaridade', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oEscolaridade->addItemSelect('01', 'Primário - Incompleto');
        $oEscolaridade->addItemSelect('02', 'Primário - Completo');
        $oEscolaridade->addItemSelect('03', 'Fundamental - Incompleto');
        $oEscolaridade->addItemSelect('04', 'Fundamental - Completo');
        $oEscolaridade->addItemSelect('05', 'Médio - Incompleto');
        $oEscolaridade->addItemSelect('06', 'Médio - Completo');
        $oEscolaridade->addItemSelect('07', 'Superior - Incompleto');
        $oEscolaridade->addItemSelect('08', 'Superior - Completo');
        $oEscolaridade->addItemSelect('09', 'Pós-graduação - Incompleto');
        $oEscolaridade->addItemSelect('10', 'Pós-graduação - Completo');
        $oEscolaridade->addItemSelect('11', 'Doutorado - Incompleto');
        $oEscolaridade->addItemSelect('12', 'Doutorado - Completo');

        $oSerie = new Campo('Série', 'serie', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oGrau = new Campo('Grau', 'grau', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oCursoSup = new Campo('Curso Superior?', 'cursosup', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCursoSup->addItemSelect('sim','Sim');
        $oCursoSup->addItemSelect('nao', 'Não');

        $oQualSup = new Campo('Se sim, qual?', 'tipocursosup', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCursoProf = new Campo('Curso Profissionalizante?', '', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCursoProf->addItemSelect('sim','Sim');
        $oCursoProf->addItemSelect('nao', 'Não');

        $oQualProf = new Campo('Se sim, qual?', 'tipocursoprof', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEmpresa1 = new Campo('Empresa anterior', 'empresa1', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCargoEmp1 = new Campo('Cargo', 'cargoemp1', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oFoneEmp1 = new Campo('Fone', 'foneemp1', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCidadeEmp1 = new Campo('Cidade', 'cidadeemp1', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oIniciaEmp1 = new Campo('Data da Contratação', 'inicioemp1', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oIniciaEmp1->setSValor(Util::getDataAtual());
        $oIniciaEmp1->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oFimEmp1 = new Campo('Data da Recisão', 'fimemp1', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oFimEmp1->setSValor(Util::getDataAtual());
        $oFimEmp1->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oEmpresa2 = new Campo('Empresa anterior', 'empresa2', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCargoEmp2 = new Campo('Cargo', 'cargoemp2', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oFoneEmp2 = new Campo('Fone', 'foneemp2', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCidadeEmp2 = new Campo('Cidade', 'cidadeemp2', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oIniciaEmp2 = new Campo('Data da Contratação', 'inicioemp2', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oFimEmp2 = new Campo('Data da Recisão', 'fimemp2', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oEmpresa3 = new Campo('Empresa anterior', 'empresa3', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCargoEmp3 = new Campo('Cargo', 'cargoemp3', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oFoneEmp3 = new Campo('Fone', 'foneemp3', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCidadeEmp3 = new Campo('Cidade', 'cidadeemp3', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oIniciaEmp3 = new Campo('Data da Contratação', 'inicioemp3', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oFimEmp3 = new Campo('Data da Recisão', 'fimemp3', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oRefer = new Campo('Referências', 'refer', Campo::TIPO_TEXTAREA, 12, 12, 12, 120);
        $oRefer->setILinhasTextArea(5);


        $this->addCampos($oNr,
                array($oNome, $oNatural, $oNacional, $oNasc, $oSexo), 
                array($oAltura, $oPeso, $oEstCiv, $oConjuge,$oNascConj,$oNrFilhos,$oNrFilhosMenor),
                array($oContato,$oRua,$oBairro,$oCep,$oCidade,$oEstado,$oNumero),
                array($oMoraTempo,$oNomePai,$oNomeMae,$oFacebook),
                array($oNrRG,$oCPF,$oTitEleit,$oNrCTPS,$oNrSerieCTPS,$oNrPis),
                array($oEscolaridade,$oSerie,$oGrau,$oCursoSup,$oQualSup,$oCursoProf,$oQualProf),
                array($oEmpresa1,$oCargoEmp1,$oFoneEmp1,$oCidadeEmp1,$oIniciaEmp1,$oFimEmp1),
                array($oEmpresa2,$oCargoEmp2,$oFoneEmp2,$oCidadeEmp2,$oIniciaEmp2,$oFimEmp2),
                array($oEmpresa3,$oCargoEmp3,$oFoneEmp3,$oCidadeEmp3,$oIniciaEmp3,$oFimEmp3),
                $oRefer);

        }

    /**
     * Monta interface para usuários sem necessidade de login
     */
    public function blankScreen() {
        //monta o form
        $this->criaTela();
        $this->getTela()->setSRender('blankId');
        $this->getTela()->setBTela(true);
        $this->getTela()->setBRetonaRender(true);
        $sForm = $this->getTela()->getRender();

        $sTela = "<!DOCTYPE html>"
                . "<html><!-- class='no-js' lang='en'-->"
                . "<head>"
                . "<meta http-equiv='X-UA-Compatible' content='IE=edge'>"
                . "<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui'>"
                . "<meta name='description' content='bootstrap admin template'>"
                . "<meta name='author' content=''>"
                . "<title>Metalbo | Sistema</title>"
                . "<link rel='shortcut icon' href='biblioteca/assets/images/favicon.ico'>"
                . "<!-- Stylesheets -->"
                . "<link rel='stylesheet' href='biblioteca/assets/css/bootstrap.min.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/css/bootstrap-extend.min.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/css/site.min.css'><!-- ok-->"
                . "  <!-- Estilo personalizado -->"
                . "<link rel='stylesheet' href='biblioteca/assets/css/estilo.css?'>"
                . " <!-- FormValidation -->"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/formvalidation/formValidation.css'>"
                . "<!-- Plugins -->"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/animsition/animsition.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/asscrollable/asScrollable.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/switchery/switchery.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/intro-js/introjs.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/slidepanel/slidePanel.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/flag-icon-css/flag-icon.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/bootstrap-sweetalert/sweet-alert.css'>"
                . "<!-- Datatables -->"
                . "<link rel='stylesheet' type='text/css' href='biblioteca/datatables/media/css/jquery.dataTables.css'>"
                . "<link rel='stylesheet' type='text/css' href='biblioteca/datatables/extensions/Select/css/select.dataTables.min.css'>"
                . "<link rel='stylesheet' type='text/css' href='biblioteca/datatables/extensions/Buttons/css/buttons.dataTables.min.css'>"
                . "<!-- Fonts -->"
                . "<link rel='stylesheet' href='biblioteca/assets/fonts/web-icons/web-icons.min.css'>"
                . "<link rel='stylesheet' href='biblioteca/assets/fonts/brand-icons/brand-icons.min.css'>"
                . "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>"
                . "<link rel='stylesheet' href='biblioteca/assets/fonts/font-awesome/font-awesome.css'>"
                . "<!-- Scripts -->"
                . "<script src='biblioteca/assets/vendor/modernizr/modernizr.js'></script>"
                . "<script src='biblioteca/assets/vendor/breakpoints/breakpoints.js'></script>"
                . "<script src='biblioteca/assets/vendor/jquery/jquery.js'></script>"
                . "<script type='text/javascript'  src='biblioteca/datatables/media/js/jquery.dataTables.js'></script>"
                . "<script type='text/javascript'  src='biblioteca/datatables/extensions/Select/js/dataTables.select.min.js'></script> "
                . "<script type='text/javascript'  src='biblioteca/datatables/extensions/Buttons/js/dataTables.buttons.min.js'></script>"
                . "<!-- Datepicker-->"
                . "<link href='biblioteca/assets/css/bootstrap-datepicker3.min.css' rel='stylesheet' type='text/css'/>"
                . "<!-- Select2 -->"
                . "<link href='biblioteca/assets/css/select2.css' rel='stylesheet' type='text/css'/>"
                . " <!-- File upload -->"
                . "<link href='biblioteca/assets/css/jquery.fileupload.css' rel='stylesheet' type='text/css' />"
                . " <!-- Toastr -->"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/toastr/toastr.css'>"
                . "<!-- FormValidation -->"
                . "<script src='biblioteca/assets/vendor/formvalidation/formValidation.min.js'></script>"
                . "<script src='biblioteca/assets/vendor/formvalidation/framework/bootstrap.min.js'></script>"
                . "<script src='biblioteca/assets/vendor/formvalidation/language/pt_BR.js'></script>"
                . "<!-- FieldSet Collapse -->"
                . "<link href='biblioteca/assets/vendor/jquery-coolfieldset/css/jquery.coolfieldset.css' rel='stylesheet' type='text/css' />"
                . "<script src='biblioteca/assets/vendor/jquery-coolfieldset/js/jquery.coolfieldset.min.js'></script>"
                . "<!-- FileInput -->"
                . "<link href='biblioteca/assets/vendor/bootstrap-fileinput/css/fileinput.css' rel='stylesheet' type='text/css'/>"
                . "<!-- Summernote - Editor de Texto-->"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/summernote/summernote.css'>"
                . "<script src='biblioteca/assets/vendor/summernote/summernote.min.js'></script>"
                . "<script src='biblioteca/assets/vendor/summernote/lang/summernote-pt-BR.js'></script>"
                . "<script>"
                . "Breakpoints();"
                . "</script>"
                . "<style type='text/css'>"
                . "    .fileUpload {"
                . "        position: relative; "
                . "        overflow: hidden; "
                . "        margin: 10px; "
                . "    }"
                . "    .fileUpload input.upload { "
                . "        position: absolute; "
                . "        top: 0; "
                . "        right: 0; "
                . "        margin: 0; "
                . "        padding: 0;"
                . "        font-size: 20px; "
                . "        cursor: pointer; "
                . "        opacity: 0; "
                . "        filter: alpha(opacity=0);"
                . "    }"
                . "</style>"
                . "</head>"
                . "<body class='layout-boxed' >"
                . "<nav class='site-navbar navbar navbar-default navbar-fixed-top navbar-mega' role='navigation'>"
                . "<div class='navbar-header'>"
                . "        <a href='https://metalbo.com.br/'>"
                . "            <img class='navbar-brand-logo' style='margin-top:10px;margin-left:10px;' id='logo' src='biblioteca/assets/images/logo.png' title='Metalbo'>"
                . "        </a>"
                . "    </div>"
                . "    <div class='navbar-container container-fluid'>"
                . "        <!-- Navbar Collapse -->"
                . "        <div class='collapse navbar-collapse navbar-collapse-toolbar' id='site-navbar-collapse'>"
                . "            <!-- Navbar Toolbar -->"
                . "            <ul class='nav navbar-toolbar'>"
                . "                <li class='hidden-xs' id='toggleFullscreen'>"
                . "                </li>"
                . "                <li class='hidden-float'>"
                . "                </li>"
                . "                <li class='dropdown dropdown-fw dropdown-mega'>"
                . "                </li>"
                . "            </ul>"
                . "            <!-- End Navbar Toolbar -->"
                . ""
                . "            <!-- Navbar Toolbar Right -->"
                . "            <ul class='nav navbar-toolbar navbar-right navbar-toolbar-right'>"
                . "                <li class='dropdown'>"
                . "                </li>"
                . "                <li class='dropdown' style='font-weight:700!important;font-size:18px;'>"
                . "                     <a href='https://metalbo.com.br/'>Voltar"
                . "                    </a>"
                . "                </li>"
                . "            </ul>"
                . "            <!-- End Navbar Toolbar Right -->"
                . "        </div>"
                . "        <!-- End Navbar Collapse -->"
                . ""
                . "        <!-- Site Navbar Seach -->"
                . "        <div class='collapse navbar-search-overlap' id='site-navbar-search'>"
                . "            <form role='search'>"
                . "                <div class='form-group'>"
                . "                    <div class='input-search'>"
                . "                        <i class='input-search-icon wb-search' aria-hidden='true'></i>"
                . "                        <input type='text' class='form-control' name='site-search' placeholder='Search...'>"
                . "                        <button type='button' class='input-search-close icon wb-close' data-target='#site-navbar-search'"
                . "                                data-toggle='collapse' aria-label='Close'></button>"
                . "                    </div>"
                . "                </div>"
                . "            </form>"
                . "        </div>"
                . "        <!-- End Site Navbar Seach -->"
                . "    </div>"
                . "</nav>"
                . "<!-- Page -->"
                . "<div class='page'>"
                . "<div class='page-content'>"
                . ""
                . "<div class='panel'> "
                . "    <div class='panel-heading'> "
                . "    </div> "
                . "    <div class='panel-body' style='padding-bottom:25px;'>"
                . $sForm
                . "    </div> "
                . " </div> "
                . " </div> "
                . "</div>"
                . "<!-- End Page -->"
                . "      <!-- File Input-->"
                . "<script src='biblioteca/assets/vendor/bootstrap-fileinput/js/plugins/canvas-to-blob.js' type='text/javascript'></script>"
                . "<script src='biblioteca/assets/vendor/bootstrap-fileinput/js/fileinput.js' type='text/javascript'></script>"
                . "<script src='biblioteca/assets/vendor/bootstrap-fileinput/js/fileinput_locale_pt-BR.js' ></script>"
                . "   <!-- Core  -->"
                . "   <script src='biblioteca/assets/vendor/jquery/jquery.js'></script>"
                . "   <script src='biblioteca/assets/vendor/bootstrap/bootstrap.js'></script>"
                . "   <script src='biblioteca/assets/vendor/animsition/jquery.animsition.js'></script>"
                . "   <script src='biblioteca/assets/vendor/asscroll/jquery-asScroll.js'></script>"
                . "   <script src='biblioteca/assets/vendor/mousewheel/jquery.mousewheel.js'></script>"
                . "   <script src='biblioteca/assets/vendor/asscrollable/jquery.asScrollable.all.js'></script>"
                . "   <script src='biblioteca/assets/vendor/ashoverscroll/jquery-asHoverScroll.js'></script>"
                . "     <!-- Plugins -->"
                . "   <script src='biblioteca/assets/vendor/switchery/switchery.min.js'></script>"
                . "   <script src='biblioteca/assets/vendor/intro-js/intro.js'></script>"
                . "   <script src='biblioteca/assets/vendor/screenfull/screenfull.js'></script>"
                . "   <script src='biblioteca/assets/vendor/slidepanel/jquery-slidePanel.js'></script> "
                . "   <script src='biblioteca/assets/vendor/bootstrap-sweetalert/sweet-alert.js'></script>"
                . "   <!-- Scripts -->"
                . "   <script src='biblioteca/assets/js/core.js'></script>"
                . "   <script src='biblioteca/assets/js/site.js'></script>"
                . "   <script src='biblioteca/assets/js/sections/menu.js'></script>"
                . "   <script src='biblioteca/assets/js/sections/menubar.js'></script>"
                . "   <script src='biblioteca/assets/js/sections/gridmenu.js'></script>"
                . "   <script src='biblioteca/assets/js/sections/sidebar.js'></script>"
                . "   <script src='biblioteca/assets/js/configs/config-colors.js'></script>"
                . "   <script src='biblioteca/assets/js/configs/config-tour.js'></script>"
                . "   <script src='biblioteca/assets/js/components/asscrollable.js'></script>"
                . "   <script src='biblioteca/assets/js/components/animsition.js'></script>"
                . "   <script src='biblioteca/assets/js/components/slidepanel.js'></script>"
                . "   <script src='biblioteca/assets/js/components/switchery.js'></script>"
                . "   <script src='biblioteca/assets/vendor/matchheight/jquery.matchHeight-min.js'></script>"
                . "   <script src='biblioteca/assets/js/plugins/responsive-tabs.js'></script>"
                . "   <script src='biblioteca/assets/js/plugins/closeable-tabs.js'></script>"
                . "   <script src='biblioteca/assets/js/components/tabs.js'></script>"
                . "   <script src='resources/js/funcoes.js?></script>"
                . "   <!-- Plugins For This Page -->"
                . "   <script src='biblioteca/assets/vendor/matchheight/jquery.matchHeight-min.js'></script>"
                . "   <script src='biblioteca/assets/js/plugins/responsive-tabs.js'></script>"
                . "   <script src='biblioteca/assets/js/plugins/closeable-tabs.js'></script>"
                . "   <script src='biblioteca/assets/js/components/tabs.js'></script>"
                . "   <script src='resources/js/ajax.js'></script>"
                . "   <script type='text/javascript' src='biblioteca/assets/js/bootstrap-filestyle-1.2.1/src/bootstrap-filestyle.min.js'></script>"
                . "<!--firestyle-->"
                . "<script>"
                . "    (function (document, window, $) {"
                . "        'use strict';"
                . " "
                . "        var Site = window.Site;"
                . "        $(document).ready(function () {"
                . "            Site.run();"
                . "        });"
                . "    })(document, window, jQuery);"
                . "</script>"
                . "<!-- Datatables-->"
                . "<script type='text/javascript'  src='biblioteca/datatables/media/js/jquery.dataTables.js'></script>"
                . "<script type='text/javascript'  src='biblioteca/datatables/extensions/Select/js/dataTables.select.min.js'></script> "
                . "<script type='text/javascript'  src='biblioteca/datatables/extensions/Buttons/js/dataTables.buttons.min.js'></script> "
                . "   <script src='resources/js/ajax.js'></script>"
                . "       <!-- Datepicker-->"
                . "   <script src='biblioteca/assets/js/moment.js' type='text/javascript'></script>"
                . "   <script src='biblioteca/assets/js/bootstrap-datepicker.min.js' type='text/javascript'></script>"
                . "   <script src='biblioteca/assets/js/locales/bootstrap-datepicker.pt-BR.min.js' type='text/javascript'></script>"
                . "   <script src='biblioteca/assets/js/jquery.maskedinput.js' type='text/javascript'></script>"
                . "<!-- Select2 -->"
                . "<script src='biblioteca/assets/js/select2.min.js' type='text/javascript'></script>"
                . "<!-- Mascara de dinheiro -->"
                . "<script src='biblioteca/assets/js/jquery.maskMoney.js' type='text/javascript'></script>"
                . "<!-- Toastr -->"
                . "<script src='biblioteca/assets/vendor/toastr/toastr.js'></script> "
                . "  <!-- Plugins For This Page -->"
                . "<link rel='stylesheet' href='biblioteca/assets/vendor/formvalidation/formValidation.css'>"
                . "</body>"
                . "</html>";

        return $sTela;
    }

}
