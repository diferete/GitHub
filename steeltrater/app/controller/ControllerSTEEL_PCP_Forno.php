<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 05/07/2018
 */

class ControllerSTEEL_PCP_Forno extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_FORNO');
        $this->setControllerDetalhe('STEEL_PCP_HorasParadas');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('fornocod', $this->Model->getFornocod());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFornocod();
        return $aRetorno;
    }

    /**
     * Busca forno
     * @param type $iForno
     * @return type
     */
    public function buscaForno($iForno) {
        $this->Persistencia->adicionaFiltro('fornocod', $iForno);
        $oForno = $this->Persistencia->consultarWhere();
        return $oForno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->setFornoCookie();


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->setFornoCookie();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function setFornoCookie() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['cookfornocod'] !== '') {
            setcookie("cookfornocod", $aCampos['cookfornocod'], time() + 3600 * 24 * 30 * 12 * 5);
            setcookie("cookfornodes", $aCampos['cookfornodes'], time() + 3600 * 24 * 30 * 12 * 5);
        } else {
            setcookie("cookfornocod", '');
            setcookie("cookfornodes", '');
        }
    }

}
