<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_RH_Colaboradores extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('vetorh.dbo.r034fun');
        $this->adicionaRelacionamento('numcad', 'numcad');
        $this->adicionaRelacionamento('nomfun', 'nomfun');
        $this->adicionaRelacionamento('dessit', 'dessit');
        $this->adicionaRelacionamento('nomccu', 'nomccu');
        $this->adicionaRelacionamento('grains', 'grains');
        $this->adicionaRelacionamento('desgra', 'desgra');
        $this->adicionaRelacionamento('titcar', 'titcar');

        $this->setBConsultaManual(true);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select vetorh.dbo.r034fun.numcad as 'vetorh.dbo.r034fun.numcad',"
                . "vetorh.dbo.r034fun.nomfun as 'vetorh.dbo.r034fun.nomfun',"
                . "vetorh.dbo.r010sit.dessit as 'vetorh.dbo.r034fun.dessit',"
                . "vetorh.dbo.r018ccu.nomccu as 'vetorh.dbo.r034fun.nomccu',"
                . "vetorh.dbo.r022gra.grains as 'vetorh.dbo.r022gra.grains',"
                . "vetorh.dbo.r022gra.desgra as 'vetorh.dbo.r034fun.desgra',"
                . "vetorh.dbo.r024car.titcar as 'vetorh.dbo.r034fun.titcar' "
                . "from vetorh.dbo.r034fun "
                . "left outer join [vetorh].dbo.r010sit on [vetorh].dbo.r034fun.sitafa = [vetorh].dbo.r010sit.codsit "
                . "left outer join vetorh..r024car on vetorh..r024car.codcar = vetorh..r034fun.codcar "
                . "left outer join vetorh..r018ccu on [vetorh].dbo.r034fun.codccu = vetorh..r018ccu.codccu "
                . "left outer join vetorh..r022gra on vetorh.dbo.r034fun.grains = vetorh.dbo.r022gra.grains ";

        $sSqlWhere = " and vetorh..r034fun.numcad not in(1,2,3,4) and vetorh.dbo.r034fun.codfil in(1,3) and vetorh.dbo.r034fun.numemp = 3 ";
        $this->setSWhereManual($sSqlWhere);

        return $sSql;
    }

    public function getDadosFunc($sDados) {

        $bRetorno = $this->verificaCadastroAids($sDados);

        if (!$bRetorno) {
            $aDados = array();
            $sSql = "select "
                    . "tbfunc.nomfun,"
                    . "setor,"
                    . "tipsex "
                    . "from vetorh.dbo.r034fun "
                    . "left outer join tbfunc "
                    . "on [vetorh].dbo.r034fun.numcad = tbfunc.numcad "
                    . "where "
                    . "cnpj = 75483040000211 "
                    . "and numemp = 3"
                    . "and vetorh.dbo.r034fun.numcad =" . $sDados;
            $oResult = $this->consultaSql($sSql);

            if ($oResult) {
                $aDados['nome'] = trim($oResult->nomfun);
                $aDados['setor'] = trim($oResult->setor);
                $aDados['tipsex'] = trim($oResult->tipsex);
                $aRetorno['dados'] = $aDados;
            } else {
                $aDados[0] = 'false';
                $aDados[1] = 'E';
                $aRetorno['dados'] = $aDados;
            }
        } else {
            $aDados[0] = 'false';
            $aDados[1] = 'C';
            $aRetorno['dados'] = $aDados;
        }
        return $aRetorno;
    }

    public function gravaDadosFunc($sDados) {


        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSqlSelect = "select "
                . "tbfunc.nomfun,"
                . "setor,"
                . "vetorh.dbo.r034fun.tipsex "
                . "from vetorh.dbo.r034fun "
                . "left outer join tbfunc "
                . "on [vetorh].dbo.r034fun.numcad = tbfunc.numcad "
                . "where "
                . "cnpj = 75483040000211 "
                . "and vetorh.dbo.r034fun.numcad =" . $sDados;
        $oResult = $this->consultaSql($sSqlSelect);


        $sSqlInsert = "insert "
                . "into MET_NovembroAzul"
                . "(nr,"
                . "cracha,"
                . "datacad,"
                . "horacad,"
                . "nome,"
                . "setor,"
                . "tag,"
                . "genero)"
                . "values"
                . "((select(case when max(nr) is null then 1 else max(nr)+1 end) as nr from MET_NovembroAzul),"
                . "" . $sDados . ","
                . "'" . $sData . "',"
                . "'" . $sHora . "',"
                . "'" . trim($oResult->nomfun) . "',"
                . "'" . trim($oResult->setor) . "',"
                . "'C',"
                . "'" . trim($oResult->tipsex) . "')";
        $aRetorno = $this->executaSql($sSqlInsert);

        return $aRetorno;
    }

    public function updateDadosFunc($sDados) {

        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSqlUpdate = "update "
                . "MET_NovembroAzul "
                . "set tag = 'A' "
                . "where cracha = " . $sDados;
        $aRetorno = $this->executaSql($sSqlUpdate);

        return $aRetorno;
    }

    public function verificaCadastro($sDados) {
        $sSqlSelect = "select COUNT(*) as total from MET_NovembroAzul where cracha = " . $sDados . "";
        $oResult = $this->consultaSql($sSqlSelect);

        if ($oResult->total > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function gravaDadosFuncAids($sDados) {


        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSqlSelect = "select "
                . "tbfunc.nomfun,"
                . "setor,"
                . "vetorh.dbo.r034fun.tipsex "
                . "from vetorh.dbo.r034fun "
                . "left outer join tbfunc "
                . "on [vetorh].dbo.r034fun.numcad = tbfunc.numcad "
                . "where "
                . "cnpj = 75483040000211 "
                . "and vetorh.dbo.r034fun.numcad =" . $sDados;
        $oResult = $this->consultaSql($sSqlSelect);


        $sSqlInsert = "insert "
                . "into MET_Aids"
                . "(nr,"
                . "cracha,"
                . "datacad,"
                . "horacad,"
                . "nome,"
                . "setor,"
                . "tag,"
                . "genero)"
                . "values"
                . "((select(case when max(nr) is null then 1 else max(nr)+1 end) as nr from MET_Aids),"
                . "" . $sDados . ","
                . "'" . $sData . "',"
                . "'" . $sHora . "',"
                . "'" . trim($oResult->nomfun) . "',"
                . "'" . trim($oResult->setor) . "',"
                . "'C',"
                . "'" . trim($oResult->tipsex) . "')";
        $aRetorno = $this->executaSql($sSqlInsert);

        return $aRetorno;
    }

    public function updateDadosFuncAids($sDados) {

        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSqlUpdate = "update "
                . "MET_Aids "
                . "set tag = 'A' "
                . "where cracha = " . $sDados;
        $aRetorno = $this->executaSql($sSqlUpdate);

        return $aRetorno;
    }

    public function verificaCadastroAids($sDados) {
        $sSqlSelect = "select COUNT(*) as total from MET_Aids where cracha = " . $sDados . "";
        $oResult = $this->consultaSql($sSqlSelect);

        if ($oResult->total > 0) {
            return true;
        } else {
            return false;
        }
    }

}
