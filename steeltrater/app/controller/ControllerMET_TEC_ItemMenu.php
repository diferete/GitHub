<?php

/**
 * Classe que controla as operações do objeto ItemMenu
 *
 * @author Fernando Salla
 * @since 29/06/2012
 */
class ControllerMET_TEC_ItemMenu extends Controller {

    function __construct() {
        $this->carregaClassesMvc('MET_TEC_ItemMenu');
    }

    public function getItemMenu($sModcod, $sMenCodigo) {
        return $this->Persistencia->getSubMenu($sModcod, $sMenCodigo);
    }

    public function getItemMenuApp($sModcod, $sMenCodigo) {
        return $this->Persistencia->getSubMenuApp($sModcod, $sMenCodigo);
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);

        $oModelMenu = Fabrica::FabricarModel('MET_TEC_Menu');
        $oPersMenu = Fabrica::FabricarPersistencia('MET_TEC_Menu');
        $oPersMenu->setModel($oModelMenu);
        $oPersMenu->adicionaFiltro('modcod', $aChave[1]);
        $oPersMenu->adicionaFiltro('mencodigo', $aChave[0]);
        $oModelMenu = $oPersMenu->consultarWhere();

        $aCampos[] = $oModelMenu->getMET_TEC_Modulo()->getModcod();
        $aCampos[] = $oModelMenu->getMET_TEC_Modulo()->getModescricao();
        $aCampos[] = $oModelMenu->getMencodigo();
        $aCampos[] = $oModelMenu->getMendes();



        $this->View->setAParametrosExtras($aCampos);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if (count($aparam) > 0) {
            $this->Persistencia->adicionaFiltro('modcod', $aparam[0]);
            $this->Persistencia->adicionaFiltro('mencodigo', $aparam[2]);
            $this->Persistencia->setChaveIncremento(false);
        } else {
            $this->Persistencia->adicionaFiltro('modcod', $aparam1[1]);
            $this->Persistencia->adicionaFiltro('mencodigo', $aparam1[0]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();

        $this->Persistencia->adicionaFiltro('itecodigo', $this->Model->getItecodigo());
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
            $aCampoAtual = explode('=', $sCampoAtual);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[1], $aCampoAtual[1]);
        }

        $this->Persistencia->setChaveIncremento(false);
    }

}

?>