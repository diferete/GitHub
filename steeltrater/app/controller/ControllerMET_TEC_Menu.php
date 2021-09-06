<?php

/**
 * Classe que controla as operações do objeto Menu
 * 
 * @author Fernando Salla
 * @since 28/06/2012
 */
class ControllerMET_TEC_Menu extends Controller {

    function __construct() {
        $this->carregaClassesMvc('MET_TEC_Menu');
        $this->setControllerDetalhe('MET_TEC_ItemMenu');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    /*
     * Método que retorna um array com os menus do sistema
     */

    public function getMenu($sModulo) {
        return $this->Persistencia->getMenuModulo($sModulo);
    }

    /*
     * Método que retorna um array com os menus do sistema
     */

    public function getMenuApp($sModulo) {
        return $this->Persistencia->getMenuModuloApp($sModulo);
    }

    /*
     * Método que recarrega o menu do sistema para o menu do módulo selecionado
     */

    public function recarregaMenu($sModulo) {
        $oMod = Fabrica::FabricarController('MET_TEC_ModUsuario');
        $aModulo = $oMod->modSistema(false, $sModulo);
        $aModuloSel = $aModulo[0];
        $aMenu = $this->getMenu($aModuloSel[1]);
        $sEstruturaMenu = '<li class="site-menu-category">' . $aModuloSel[0] . '</li>';
        $oItemMenu = Fabrica::FabricarController('MET_TEC_ItemMenu');
        $iCont = 1;
        foreach ($aMenu as $key => $aMenuSup) {
            $sEstruturaMenu .= '<li class="site-menu-item has-sub">'
                    . '<a href="javascript:void(0)" data-slug="layout">'
                    . '<i style="color:green" class="site-menu-icon wb-list" aria-hidden="true"></i>'
                    . '<span class="site-menu-title">' . $aMenuSup[0] . '</span>'
                    . '<span class="site-menu-arrow"></span>'
                    . '</a>'
                    . '<ul class="site-menu-sub"> ';
            $aSub = $oItemMenu->getItemMenu($aModuloSel[1], $aMenuSup[1]);
            $iContSub = 1;
            $iMenuId = '';
            if (!empty($aSub)) {
                foreach ($aSub as $key => $aSupItem) {
                    $iMenuId = $iCont . '-' . $iContSub;
                    $sEstruturaMenu .= '<li class="site-menu-item" id="menu-' . $iMenuId . '"> '
                            . '  <a href="#" data-slug="layout-menu-collapsed" title="Abre a tela ' . $aSupItem[0] . '" onclick="verificaTab(\\\'menu-' . $iMenuId . '\\\',\\\'' . $iMenuId . '\\\',\\\'' . $aSupItem[1] . '\\\',\\\'' . $aSupItem[2] . '\\\',\\\'tabmenu-' . $iMenuId . '\\\');">'
                            . '     <i style="color:gold;" class="site-menu-icon  icon fa-star" title="Adiciona a Favoritos!" aria-hidden="true" onclick="requestAjax(\\\'menu-' . $iMenuId . '\\\',\\\'MET_TEC_FavMenu\\\',\\\'msgInsFav\\\',\\\'' . utf8_encode($aSupItem[0]) . ',' . utf8_encode($aSupItem[1]) . ',' . utf8_encode($aSupItem[2]) . '\\\');";></i>'
                            . '      <span class="site-menu-title">' . $aSupItem[0] . '</span>'
                            . '    </a>'
                            . '  </li>';
                    ++$iContSub;
                }
            }
            $sEstruturaMenu .= '</ul></li> ';
            ++$iCont;
        }
        $sMsg = '<div class="example-wrap" id="perfilPrincipal">'
                . '<div>'
                . '<div class = "example-well col-md-12" style = "height:700px" id = "telaInicialLogin">'
                . '<div class = "page-aside">'
                . '<div class = "page-aside-switch">'
                . '<i class = "icon wb-chevron-left" aria-hidden = "true"></i>'
                . '<i class = "icon wb-chevron-right" aria-hidden = "true"></i>'
                . '</div>'
                . '<div class = "page-aside-inner">'
                . '<section class = "page-aside-section">'
                . '<h5 class = "page-aside-title">Minhas empresas</h5>'
                . '<div class = "list-group">';
        $sMsg = $sMsg . $this->getEmpresasAdicionais();
        $sMsg = $sMsg . '</div>'
                . '</section>'
                . '<section class = "page-aside-section">'
                . '<h5 class = "page-aside-title">Rotinas</h5>'
                . '<div class = "list-group">';
        $sMsg = $sMsg . $this->getRotinasAdicionais();
        $sMsg = $sMsg . '</div>'
                . '</section>'
                . '<section class = "page-aside-section">'
                . '<h5 class = "page-aside-title">Informativo</h5>'
                . '<div class = "list-group">';
        $sMsg = $sMsg . $this->getInformativos();
        $sMsg = $sMsg . '</div>'
                . '</section>'
                . '<script>'
                . '$(document).ready(function () {'
                . '$.getJSON("https://economia.awesomeapi.com.br/last/USD-BRL", function (dataDolar) {'
                . '$("#informativo-Dolar2").append("US$ 1 = R$ " + numeroParaMoeda(dataDolar.USDBRL.bid));'
                . '});}, 30000);'
                . '</script>'
                . '</div>'
                . '</div>'
                . '<div id="icoAtualiza2">'
                . '<h4 style="text-align-last:end;margin-top:10px;margin-left:5px;cursor:pointer;" title="Atualizações">'
                . '<i class = "icon wb-list" aria-hidden = "true" ></i>'
                /* . 'Atualizações ' */
                . '</h4>'
                . '</div>'
                . '<div class = "page-header text-center">'
                . '</br>'
                /* . '<h1 class = "page-title">Bem vindo, '. $_SESSION["nome"] .'</h1>' */
                . '<img class = "img-circle" width = "150" height = "150" src = "Uploads/' . $_SESSION["usuimagem"] . '" id = "img-perfil1">'
                /* . '<h2 class = "page-title">' . $_SESSION["nome"] . '</h2>' */
                . '<h1 class = "page-title">Bem-vindo, ' . $_SESSION["nome"] . '</h1>'
                . '<div>'
                . '</div>'
                . '</br>'
                /* . '<div>'
                  . '<p class = "page-description">'
                  . '<a target = "_blank" href = "http://metalbo.com.br/steeltrater" style = "margin: 10px;text-decoration: none;"> '
                  . '<button type = "button" style = "color: purple;border: none;background: transparent;">'
                  . '<span>'
                  . '<i aria-hidden = "true"></i>'
                  . '</span> steeltrater.com.br'
                  . '</button>'
                  . '</a>'
                  . '<a target = "_blank" href = "http://177.84.0.34:8080/DelsoftXPRO/servlet/loginerp"" style="margin: 10px;text-decoration: none;">'
                  . '<button type="button" style="color: red;border: none;background: transparent;">'
                  . '<span>'
                  . '<i aria-hidden="true"></i>'
                  . '</span> DelsoftX'
                  . '</button>'
                  . '</a>'
                  . '</div>' */
                . '</br>'
                . '</div>'
                . '</div>'
                . $this->montaTabela()
                . '<script>'
                . '$("#icoAtualiza2").click(function(){'
                . 'if ($("#tabelaAtualizacoes").is(":visible")) {'
                . '$("#tabelaAtualizacoes").hide();'
                . '} else {'
                . '$("#tabelaAtualizacoes").toggle("show");'
                . '}'
                . 'if ($("#icoAtualiza").is(":visible")) {'
                . '$("#icoAtualiza").hide();'
                . '} else {'
                . ' $("#icoAtualiza").toggle("show");'
                . '}'
                . 'if ($("#icoAtualiza2").is(":visible")) {'
                . '$("#icoAtualiza2").hide();'
                . '} else {'
                . ' $("#icoAtualiza2").toggle("show");'
                . '}'
                . '$("#telaInicialLogin").toggleClass("col-md-8","col-md-12");'
                . '});'
                . '$("#icoAtualiza").click(function(){'
                . 'if ($("#tabelaAtualizacoes").is(":visible")) {'
                . '$("#tabelaAtualizacoes").hide();'
                . '} else {'
                . '$("#tabelaAtualizacoes").toggle("show");'
                . '}'
                . 'if ($("#icoAtualiza").is(":visible")) {'
                . '$("#icoAtualiza").hide();'
                . '} else {'
                . ' $("#icoAtualiza").toggle("show");'
                . '}'
                . 'if ($("#icoAtualiza2").is(":visible")) {'
                . '$("#icoAtualiza2").hide();'
                . '} else {'
                . ' $("#icoAtualiza2").toggle("show");'
                . '}'
                . '$("#telaInicialLogin").toggleClass("col-md-8","col-md-12");'
                . '});'
                . '$("#8993358000174-empresa").click(function(){'
                . '$("#logo").attr("src","biblioteca/assets/images/logoS.png");'
                . '$("#logo").attr("title","Steeltrater").removeClass("logo_poliamidos").addClass("logo_empresas");'
                . '});'
                . '$("#83781641000158-empresa").click(function(){'
                . '$("#logo").attr("src","biblioteca/assets/images/logoP.png");'
                . '$("#logo").attr("title","Poliamidos").removeClass("logo_poliamidos").removeClass("logo_empresas").addClass("logo_poliamidos");'
                . '});'
                . '$("#75483040000130-empresa").click(function(){'
                . '$("#logo").attr("src","biblioteca/assets/images/logoM.png");'
                . '$("#logo").attr("title","Metalbo").removeClass("logo_poliamidos").addClass("logo_empresas");'
                . '});'
                . '$("#75483040000211-empresa").click(function(){'
                . '$("#logo").attr("src","biblioteca/assets/images/logoM.png");'
                . '$("#logo").attr("title","Metalbo").removeClass("logo_poliamidos").addClass("logo_empresas");'
                . '});'
                . '</script>'
                . '</div>'
                . '</div>';
        echo "$('#tabmenucont').empty(); $('#tabmenusuperior').empty();$('#menu').empty();$('#menu').append('" . $sEstruturaMenu . "'); ";
        echo "$('#tabmenucont').append('" . $sMsg . "');";
    }

    /**
     * adiciona filtros extras
     */
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('modcod', $this->Model->getMET_TEC_Modulo()->getModcod());
        $this->Persistencia->adicionaFiltro('mencodigo', $this->Model->getMencodigo());
    }

