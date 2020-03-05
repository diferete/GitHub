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
        $aCamposChave = array();
        parse_str($aDados[2], $aCamposChave);

        $sRetorno = $this->Persistencia->buscaDadosNF($aCamposChave);

        if ($sRetorno !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'o XML da NF - ' . $aCamposChave['nfsnfnro'] . ' não pode ser enviada pois não foi autorizada', Mensagem::TIPO_ERROR, 10000);
            echo $oMsg->getRender();
        } else {
            $_REQUEST['nfsfilcgc'] = $aCamposChave['nfsfilcgc'];
            $_REQUEST['nfsnfnro'] = $aCamposChave['nfsnfnro'];
            $_REQUEST['nfsnfser'] = $aCamposChave['nfsnfser'];
            $_REQUEST['idPesq'] = $aDados[1];

            require 'app/relatorio/DANFE.php';
        }
    }

    public function beforeMostraRelConsulta($sParametros) {
        parent::beforeMostraRelConsulta($sParametros);

        $aDados = explode(',', $sParametros);
        $sCampos = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sCampos, $aCamposChave);

        $sRetorno = $this->Persistencia->buscaDadosNF($aCamposChave);

        if ($sRetorno !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfsnfnro'] . ' não pode ser visualizada pois não foi autorizada', Mensagem::TIPO_ERROR, 10000);
            echo $oMsg->getRender();
            exit;
        }
    }

    public function enviaXmlAutomatizado() {
        require 'app/relatorio/DANFE3.php';
    }

}
