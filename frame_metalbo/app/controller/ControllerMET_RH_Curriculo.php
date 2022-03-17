<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerMET_RH_Curriculo
 *
 * @author Alexandre
 */
class ControllerMET_RH_Curriculo extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_RH_Curriculo');
    }

    public function getDadosCurriculo() {
        $sDados = $_REQUEST['dados'];
        $aCampos = json_decode($sDados);

        $aRetorno = $this->Persistencia->insereDadosCurriculo($aCampos);

        $_REQUEST['campos'] = $aCampos;
        $sReturn = require 'app/relatorio/curriculo.php';

        if ($aRetorno[0]) {
            $sMensagem = 'success';
        } else {
            $sMensagem = 'error';
        }

        echo json_encode($sMensagem);
    }

}