    /**
     * monta os campos para a próxima etapa
     */
    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getMencodigo();
        $aRetorno[1] = $this->Model->getMET_TEC_Modulo()->getModcod();
        return $aRetorno;
    }

    public function montaTabela() {
        $oControllerUpdates = Fabrica::FabricarController('MET_TEC_Updates');
        $aBuscaUpdates = $oControllerUpdates->getDadosUpdates();

        $html = '<h4 id="icoAtualiza" style = "text-align: center;margin-top: 0px;margin-left: 5px;cursor: pointer;display: none;">'
                . '<i class = "icon wb-list" aria-hidden = "true" ></i> Atualizações'
                . '</h4> '
                . '<div class = "col-md-4" style="display:none;" id = "tabelaAtualizacoes">'
                . '<div class = "table-responsive" style = "margin-left:5px;"> '
                . '<table class = "table table-striped"> '
                . '<thead> '
                . '<tr> '
                . '<th style = "font-size:16px;font-weight:600;">Versão</th> '
                . '<th style = "font-size:16px;font-weight:600;">Updates</th> '
                . '<th style = "font-size:16px;font-weight:600;">Doc.</th> '
                . '</tr> '
                . '</thead> '
                . '<tbody> ';
        foreach ($aBuscaUpdates as $key => $value) {
            $href = '';
            $html = $html . ' <tr> '
                    . ' <td><span class = "badge badge-dark">' . $value->versao . '</span></td> '
                    . ' <td style = "width:450px">' . $value->updates . '</td> ';
            if ($value->anexo != '') {
                $html = $html . ' <td><a href = "http://localhost/github/steeltrater/uploads/' . $value->anexo . '" target = "_blank" rel = ”noopener”>Clique aqui</a></td> ';
            } else {
                $html = $html . ' <td></td> ';
            }
            $html = $html . ' </tr> ';
        }
        $html = $html . ' </tbody>'
                . '</table>'
                . '</div>';

        return $html;
    }

    public function getEmpresasAdicionais() {

        $html = $this->getEmpresaPadrao();

        $oPersistenciaUsuario = Fabrica::FabricarPersistencia('MET_TEC_Usuario');
        $aBuscaEmpresas = $oPersistenciaUsuario->getEmpresasAdicionais();
        foreach ($aBuscaEmpresas as $key => $aValue) {
            $sClasse = str_replace(' ', '_', $aValue[0]);
            $html = $html . '<a id="' . $aValue[1] . '-empresa" class = "list-group-item ' . $sClasse . '-empresa" href = "javascript:void(0)"><i class = "icon fa-building" aria-hidden = "true"></i>' . $aValue[0] . '</a>';
        }
        return $html;
    }

    function getEmpresaPadrao() {
        $sEmpresa = $_SESSION['filcgc'];

        /* 5572480000189 FECIAL
          8993358000174 STEELTRATER
          10540966000175 FECULARIA BOEWING
          75483040000130 METALBO MATRIZ
          75483040000211 METALBO FILIAL
          83781641000158 HEDLER */

        $html = '';

        switch ($sEmpresa) {
            case 8993358000174:
                $html = '<a id="8993358000174-empresa" class = "list-group-item Steeltrater-empresa" href = "javascript:void(0)"><i class = "icon fa-building" aria-hidden = "true"></i>Steeltrater</a>';

                break;
            case 75483040000130:
                $html = '<a id="75483040000130-empresa" style="color:#0f5539" class = "list-group-item Metalbo_Matriz-empresa" href = "javascript:void(0)"><i class = "icon fa-building" aria-hidden = "true"></i>Metalbo Matriz</a>';

                break;
            case 75483040000211:
                $html = '<a id="75483040000211-empresa" style="color:#0f5539" class = "list-group-item Metalbo_Filial-empresa" href = "javascript:void(0)"><i class = "icon fa-building" aria-hidden = "true"></i>Metalbo Filial</a>';

                break;
            case 83781641000158:
                $html = '<a id="83781641000158-empresa" style="color:blue" class = "list-group-item Poliamidos-empresa" href = "javascript:void(0)"><i class = "icon fa-building" aria-hidden = "true"></i>Poliamidos</a>';

                break;
        }

        return $html;
    }

    public function getRotinasAdicionais() {

        $oMET_TEC_ItemMenu = Fabrica::FabricarPersistencia('MET_TEC_ItemMenu');
        $aClasses = $oMET_TEC_ItemMenu->getRotinasAdicionais();

        $html = '';
        $iCont = 1;

        foreach ($aClasses as $key => $aValue) {
            $sMenuId = $iCont . '-' . $aValue[0] . '-rotinas';
            $html = $html . '<a class = "list-group-item" href = "javascript:void(0)" title="Abre a tela ' . $aValue[1] . '"'
                    . 'onclick="verificaTab(\\\'menu-' . $sMenuId . '\\\',\\\'' . $sMenuId . '\\\',\\\'' . $aValue[2] . '\\\',\\\'' . $aValue[3] . '\\\',\\\'tabmenu-' . $sMenuId . '\\\',\\\'' . $aValue[1] . '\\\'); "role="menuitem">'
                    . '<i class = "icon wb-order" aria-hidden = "true"></i>' . $aValue[1] . '';
            switch ($aValue[5]) {
                case 41:
                    $oMET_TEC_ItemMenu = Fabrica::FabricarPersistencia('MET_TEC_ItemMenu');
                    $iCont = $oMET_TEC_ItemMenu->getRotinasAdicionaisContadores($aValue);
                    if ($iCont > 0) {
                        $html = $html . '<span class="badge badge-success up" style="top:0px !important">' . $iCont . '</span>';
                    }
                    break;
            }
            $html = $html . '</a>';

            $iCont++;
        }
        return $html;
    }

    public function getInformativos() {
        //$html = '<a id="informativo-Dolar" class = "list-group-item Steeltrater-empresa" href = "javascript:void(0)"><i class = "icon fa-building" aria-hidden = "true"></i></a>';

        $html = '<span id="informativo-Dolar2" class = "list-group-item Steeltrater-empresa" href = "javascript:void(0)"><i class = "icon fa-line-chart" aria-hidden = "true"></i></span>';

        return $html;
    }

}

?>