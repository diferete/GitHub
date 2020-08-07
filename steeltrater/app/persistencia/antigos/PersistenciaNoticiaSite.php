<?php

class PersistenciaNoticiaSite extends Persistencia {

    public function __construct() {
        parent:: __construct();

        $this->setTabela('tbnoticias');

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('titulo', 'titulo');
        $this->adicionaRelacionamento('texto', 'texto');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);

        $this->adicionaOrderBy('nr', 1);
    }

    public function liberaNoticia($aDados) {

        $sEmpresa = $_REQUEST['filcgc'];

        if ($sEmpresa == 'metalbo') {
            $filcgc = '75483040000211';
        } else {
            $filcgc = '83781641000158';
        }

        $sSql = " select top 3 nr,titulo,texto,convert(varchar,data,103)as data,filcgc from tbnoticias where filcgc = '" . $filcgc . "' order by nr desc";
        $result = $this->getObjetoSql($sSql);

        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['nr'] = $oRowBD->nr;
            $aDadosRet['titulo'] = $oRowBD->titulo;
            $aDadosRet['texto'] = $oRowBD->texto;
            $aDadosRet['data'] = $oRowBD->data;
            $aDadosRet['filcgc'] = $oRowBD->filcgc;
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

    public function buscaNoticia($aDados) {
        $sEmpresa = $_REQUEST['filcgc'];

        if ($sEmpresa == 'metalbo') {
            $filcgc = '75483040000211';
        } else {
            $filcgc = '83781641000158';
        }
        $sSql = " select titulo,texto,convert(varchar,data,103)as data,filcgc from tbnoticias where filcgc = '" . $filcgc . "' order by nr desc";
        $result = $this->getObjetoSql($sSql);

        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['nr'] = $oRowBD->nr;
            $aDadosRet['titulo'] = $oRowBD->titulo;
            $aDadosRet['texto'] = $oRowBD->texto;
            $aDadosRet['data'] = $oRowBD->data;
            $aDadosRet['filcgc'] = $oRowBD->filcgc;
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

}
