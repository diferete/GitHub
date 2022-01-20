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

            $_REQUEST['cnpj'] = $aDadosFatura['cnpj'];
            $_REQUEST['fatura'] = $aDadosFatura['fatura'];
            $_REQUEST['dataEmit'] = $aDadosFatura['dataEmit'];
            $_REQUEST['dataVenc'] = $aDadosFatura['dataVenc'];
            $_REQUEST['usuario'] = $_SESSION['nome'];

            /* 1 - ZIP
             * 2 - RAR */
            switch ($iArquivo) {
                case 1:
                    $zip = new ZipArchive;
                    if ($zip->open('uploads/xml-cte/' . $aDadosFatura['fatura'] . '.zip') === TRUE) {
                        $zip->extractTo('uploads/xml-cte/' . $aDadosFatura['fatura']);
                        $zip->close();

                        $count = 0;
                        foreach (array_filter(glob('uploads/xml-cte/' . $aDadosFatura['fatura'] . '/*'), 'is_file') as $file) {

                            $count++;

                            $_REQUEST['xml'] = $file;

                            require 'app/relatorio/UploadXmlFrete.php';
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



                    foreach (array_filter(glob('uploads/xml-cte/' . $aDadosFatura['fatura'] . '/*'), 'is_file') as $file) {
                        $_REQUEST['xml'] = $file;
                        require 'app/relatorio/UploadXmlFrete.php';
                    }

                    break;
            }
            $this->Persistencia->setTagOpen($aDadosFatura);
        }

        $count;

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
