<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_PORT_CadVeiculos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PORT_CadVeiculos');
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setPlaca(strtoupper($this->Model->getPlaca()));

        $sModelo = $this->Model->getModelo();

        if ($sModelo != 'Selecionar') {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $oMsg = new Mensagem('Atenção', 'Favor selecionar o MODELO do veículo!', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();


            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setPlaca(strtoupper($this->Model->getPlaca()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function buscaPlaca() {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aCamposChave['placa'] == '') {
            exit;
        } else {
            $bRetorno = $this->Persistencia->buscaPlaca($aCamposChave['placa']);

            if ($bRetorno == true) {
                $oMsg = new Modal('Cadastro', 'Placa já cadastrada no sistema', Modal::TIPO_AVISO, false, true, false);
                echo $oMsg->getRender();
            } else {
                return;
            }
        }
    }

}
