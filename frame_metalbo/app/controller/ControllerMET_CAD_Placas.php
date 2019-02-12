<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_CAD_Placas extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_CAD_Placas');
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setPlaca(strtoupper($this->Model->getPlaca()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setPlaca(strtoupper($this->Model->getPlaca()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function buscaPlaca($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aDados = explode(',', $sDados);

        if ($aCamposChave['placa'] == '') {
            exit;
        } else {
            $bRetorno = $this->Persistencia->buscaPlaca($aCamposChave['placa']);

            if ($bRetorno == true) {
                $oMsg = new Modal('Cadastro', 'Placa já cadastrada no sistema!', Modal::TIPO_AVISO, false, true, false);
                echo"$('#" . $aDados[0] . "').val('" . strtoupper($aCamposChave['placa']) . "');";
                echo $oMsg->getRender();
            } else {
                echo"$('#" . $aDados[0] . "').val('" . strtoupper($aCamposChave['placa']) . "');";
                return;
            }
        }
    }

    public function buscaPessoa($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aConsulta = $this->Persistencia->consultaCracha($aCamposChave);

        echo"$('#" . $aDados[0] . "').val('" . $aConsulta[0] . "');";
    }

}
