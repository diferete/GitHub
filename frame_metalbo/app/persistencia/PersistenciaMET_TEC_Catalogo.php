<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_Catalogo extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    function buscaDadosFiltro($aDados) {
        $sSql = "select procod,prodes,pround,promatcod "
                . "from widl.prod01 "
                . "where grucod = " . $aDados[0] . " ";

//====================================================================================================================//
        //adiciona condicionais conforme filtro para Subgrpo, Familia e Subfamilia
        if ($aDados[1] != '' && $aDados[1] != 'null') {
            $sSql .= " and subcod = " . $aDados[1] . " ";
        }
        if ($aDados[2] != '' && $aDados[2] != 'null') {
            $sSql .= "and famcod = " . $aDados[2] . " ";
        }
        if ($aDados[3] != '' && $aDados[3] != 'null') {
            $sSql .= "and famsub = " . $aDados[3] . " ";
        }

//====================================================================================================================//

        $sSql .= "and probloqpro <> 'S' and promatcod <> '' and subcod not in(128,700,710,711,329,9,116,2)";

        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['procod'] = trim($oRowDB->procod);
            $aDadosRet['prodes'] = trim($oRowDB->prodes);
            $aDadosRet['pround'] = trim($oRowDB->pround);
            $aDadosRet['promatcod'] = trim($oRowDB->promatcod);
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

    function buscaSubG($sDados) {
        $sSql = 'select subcod, subdes from widl.prod05 where grucod = ' . $sDados . ' and subcod not in(9,128,512,513)';
        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['cod'] = $oRowDB->subcod;
            $aDadosRet['desc'] = $oRowDB->subdes;
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

    function buscaFam($aDados) {
        $sSql = 'select famcod, famdes from widl.PROD04A where grucod = ' . $aDados[0] . ' and subcod=' . $aDados[1];
        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['cod'] = $oRowDB->famcod;
            $aDadosRet['desc'] = $oRowDB->famdes;
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

    function buscaSubF($aDados) {
        $sSql = 'select famsub, famsdes from widl.PROD04A1 where grucod = ' . $aDados[0] . ' and subcod=' . $aDados[1] . ' and famcod = ' . $aDados[2];
        $result = $this->getObjetoSql($sSql);
        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowDB = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['cod'] = $oRowDB->famsub;
            $aDadosRet['desc'] = $oRowDB->famsdes;
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

}
