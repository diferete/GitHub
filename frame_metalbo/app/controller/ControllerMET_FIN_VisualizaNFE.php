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

        $oRetorno = $this->Persistencia->buscaDadosNF($aCamposChave);

        if ($oRetorno->nfsnfesit !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'o XML da NF - ' . $aCamposChave['nfsnfnro'] . ' não pode ser enviada pois não foi autorizada', Mensagem::TIPO_ERROR, 7000);
            echo $oMsg->getRender();
            exit;
        } else {
            $sDir = '\\\sistema_metalbo\Delonei\Notas\\';
            if ($aCamposChave['nfsfilcgc'] == '75483040000211') {
                $sDir = $sDir . '75483040000211-FILIAL';
            }
            if ($aCamposChave['nfsfilcgc'] == '75483040000130') {
                $sDir = $sDir . '75483040000130-REX';
            }
            $sData = date('d/m/Y', strtotime($oRetorno->nfsdtemiss));
            $aPastasDir = explode('/', $sData);

            //Dir = Ano-mês/dia
            $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

            $sDir = $sDir . '\\' . trim($oRetorno->nfsnfechv) . '-nfeProc.xml';
            if (!file_exists($sDir)) {
                $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfsnfnro'] . ' não teve seu XML não foi processado', Mensagem::TIPO_ERROR, 7000);
                echo $oMsg->getRender();
                exit;
            } else {
                $_REQUEST['nfsfilcgc'] = $aCamposChave['nfsfilcgc'];
                $_REQUEST['nfsnfnro'] = $aCamposChave['nfsnfnro'];
                $_REQUEST['nfsnfser'] = $aCamposChave['nfsnfser'];
                $_REQUEST['idPesq'] = $aDados[1];

                require 'app/relatorio/DanfeEnvManual.php';
            }
        }
    }

    public function beforeMostraRelConsulta($sParametros) {
        parent::beforeMostraRelConsulta($sParametros);

        $aDados = explode(',', $sParametros);
        $sCampos = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sCampos, $aCamposChave);

        $oRetorno = $this->Persistencia->buscaDadosNF($aCamposChave);

        if ($oRetorno->nfsnfesit !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfsnfnro'] . ' não pode ser visualizada pois não foi autorizada', Mensagem::TIPO_ERROR, 7000);
            echo $oMsg->getRender();
            exit;
        } else {
            $sDir = '\\\sistema_metalbo\Delonei\Notas\\';
            if ($aCamposChave['nfsfilcgc'] == '75483040000211') {
                $sDir = $sDir . '75483040000211-FILIAL';
            }
            if ($aCamposChave['nfsfilcgc'] == '75483040000130') {
                $sDir = $sDir . '75483040000130-REX';
            }
            $sData = date('d/m/Y', strtotime($oRetorno->nfsdtemiss));
            $aPastasDir = explode('/', $sData);

            //Dir = Ano-mês/dia
            $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

            $sDir = $sDir . '\\' . trim($oRetorno->nfsnfechv) . '-nfeProc.xml';
            if (!file_exists($sDir)) {
                $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfsnfnro'] . ' não pode ser visualizada pois XML não foi processado', Mensagem::TIPO_ERROR, 7000);
                echo $oMsg->getRender();
                exit;
            } else {
                
            }
        }
    }

    public function enviaXmlAutomatizado() {
        require 'app/relatorio/DanfeEnvAutomatico.php';
    }

    /**
     * Monta Wizard linha do tempo OnClick para Gerenciar Projetos
     * */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);


        $aTotal = $this->Persistencia->somaSit();

        $sResulta = '<h3 class="panel-title" style="-webkit-text-stroke-width:thin;">Envio de XML do dia: ' . date('d/m/Y') . '</h3>'
                . '<div style="color:blue !important">Enviados: ' . $aTotal['enviado'] . ''
                . '<span style="color:black !important">&nbsp;&nbsp;&nbsp;  Não enviados: ' . $aTotal['nenviado'] . '</span>'
                . '<span style="color:red !important">&nbsp;&nbsp;&nbsp;  Não autorizadas: ' . $aTotal['nautorizada'] . '</span>'
                . '</div>';

        return $sResulta;
    }

    public function enviaXmlsManual() {
        require 'app/relatorio/DanfeEnvAutomatico.php';
    }

}
