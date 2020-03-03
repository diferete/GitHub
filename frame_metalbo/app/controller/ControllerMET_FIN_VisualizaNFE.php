<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_FIN_VisualizaNFE extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_FIN_VisualizaNFE');
    }

    public function enviaXML($sDados) {
        $aDados = explode(',', $sDados);
        $aDadosDanfe = array();
        parse_str($aDados[2], $aDadosDanfe);

        $_REQUEST['nfsfilcgc'] = $aDadosDanfe['nfsfilcgc'];
        $_REQUEST['nfsnfnro'] = $aDadosDanfe['nfsnfnro'];
        $_REQUEST['nfsnfser'] = $aDadosDanfe['nfsnfser'];
        $_REQUEST['idPesq'] = $aDados[1];

        require 'app/relatorio/DANFE.php';

    }

}
