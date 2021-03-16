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
                . '<div class="example example-well col-md-8" style="height:700px">'
                . '<div class="page-header text-center">'
                . '</br>'
                . '<h1 class="page-title">Bem-vindo!</h1>'
                . '<img class="img-circle img-bordered img-bordered-primary" width="150" height="150" src="Uploads/' . $_SESSION["usuimagem"] . '" id="img-perfil1">'
                . '<h2 class="page-title">' . $_SESSION["nome"] . '</h2>'
                . '<div>'
                . '</div>'
                . '</br>'
                . '<div style="position: absolute;bottom: 0;left: 0;top: 650px">'
                . '<p class="page-description">'
                . '<a target="_blank" href="http://metalbo.com.br/steeltrater" style="margin: 10px;text-decoration: none;"> '
                . '<button type="button" style="color: purple;border: none;background: transparent;">'
                . '<span>'
                . '<i aria-hidden="true"></i>'
                . '</span> steeltrater.com.br'
                . '</button>'
                . '</a>'
                . '<a target="_blank" href="http://177.84.0.34:8080/DelsoftXPRO/servlet/loginerp"" style="margin: 10px;text-decoration: none;">'
                . '<button type="button" style="color: red;border: none;background: transparent;">'
                . '<span>'
                . '<i aria-hidden="true"></i>'
                . '</span> DelsoftX'
                . '</button>'
                . '</a>'
                . '</div>'
                . '</br>'
                . '</div>';
        $sMsg = $sMsg . $this->montaTabela();
        $sMsg = $sMsg . '</div>';
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

        $html = '</div>'
                . '<div class="col-md-4">'
                . '<h4 style="margin-top:30px;margin-left:5px"><i class="icon wb-book" aria-hidden="true"></i>Atualizações '
                . '  </h4> '
                . ' <div class="example table-responsive" style="margin-left:5px;"> '
                . '   <table class="table table-striped"> '
                . '     <thead> '
                . '       <tr> '
                . '         <th style="font-size:16px;font-weight:600;">Versão</th> '
                . '         <th style="font-size:16px;font-weight:600;">Updates</th> '
                . '         <th style="font-size:16px;font-weight:600;">Doc.</th> '
                . '       </tr>  '
                . '     </thead> '
                . '     <tbody> ';
        foreach ($aBuscaUpdates as $key => $value) {
            $href = '';
            $html = $html . '       <tr> '
                    . '         <td><span class="badge badge-dark">' . $value->versao . '</span></td> '
                    . '         <td style="width:450px">' . $value->updates . '</td> ';
            if ($value->anexo != '') {
                $html = $html . '         <td><a href="http://localhost/github/steeltrater/uploads/' . $value->anexo . '" target="_blank"  rel=”noopener”>Clique aqui</a></td> ';
            } else {
                $html = $html . '         <td></td> ';
            }
            $html = $html . '       </tr> ';
        }
        $html = $html . '     </tbody>'
                . '   </table>'
                . ' </div>';

        return $html;
    }

}

?>