<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_ISO_Treinamentos extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_ISO_Treinamentos');
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('cracha', 'cracha');
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        $this->adicionaRelacionamento('funcao', 'funcao');
        $this->adicionaRelacionamento('data_cad', 'data_cad');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('grau_escolaridade', 'grau_escolaridade');
        $this->adicionaRelacionamento('tagEscolaridade', 'tagEscolaridade');
        $this->adicionaRelacionamento('tagTreinamento', 'tagTreinamento');

        $this->setSTop('75');
        $this->adicionaOrderBy('nr', 1);
    }

    public function buscaDadosColaborador($aDados) {
        $sSql = "select vetorh.dbo.r034fun.numcad as 'numcad',"
                . "vetorh.dbo.r034fun.nomfun as 'nomfun',"
                . "vetorh.dbo.r010sit.dessit as 'dessit',"
                . "vetorh.dbo.r018ccu.nomccu as 'nomccu',"
                . "vetorh.dbo.r022gra.grains as 'grains',"
                . "vetorh.dbo.r022gra.desgra as 'desgra',"
                . "vetorh.dbo.r024car.titcar as 'titcar' "
                . "from vetorh.dbo.r034fun "
                . "left outer join [vetorh].dbo.r010sit on [vetorh].dbo.r034fun.sitafa = [vetorh].dbo.r010sit.codsit "
                . "left outer join vetorh..r024car on vetorh..r024car.codcar = vetorh..r034fun.codcar "
                . "left outer join vetorh..r018ccu on [vetorh].dbo.r034fun.codccu = vetorh..r018ccu.codccu "
                . "left outer join vetorh..r022gra on vetorh.dbo.r034fun.grains = vetorh.dbo.r022gra.grains where vetorh.dbo.r034fun.numcad =  " . $aDados['cracha'] . " and vetorh.dbo.r034fun.sitafa not in ('7')";
        $oDados = $this->consultaSql($sSql);
        return $oDados;
    }

    public function deletaDependencias($aDados) {

        $sSql = "delete from MET_ISO_RegistroTreinamento where nr =" . $aDados[1] . "  and filcgc = " . $aDados[0];
        $this->executaSql($sSql);
    }

    public function buscaDadosFuncao($oDados) {
        $sSql = "select * from MET_ISO_FuncDesc"
                . " where nr = (SELECT  max(nr) FROM MET_ISO_FuncDesc WHERE descricao = '" . $oDados->titcar . "')"
                . " and seq = (SELECT MAX(seq) FROM MET_ISO_FuncDesc WHERE descricao =  '" . $oDados->titcar . "')";
        $oRetorno = $this->consultaSql($sSql);

        return $oRetorno;
    }

    public function updateEscolaridade() {
        $aDados = array();
        $sSql = 'select cracha,tagescolaridade from MET_ISO_Treinamentos';
        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['cracha'] = $oRowBD->cracha;
            $oDados = $this->buscaDadosColaborador($aDados);
            $oFuncao = $this->buscaDadosFuncao($oDados);
            if (($oFuncao->esc_exigida > $oDados->grains) && $oRowBD->tagescolaridade != 'I') {
                $sSqlUpdate = "update MET_ISO_Treinamentos set tagescolaridade = 'I' where nome = '" . $oDados->nomfun . "' and funcao = '" . $oDados->cargo . "' and cracha =" . $oDados->numcad;
                $this->executaSql($sSqlUpdate);
            }
            if (($oFuncao->esc_exigida <= $oDados->grains) && $oRowBD->tagescolaridade != 'C') {
                $sSqlUpdate = "update MET_ISO_Treinamentos set tagescolaridade = 'C' where nome = '" . $oDados->nomfun . "' and funcao = '" . $oDados->cargo . "' and cracha =" . $oDados->numcad;
                $this->executaSql($sSqlUpdate);
            }
        }
    }

    public function somaFunc() {
        $aDados = array();
        $sSql = 'select cracha from MET_ISO_Treinamentos';
        $result = $this->getObjetoSql($sSql);
        $iCountTotal = 0;
        $crachas = '';

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['cracha'] = $oRowBD->cracha;
            $oDados = $this->buscaDadosColaborador($aDados);
            $oFuncao = $this->buscaDadosFuncao($oDados);
            if ($oFuncao->esc_exigida > $oDados->grains) {
                $crachas = $oRowBD->cracha . ', ' . $crachas;
            }
            $iCountTotal++;
        }
        $aCount['total'] = $iCountTotal;
        $aCount['crachas'] = $crachas;
        return $aCount;
    }

    public function buscaTreinamentos($aDados) {
        $sSql = "select DISTINCT cod_treinamento from MET_ISO_RegistroTreinamento where nr =" . $aDados['nr'] . " and filcgc = 75483040000211";
        $aTreinamentos = array();
        $result = $this->getObjetoSql($sSql);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $sSqlSelect = "select * from MET_ISO_RegistroTreinamento where seq = (select MAX(seq) as seq from MET_ISO_RegistroTreinamento where cod_treinamento = " . $oRowBD->cod_treinamento . ")";
            $oObjeto = $this->consultaSql($sSqlSelect);

            $sSql2 = "select * from MET_ISO_Documentos where nr = " . $oRowBD->cod_treinamento;
            $oObjeto2 = $this->consultaSql($sSql2);

            array_push($aTreinamentos, $oObjeto->revisao . ',' . $oObjeto2->documento . ',' . $oObjeto2->revisao);
        }
        return $aTreinamentos;
    }

    public function updateTreinamentos() {
        $sSql = "select distinct cod_treinamento,nr from MET_ISO_RegistroTreinamento group by nr,cod_treinamento";
        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $sSqlSelect = "select * from MET_ISO_RegistroTreinamento where seq = (select MAX(seq) as seq from MET_ISO_RegistroTreinamento where cod_treinamento = " . $oRowBD->cod_treinamento . " and nr = " . $oRowBD->nr . " ) and nr = " . $oRowBD->nr;
            $oObjeto = $this->consultaSql($sSqlSelect);

            $sSql2 = "select * from MET_ISO_Documentos where nr = " . $oRowBD->cod_treinamento;
            $oObjeto2 = $this->consultaSql($sSql2);
            if ($oObjeto->revisao != $oObjeto2->revisao) {
                $sSqlUpdate = "update MET_ISO_Treinamentos set tagTreinamento = 'S' where nr = " . $oRowBD->nr . " and filcgc = 75483040000211";
                $this->executaSql($sSqlUpdate);
            } else {
                $sSqlUpdate = "update MET_ISO_Treinamentos set tagTreinamento = 'N' where nr = " . $oRowBD->nr . " and filcgc = 75483040000211";
                $this->executaSql($sSqlUpdate);
            }
        }
    }

}
