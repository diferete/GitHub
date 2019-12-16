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
        $this->adicionaRelacionamento('updates', 'updates');
        $this->adicionaRelacionamento('grau_escolaridade', 'grau_escolaridade');
        $this->adicionaRelacionamento('tagEscolaridade', 'tagEscolaridade');
    }

    public function buscaDadosColaborador($aDados) {
        $sSql = 'select * from tbfunc where numcad = ' . $aDados['cracha'];
        $oDados = $this->consultaSql($sSql);
        return $oDados;
    }

    public function deletaDependencias($aDados) {

        $sSql = "delete from MET_ISO_RegistroTreinamento where nr =" . $aDados[1] . "  and filcgc = " . $aDados[0];
        $this->executaSql($sSql);
    }

    public function buscaDadosFuncao($oDados) {
        $sSql = "select * from MET_ISO_FuncDesc"
                . " where nr = (SELECT  max(nr) FROM MET_ISO_FuncDesc WHERE descricao = '" . $oDados->cargo . "')"
                . " and seq = (SELECT MAX(seq) FROM MET_ISO_FuncDesc WHERE descricao =  '" . $oDados->cargo . "')";
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
        $iCountInc = 0;

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['cracha'] = $oRowBD->cracha;
            $oDados = $this->buscaDadosColaborador($aDados);
            $oFuncao = $this->buscaDadosFuncao($oDados);
            if ($oFuncao->esc_exigida > $oDados->grains) {

                $iCountInc++;
            }
            $iCountTotal++;
        }
        $aCount['total'] = $iCountTotal;
        $aCount['totalInc'] = $iCountInc;
        return $aCount;
    }

}
