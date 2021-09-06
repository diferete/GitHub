<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_RH_Colaboradores extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_RH_Colaboradores');
    }

    public function getDadosFunc() {
        $sDados = $_REQUEST['dados'];
        if ($sDados == '' || $sDados == null) {
            echo json_encode('false');
        } else {
            $aRetorno = $this->Persistencia->getDadosFunc($sDados);
            echo json_encode($aRetorno);
        }
    }

    public function gravaDadosFunc() {
        $sDados = $_REQUEST['dados'];
        $aRetorno = $this->Persistencia->gravaDadosFunc($sDados);

        if ($aRetorno[0]) {
            $bRetorno = true;
            echo json_encode($bRetorno);
        } else {
            $bRetorno = false;
            echo json_encode($bRetorno);
        }
    }

    public function updateDadosFunc() {
        $sDados = $_REQUEST['dados'];
        $aRetorno = $this->Persistencia->updateDadosFunc($sDados);

        if ($aRetorno[0]) {
            $bRetorno = true;
            echo json_encode($bRetorno);
        } else {
            $bRetorno = false;
            echo json_encode($bRetorno);
        }
    }

}
