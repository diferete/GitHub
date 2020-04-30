<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_NfSaida extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_NfSaida');
    }

    public function enviaXML($sDados) {
        $aDados = explode(',', $sDados);
        $aCamposChave = array();
        parse_str($aDados[2], $aCamposChave);

        $oRetorno = $this->Persistencia->buscaDadosNF($aCamposChave);

        if ($oRetorno->nfs_notafiscalnfesituacao !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'o XML da NF - ' . $aCamposChave['nfs_notafiscalnumero'] . ' não pode ser enviada pois não foi autorizada', Mensagem::TIPO_ERROR, 7000);
            echo $oMsg->getRender();
            exit;
        } else {
            $sDir = '\\\metalbobase\c$\Delsoft\DelsoftX\DelsoftNFe\nfe\8993358000174-STEELTRATER\\';

            $sData = date('d/m/Y', strtotime($oRetorno->nfs_notafiscaldataemissao));
            $aPastasDir = explode('/', $sData);

            //Ano e mês
            $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

            $sDir = $sDir . '\\' . trim($oRetorno->nfs_notafiscalnfechave) . '-nfeProc.xml';

            if (!file_exists($sDir)) {
                $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfs_notafiscalnumero'] . ' não teve seu XML não foi processado', Mensagem::TIPO_ERROR, 7000);
                echo $oMsg->getRender();
                exit;
            } else {
                $_REQUEST['nfs_notafiscalfilial'] = $aCamposChave['NFS_NotaFiscalFilial'];
                $_REQUEST['nfs_notafiscalseq'] = $aCamposChave['NFS_NotaFiscalSeq'];
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

        if ($oRetorno->nfs_notafiscalnfesituacao !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfs_notafiscalnumero'] . ' não pode ser visualizada pois não foi autorizada', Mensagem::TIPO_ERROR, 7000);
            echo $oMsg->getRender();
            exit;
        } else {
            $sDir = '\\\metalbobase\c$\Delsoft\DelsoftX\DelsoftNFe\nfe\8993358000174-STEELTRATER\\';

            $sData = date('d/m/Y', strtotime($oRetorno->nfs_notafiscaldataemissao));
            $aPastasDir = explode('/', $sData);

            //Ano e mês
            $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

            $sDir = $sDir . '\\' . trim($oRetorno->nfs_notafiscalnfechave) . '-nfeProc.xml';
            if (!file_exists($sDir)) {
                $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfs_notafiscalnumero'] . ' não pode ser visualizada pois XML não foi processado', Mensagem::TIPO_ERROR, 7000);
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


        //$aTotal = $this->Persistencia->somaSit();

        $sResulta = '<h3 class="panel-title" style="-webkit-text-stroke-width:thin;">Envio de XML do dia: ' . date('d/m/Y') . '</h3>'
                . '<div style="color:blue !important">Enviados: ' . $aTotal['enviado'] . ''
                . '<span style="color:black !important">&nbsp;&nbsp;&nbsp;  Não enviados: ' . $aTotal['nenviado'] . '</span>'
                . '<span style="color:red !important">&nbsp;&nbsp;&nbsp;  Não autorizadas: ' . $aTotal['nautorizada'] . '</span>'
                . '</div>';

        return $sResulta;
    }

}
