<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_Catalogo extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Catalogo');
    }

    function montaFiltro() {
        $sDados = $_REQUEST['dados'];
        $aDados = explode('|', $sDados);
        if ($aDados[0] == '' || $aDados[0] == null) {
            echo json_encode('false');
        } else {
            $aRetorno = $this->Persistencia->buscaDadosFiltro($aDados);
            echo json_encode($aRetorno);
        }
    }

    function filtroSubG() {
        $sDados = $_REQUEST['dados'];
        $aRetorno = $this->Persistencia->buscaSubG($sDados);

        echo json_encode($aRetorno);
    }

    function filtroFam() {
        $sDados = $_REQUEST['dados'];
        $aDados = explode(',', $sDados);
        $aRetorno = $this->Persistencia->buscaFam($aDados);

        echo json_encode($aRetorno);
    }

    function filtroSubF() {
        $sDados = $_REQUEST['dados'];
        $aDados = explode(',', $sDados);
        $aRetorno = $this->Persistencia->buscaSubF($aDados);

        echo json_encode($aRetorno);
    }

}
