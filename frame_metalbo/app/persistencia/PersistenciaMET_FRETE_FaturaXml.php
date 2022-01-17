<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersistenciaMET_FRETE_FaturaXml
 *
 * @author Alexandre
 */
class PersistenciaMET_FRETE_FaturaXml extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_FRETE_FaturaXml');
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('cnpj', 'cnpj', true, true);
        $this->adicionaRelacionamento('fatura', 'fatura', true, true);
        $this->adicionaRelacionamento('dataEmit', 'dataEmit');
        $this->adicionaRelacionamento('dataVenc', 'dataVenc');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('dataUpload', 'dataUpload');
        $this->adicionaRelacionamento('horaUpload', 'horaUpload');
        $this->adicionaRelacionamento('arquivo', 'arquivo');
        $this->adicionaRelacionamento('extraido', 'extraido');
    }

    public function buscaEmpresas() {
        $sSql = "select distinct cnpj,empdes from tbfrete left outer join widl.emp01
	         on tbfrete.cnpj =  widl.emp01.empcod ";
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI] = $key;
            $iI++;
        }
        return $aRow;
    }

    public function getArquivos() {
        $sData = date('d/m/Y');
        $sSql = "select "
                . "cnpj,"
                . "fatura,"
                . "convert(varchar, dataemit, 103) as dataemit,"
                . "convert(varchar, datavenc, 103) as datavenc "
                . "from MET_FRETE_FaturaXml "
                . "where extraido = 'N' and "
                . "dataUpload between '" . $sData . "' "
                . "and '" . $sData . "'";
        $result = $this->getObjetoSql($sSql);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            //adiciona o objeto atual ao array de retorno
            $aDados['cnpj'] = $oRowBD->cnpj;
            $aDados['fatura'] = $oRowBD->fatura;
            $aDados['dataEmit'] = $oRowBD->dataemit;
            $aDados['dataVenc'] = $oRowBD->datavenc;
            $aRetorno[] = $aDados;
        }

        return $aRetorno;
    }

    public function setTagOpen($aDados) {
        $sSql = "update MET_FRETE_FaturaXml set extraido = 'S' where cnpj = " . $aDados['cnpj'] . " and fatura = " . $aDados['fatura'] . "";
        $this->executaSql($sSql);
    }

}
