<?php

/**
 * Classe que controla as operações do objeto ItemMenu
 *
 * @author Fernando Salla
 * @since 29/06/2012
 */
class ControllerItemMenu extends Controller {

    function __construct() {
        $this->carregaClassesMvc('ItemMenu');
    }

    public function getItemMenu($sModcod, $sMenCodigo) {
        return $this->Persistencia->getSubMenu($sModcod, $sMenCodigo);
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe(null);

        $oModelMenu = Fabrica::FabricarModel('Menu');
        $oPersMenu = Fabrica::FabricarPersistencia('Menu');
        $oPersMenu->setModel($oModelMenu);
        $oPersMenu->adicionaFiltro('modcod', $aChave[1]);
        $oPersMenu->adicionaFiltro('mencodigo', $aChave[0]);
        $oModelMenu = $oPersMenu->consultarWhere();

        $aCampos[] = $oModelMenu->getModulo()->getModcod();
        $aCampos[] = $oModelMenu->getModulo()->getModescricao();
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