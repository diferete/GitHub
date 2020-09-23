<?php

/**
 * Classe que controla as operações do objeto Menu
 * 
 * @author Fernando Salla
 * @since 28/06/2012
 */
class ControllerMenu extends Controller {

    function __construct() {
        $this->carregaClassesMvc('Menu');
        $this->setControllerDetalhe('ItemMenu');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    /*
     * Método que retorna um array com os menus do sistema
     */

    public function getMenu($sModulo) {
        return $this->Persistencia->getMenuModulo($sModulo);
    }

    /*
     * Método que recarrega o menu do sistema para o menu do módulo selecionado
     */

    public function recarregaMenu($sModulo) {
        $oMod = Fabrica::FabricarController('ModUsuario');
        $aModulo = $oMod->modSistema(false, $sModulo);
        $aModuloSel = $aModulo[0];
        $aMenu = $this->getMenu($aModuloSel[1]);
        $sEstruturaMenu = '<li class="site-menu-category">' . $aModuloSel[0] . '</li>';
        $oItemMenu = Fabrica::FabricarController('ItemMenu');
        $iCont = 1;
        foreach ($aMenu as $key => $aMenuSup) {
            $sEstruturaMenu .= '<li class="site-menu-item has-sub">'
                    . '<a href="javascript:void(0)" data-slug="layout">'
                    . '  <i class="site-menu-icon wb-layout" aria-hidden="true"></i>'
                    . '  <span class="site-menu-title">' . $aMenuSup[0] . '</span>'
                    . '  <span class="site-menu-arrow"></span>'
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
                            . '     <i style="color:gold;" class="site-menu-icon icon wb-star " title="Adiciona a Favoritos!" aria-hidden="true" onclick="requestAjax(\\\'menu-' . $iMenuId . '\\\',\\\'FavMenu\\\',\\\'msgInsFav\\\',\\\'' . utf8_encode($aSupItem[0]) . ',' . utf8_encode($aSupItem[1]) . ',' . utf8_encode($aSupItem[2]) . '\\\');";></i>'
                            . '      <span class="site-menu-title">' . $aSupItem[0] . '</span>'
                            . '    </a>'
                            . '  </li>';
                    ++$iContSub;
                }
            }
            $sEstruturaMenu .= '</ul></li> ';
            ++$iCont;
        }
        $sMsg = '<div class="example-wrap" id="perfilPrincipal" style="width:100%; float:left">'
                . '<div class="example example-well">'
                . '<div class="page-header text-center">'
                . '</br>'
                . '<h1 class="page-title">Bem-vindo!</h1>'
                . '<img class="img-circle img-bordered img-bordered-primary" width="150" height="150" src="Uploads/' . $_SESSION["usuimagem"] . '" id="img-perfil1">'
                . '<h2 class="page-title">' . $_SESSION["nome"] . '</h2>'
                . '<div>'
                . '</div>'
                . '<div style="position: absolute;bottom: 0;right: 0;">'
                . '<p class="page-description">'
                . '<a target="_blank" href="http://metalbo.com.br/" style="margin: 10px;text-decoration: none;">metalbo.com.br</a>'
                . '<a target="_blank" href="https://facebook.com/metalbo.oficial" style="margin: 10px;text-decoration: none;"> '
                . '<button type="button" class="btn btn-labeled btn-xs social-facebook">'
                . '<span class="btn-label">'
                . '<i class="icon bd-facebook" aria-hidden="true"></i>'
                . '</span> Metalbo'
                . '</button>'
                . '</a>'
                . '<a target="_blank" href="https://www.youtube.com/channel/UCO6rJtl4ePqsWRTztRFkE5w" style="margin: 10px;text-decoration: none;">'
                . '<button type="button" class="btn btn-labeled btn-xs social-youtube">'
                . '<span class="btn-label">'
                . '<i class="icon bd-youtube" aria-hidden="true"></i>'
                . '</span> Treinamentos'
                . '</button>'
                . '</a>'
                . '</div>'
                . '</br>'
                . '</div>'
                . '</div>';
        $sMsg = $sMsg . $this->updates();
        $sMsg = $sMsg . '</div>';

        echo "$('#tabmenucont').empty(); $('#tabmenusuperior').empty();$('#menu').empty();$('#menu').append('" . $sEstruturaMenu . "'); ";
        echo "$('#tabmenucont').append('" . $sMsg . "');";
    }

    /**
     * adiciona filtros extras
     */
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('modcod', $this->Model->getModulo()->getModcod());
        $this->Persistencia->adicionaFiltro('mencodigo', $this->Model->getMencodigo());
    }

    /**
     * monta os campos para a próxima etapa
     */
    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getMencodigo();
        $aRetorno[1] = $this->Model->getModulo()->getModcod();
        return $aRetorno;
    }

    public function updates() {
        $oControllerUpdates = Fabrica::FabricarController('MET_TEC_Versao');
        $aBuscaUpdates = $oControllerUpdates->getDadosUpdates();

        $lista = '<ul style="list-style-type: none;">'
                . '  <li class="dropdown-menu-header" role="presentation">'
                . '      <h4>Novidades e atualizações</h4>'
                . '  </li>'
                . '  <li class="list-group scrollable is-enabled scrollable-vertical" role="presentation" style="position: relative;">'
                . '      <div data-role="container" class="scrollable-container">'
                . '          <div data-role="content" class="scrollable-content">';
        foreach ($aBuscaUpdates as $key => $value) {
            $lista = $lista . '            <a class="list-group-item" href="javascript:void(0)" role="menuitem">'
                    . '                <div class="media">'
                    . '                  <div class="media-left padding-right-10">'
                    . '                      <i class="icon wb-order bg-red-600 white icon-circle" aria-hidden="true"></i>'
                    . '                  </div>'
                    . '                  <div class="media-body">'
                    . '                      <h6 class="media-heading">' . $value->descricao . '</h6>'
                    . '                      <time class="media-meta">' . $value->versao . '</time>'
                    . '                  </div>'
                    . '              </div>'
                    . '          </a>';
        }
        $lista = $lista . '      </div>'
                . '  </div>'
                . '  <div class="scrollable-bar scrollable-bar-vertical scrollable-bar-hide" draggable="false">'
                . '      <div class="scrollable-bar-handle" style="height: 205.043px;">'
                . '      </div>'
                . '  </div>'
                . ' </li>'
                . '</ul>';

        return $lista;
    }

}

?>