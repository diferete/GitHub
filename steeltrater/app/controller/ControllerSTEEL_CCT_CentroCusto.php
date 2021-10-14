<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerSTEEL_CCT_CentroCusto
 *
 * @author Alexandre
 */
class ControllerSTEEL_CCT_CentroCusto extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_CCT_CentroCusto');
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);
        $aTeste = explode('=', $sParametros[0]);

        $this->View->setAParametrosExtras($aTeste[1]);
    }

    public function afterInsert() {
        parent::afterInsert();
        $aCampos = $this->getArrayCampostela();

        $aRet = $this->Persistencia->insertFilial($aCampos);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $aCampos = $this->getArrayCampostela();

        $aRet = $this->Persistencia->updateFilial($aCampos);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->carregaDefault();


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->carregaDefault();


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /*
     * Funcao para pegar valores padroes das cargas da classe
     */

    public function carregaDefault() {
        $this->Model->setCCT_Produtivo('N');
        $this->Model->setPEO_CentroCustoORC(0);
        $this->Model->setPEO_CentroCustoDRT(0);
        $this->Model->setPEO_CentroCustoPEO('N');
        $this->Model->setPEO_CentroCustoBLV('N');
        $this->Model->setMNT_CentroCustoAbreOS('N');
        $this->Model->setMNT_CentroCustoApontaOS('N');
        $this->Model->setPEO_CentroCustoOCE('N');
        $this->Model->setMNT_CentroCustoCriticidade(0);
        $this->Model->setMNT_CentroCustoArea(0);
        $this->Model->setMNT_CentroCustoTipoAprovacao('I');
        $this->Model->setMNT_CentroCustoAprovAutomatica('N');
        $this->Model->setESP_HolambraCCTFilialDestino(0);
        $this->Model->setESP_HolambraCCTPlanoDestino(0);
        $this->Model->setESP_HolambraCCTContaDestino(0);
    }

}
