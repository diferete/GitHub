<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerMET_FRETE_FaturaXml
 *
 * @author Alexandre
 */
class ControllerMET_FRETE_FaturaXml extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_FRETE_FaturaXml');
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);
        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function antesVisualizar($sParametros = null) {
        parent::antesVisualizar($sParametros);
        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function afterCommitInsert() {
        parent::afterCommitInsert();

        $aArquivos = $this->Persistencia->getArquivos();

        foreach ($aArquivos as $aDadosFatura) {

            $iArquivo = $this->verificaArquivo($aDadosFatura['fatura']);

            /* 1 - ZIP
             * 2 - RAR */
            switch ($iArquivo) {
                case 1:
                    $zip = new ZipArchive;
                    if ($zip->open('uploads/xml-cte/' . $aDadosFatura['fatura'] . '.zip') === TRUE) {
                        $zip->extractTo('uploads/xml-cte/' . $aDadosFatura['fatura']);
                        $zip->close();

                        foreach (array_filter(glob('uploads/xml-cte/' . $aDadosFatura['fatura'] . '/*'), 'is_file') as $arquivo) {
                            $aDados = array();

                            date_default_timezone_set('America/Sao_Paulo');
                            $aDados['fatura'] = $aDadosFatura['fatura'];
                            $aDados['cnpj'] = $aDadosFatura['cnpj'];
                            $aDados['dataem'] = $aDadosFatura['dataEmit'];
                            $aDados['datafn'] = $aDadosFatura['dataVenc'];
                            $aDados['data'] = date('d/m/Y');
                            $aDados['hora'] = date('H:i:s');
                            $aDados['usuario'] = $_SESSION['nome'];
                            $aDados['sNFE'] = '';


                            $oXml = simplexml_load_file($arquivo);
                            $aDados['sNCTe'] = (string) $oXml->CTe->infCte->ide->nCT;
                            $aDados['sValorServico'] = (string) $oXml->CTe->infCte->vPrest->vTPrest;

                            $aDados['aObjetoChaves'] = (array) $oXml->CTe->infCte->infCTeNorm->infDoc;
                            $aDados['sValorCarga'] = (string) $oXml->CTe->infCte->infCTeNorm->infCarga->vCarga;
                            if ($aDados['cnpj'] == '428307001593') {
                                $aPeso['aPeso'] = (array) $oXml->CTe->infCte->infCTeNorm->infCarga->infQ[1]; //->qCarga;
                                $aDados['sCNPJDest'] = (string) $oXml->CTe->infCte->dest->CNPJ; //ver
                                $aDados['sCNPJRem'] = (string) $oXml->CTe->infCte->rem->CNPJ; //ver
                                if ($aDados['sCNPJDest'] == '75483040000211') {
                                    $aDados['sCNPJCliente'] = $aDados['sCNPJRem'];
                                } else {
                                    $aDados['sCNPJCliente'] = $aDados['sCNPJDest'];
                                }
                                if ($aPeso['aPeso']['tpMed'] == 'CUBAGEM') {
                                    $aPeso['qCarga'] = $aPeso['aPeso']['qCarga'] * 300;
                                } else {
                                    $aPeso['qCarga'] = $aPeso['aPeso']['qCarga'];
                                }
                            } else {
                                $aPeso = (array) $oXml->CTe->infCte->infCTeNorm->infCarga->infQ[4]; //->qCarga;
                                if ($aPeso['aPeso']['tpMed'] == 'CUBAGEM') {
                                    $aPeso['qCarga'] = $aPeso['aPeso']['qCarga'] * 300;
                                }
                                $aDados['sCNPJDest'] = (string) $oXml->CTe->infCte->dest->CNPJ;
                                $aDados['sCNPJRem'] = (string) $oXml->CTe->infCte->rem->CNPJ; //ver
                                if ($aDados['sCNPJDest'] == '75483040000211') {
                                    $aDados['sCNPJCliente'] = $aDados['sCNPJRem'];
                                } else {
                                    $aDados['sCNPJCliente'] = $aDados['sCNPJDest'];
                                }
                            }
                            $aDados['sPeso'] = $aPeso['qCarga'];

                            /* veriica se existem mais de uma nota/chave referente ao CTE e concatena ambas */
                            foreach ($aDados['aObjetoChaves'] as $key => $chaves) {
                                $aDados['iTotal'] = count($chaves); //número de elementos
                                if ($aDados['iTotal'] > 1) {
                                    foreach ($chaves as $chave) {
                                        if ($aDados['sNFE'] == '') {
                                            $aDados['sNFE'] = "'" . substr((string) $chave->chave, 25, 9) . "'";
                                        } else {
                                            $aDados['sNFE'] = $aDados['sNFE'] . ",'" . substr((string) $chave->chave, 25, 9) . "'";
                                        }
                                    }
                                } else {
                                    $aDados['sNFE'] = "'" . substr((string) $chaves->chave, 25, 9) . "'";
                                }
                            }
                            $this->Persistencia->gerenciaXML($aDados);
                        }
                    }

                    break;
                case 2:
                    $rar_file = rar_open('uploads/xml-cte/' . $aDadosFatura['fatura'] . '.rar');
                    $entries = rar_list($rar_file);
                    foreach ($entries as $entry) {
                        $entry->extract('uploads/xml-cte/' . $aDadosFatura['fatura']);
                    }
                    rar_close($rar_file);

                    foreach (array_filter(glob('uploads/xml-cte/' . $aDadosFatura['fatura'] . '/*'), 'is_file') as $arquivo) {
                        $aDados = array();

                        date_default_timezone_set('America/Sao_Paulo');
                        $aDados['fatura'] = $aDadosFatura['fatura'];
                        $aDados['cnpj'] = $aDadosFatura['cnpj'];
                        $aDados['dataem'] = $aDadosFatura['dataEmit'];
                        $aDados['datafn'] = $aDadosFatura['dataVenc'];
                        $aDados['data'] = date('d/m/Y');
                        $aDados['hora'] = date('H:i:s');
                        $aDados['usuario'] = $_SESSION['nome'];
                        $aDados['sNFE'] = '';


                        $oXml = simplexml_load_file($arquivo);
                        $aDados['sNCTe'] = (string) $oXml->CTe->infCte->ide->nCT;
                        $aDados['sValorServico'] = (string) $oXml->CTe->infCte->vPrest->vTPrest;
                        $aDados['sCNPJCliente'] = (string) $oXml->CTe->infCte->dest->CNPJ;
                        $aDados['aObjetoChaves'] = (array) $oXml->CTe->infCte->infCTeNorm->infDoc;
                        $aDados['sValorCarga'] = (string) $oXml->CTe->infCte->infCTeNorm->infCarga->vCarga;
                        if ($aDados['cnpj'] == '428307001593') {
                            $aPeso['aPeso'] = (array) $oXml->CTe->infCte->infCTeNorm->infCarga->infQ[1]; //->qCarga;
                            $aDados['sCNPJDest'] = (string) $oXml->CTe->infCte->dest->CNPJ; //ver
                            $aDados['sCNPJRem'] = (string) $oXml->CTe->infCte->rem->CNPJ; //ver
                            if ($aDados['sCNPJDest'] == '75483040000211') {
                                $aDados['sCNPJCliente'] = $aDados['sCNPJRem'];
                            } else {
                                $aDados['sCNPJCliente'] = $aDados['sCNPJDest'];
                            }
                            if ($aPeso['aPeso']['tpMed'] == 'CUBAGEM') {
                                $aPeso['qCarga'] = $aPeso['aPeso']['qCarga'] * 300;
                            } else {
                                $aPeso['qCarga'] = $aPeso['aPeso']['qCarga'];
                            }
                        } else {
                            $aPeso = (array) $oXml->CTe->infCte->infCTeNorm->infCarga->infQ[4]; //->qCarga;
                            if ($aPeso['aPeso']['tpMed'] == 'CUBAGEM') {
                                $aPeso['qCarga'] = $aPeso['aPeso']['qCarga'] * 300;
                            }
                            $aDados['sCNPJDest'] = (string) $oXml->CTe->infCte->dest->CNPJ;
                            $aDados['sCNPJRem'] = (string) $oXml->CTe->infCte->rem->CNPJ; //ver
                            if ($aDados['sCNPJDest'] == '75483040000211') {
                                $aDados['sCNPJCliente'] = $aDados['sCNPJRem'];
                            } else {
                                $aDados['sCNPJCliente'] = $aDados['sCNPJDest'];
                            }
                        }
                        $aDados['sPeso'] = $aPeso['qCarga'];

                        /* veriica se existem mais de uma nota/chave referente ao CTE e concatena ambas */
                        foreach ($aDados['aObjetoChaves'] as $key => $chaves) {
                            $aDados['iTotal'] = count($chaves); //número de elementos
                            if ($aDados['iTotal'] > 1) {
                                foreach ($chaves as $chave) {
                                    if ($aDados['sNFE'] == '') {
                                        $aDados['sNFE'] = "'" . substr((string) $chave->chave, 25, 9) . "'";
                                    } else {
                                        $aDados['sNFE'] = $aDados['sNFE'] . ",'" . substr((string) $chave->chave, 25, 9) . "'";
                                    }
                                }
                            } else {
                                $aDados['sNFE'] = "'" . substr((string) $chaves->chave, 25, 9) . "'";
                            }
                        }
                        $this->Persistencia->gerenciaXML($aDados);
                    }

                    break;
            }
            $this->Persistencia->setTagOpen($aDadosFatura);
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function verificaArquivo($fatura) {
        if (!file_exists('uploads/xml-cte/' . $fatura . '.zip')) {
            if (!file_exists('uploads/xml-cte/' . $fatura . '.rar')) {
                return false;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

}
