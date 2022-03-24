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

    public function getDadosFuncVideos() {
        $sDados = $_REQUEST['dados'];
        if ($sDados == '' || $sDados == null) {
            echo json_encode('false');
        } else {
            $aRetorno = $this->Persistencia->getDadosFuncVideos($sDados);
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

    public function updateDadosFuncAids() {
        $sDados = $_REQUEST['dados'];
        $aRetorno = $this->Persistencia->updateDadosFuncAids($sDados);

        if ($aRetorno[0]) {
            $bRetorno = true;
            echo json_encode($bRetorno);
        } else {
            $bRetorno = false;
            echo json_encode($bRetorno);
        }
    }

    public function gravaDadosFuncAids() {
        $sDados = $_REQUEST['dados'];
        $aRetorno = $this->Persistencia->gravaDadosFuncAids($sDados);

        if ($aRetorno[0]) {
            $bRetorno = true;
            echo json_encode($bRetorno);
        } else {
            $bRetorno = false;
            echo json_encode($bRetorno);
        }
    }

    public function gravaDadosFuncPalpite() {
        $sDados = $_REQUEST['dados'];
        $oDados = json_decode($sDados);

        $aRetorno = $this->Persistencia->gravaDadosFuncPalpite($oDados);

        if ($aRetorno[0]) {
            $bRetorno = true;
            echo json_encode($bRetorno);
        } else {
            $bRetorno = false;
            echo json_encode($bRetorno);
        }
    }

    public function gravaDadosFuncVideos() {
        $sDados = $_REQUEST['dados'];
        $oDados = json_decode($sDados);

        $aRetorno = $this->Persistencia->gravaDadosFuncVideos($oDados);

        if ($aRetorno[0]) {
            $bRetorno = true;
            echo json_encode($bRetorno);
        } else {
            $bRetorno = false;
            echo json_encode($bRetorno);
        }
    }
    
    public function updateDadosFuncVideos() {
        $sDados = $_REQUEST['dados'];
        $aRetorno = $this->Persistencia->updateDadosFuncVideos($sDados);

        if ($aRetorno[0]) {
            $bRetorno = true;
            echo json_encode($bRetorno);
        } else {
            $bRetorno = false;
            echo json_encode($bRetorno);
        }
    }

}
