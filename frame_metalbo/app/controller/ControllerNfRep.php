<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerNfRep extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('NfRep');
    }

    /**
     * Método que alimenta os campos abaixo do grid
     */
    public function camposGrid($sDados) {
        $aDados = explode(',', $sDados);
        $aNfs = explode('=', $aDados[1]);
        $sNf = $aNfs[1];

        //busca os pedidos e as observações da nota fiscal
        $sObsPed = $this->Persistencia->buscaPed($sNf);
        //buca todas as od
        $sOds = $this->Persistencia->buscaTodasOd($sNf);
        echo '$("#' . $aDados[2] . '").val("' . $sObsPed . '");';
        echo '$("#' . $aDados[3] . '").val("' . $sOds . '");';
    }

    /////////////////////////////////////////////////////////
    public function enviaXML($sDados) {
        $aDados = explode(',', $sDados);
        $aCamposChave = array();
        parse_str($aDados[2], $aCamposChave);

        $oRetorno = $this->Persistencia->buscaDadosNFRep($aCamposChave);

        if ($oRetorno->nfsnfesit !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'o XML da NF - ' . $aCamposChave['nfsnfnro'] . ' não pode ser enviada pois não foi autorizada', Mensagem::TIPO_ERROR, 7000);
            echo $oMsg->getRender();
            exit;
        } else {
            $sDir = '\\\sistema_metalbo\Delonei\Notas\\';
            if ($oRetorno->nfsfilcgc == '75483040000211') {
                $sDir = $sDir . '75483040000211-FILIAL';
            }
            if ($oRetorno->nfsfilcgc == '75483040000130') {
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
                $_REQUEST['nfsfilcgc'] = $oRetorno->nfsfilcgc;
                $_REQUEST['nfsnfnro'] = $aCamposChave['nfsnfnro'];
                $_REQUEST['nfsnfser'] = 2;
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

        $oRetorno = $this->Persistencia->buscaDadosNFRep($aCamposChave);

        if ($oRetorno->nfsnfesit !== 'A') {
            $oMsg = new Mensagem('Atenção!', 'Danfe da NF - ' . $aCamposChave['nfsnfnro'] . ' não pode ser visualizada pois não foi autorizada', Mensagem::TIPO_ERROR, 7000);
            echo $oMsg->getRender();
            exit;
        } else {
            $sDir = '\\\sistema_metalbo\Delonei\Notas\\';
            if ($oRetorno->nfsfilcgc == '75483040000211') {
                $sDir = $sDir . '75483040000211-FILIAL';
            }
            if ($oRetorno->nfsfilcgc == '75483040000130') {
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
            $_REQUEST['nfsfilcgc'] = $oRetorno->nfsfilcgc;
            $_REQUEST['nfsnfnro'] = $aCamposChave['nfsnfnro'];
            $_REQUEST['nfsnfser'] = 2;
        }
    }

    public function enviaXmlAutomatizado() {
        require 'app/relatorio/DanfeEnvAutomatico.php';
    }

    //////////////////////////////////////////////////////////
    public function mostraTelaRelFat($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'RelRepFat');
    }

    public function getSget() {
        parent::getSget();

        $sGet = '&codrep=' . $_SESSION['repsoffice'];
        if (isset($_REQUEST['nfsfilcgc'])) {
            $sGet .= '&nfsfilcgc=' . $_REQUEST['nfsfilcgc'];
        }
        if (isset($_REQUEST['nfsnfser'])) {
            $sGet .= '&nfsnfser=' . $_REQUEST['nfsnfser'];
        }

        return $sGet;
    }

}
