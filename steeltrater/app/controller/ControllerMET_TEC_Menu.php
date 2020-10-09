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
                    . ' <a href="javascript:void(0)" data-slug="layout">'
                    . ' <i class="site-menu-icon wb-list" aria-hidden="true"  style="color:green"></i>'
                    . ' <span class="site-menu-title">' . $aMenuSup[0] . '</span>'
                    . ' <span class="site-menu-arrow"></span>'
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
                            . '     <i class="site-menu-icon  icon fa-star-o " title="Adiciona a Favoritos!" aria-hidden="true" onclick="requestAjax(\\\'menu-' . $iMenuId . '\\\',\\\'MET_TEC_FavMenu\\\',\\\'msgInsFav\\\',\\\'' . utf8_encode($aSupItem[0]) . ',' . utf8_encode($aSupItem[1]) . ',' . utf8_encode($aSupItem[2]) . '\\\');";></i>'
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
                . '   <div class="example example-well">'
                . '     <div class="page-header text-center">'
                . '       <h1 class="page-title">Bem vindo, ' . $_SESSION["nome"] . '!</h1>'
                . '       <p class="page-description">'
                . '        <a target="_blank" href="http://www.metalbo.com.br">www.metalbo.com.br</a></br> '
                . '       <a target="_blank" href="http://facebook.com/metalbo.oficial"> <button type="button" class="btn btn-labeled btn-xs social-facebook"> '
                . '<span class="btn-label"><i class="icon bd-facebook" aria-hidden="true"></i></span>Facebook</button></a></br></br>'
                . '             <img class="img-circle img-bordered img-bordered-primary" width="150" height="150" '
                . '             src="Uploads/' . $_SESSION["usuimagem"] . '" id="img-perfil1"> '
                . '       </p>'
                . '     </div>'
                . '   </div>'
                . ' </div>';
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

}

?>