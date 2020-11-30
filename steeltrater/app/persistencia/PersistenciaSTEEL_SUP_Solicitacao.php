<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_SUP_Solicitacao extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('SUP_Solicitacao');

        $this->adicionaRelacionamento('fil_codigo', 'DELX_FIL_Empresa.fil_codigo', false, false, false);
        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('sup_solicitacaoseq', 'sup_solicitacaoseq', true, true, true);
        $this->adicionaRelacionamento('sup_solicitacaodatahora', 'sup_solicitacaodatahora');
        $this->adicionaRelacionamento('sup_solicitacaoobservacao', 'sup_solicitacaoobservacao');
        $this->adicionaRelacionamento('sup_solicitacaousucadastro', 'sup_solicitacaousucadastro');
        $this->adicionaRelacionamento('sup_solicitacaoobsentrega', 'sup_solicitacaoobsentrega');
        $this->adicionaRelacionamento('sup_solicitacaotipo', 'sup_solicitacaotipo');
        $this->adicionaRelacionamento('sup_solicitacaosituacao', 'sup_solicitacaosituacao');
        $this->adicionaRelacionamento('sup_solicitacaofaseapr', 'sup_solicitacaofaseapr');
        $this->adicionaRelacionamento('sup_solicitacaomrp', 'sup_solicitacaomrp');
        $this->adicionaRelacionamento('sup_solicitacaousuaprovador', 'sup_solicitacaousuaprovador');
        $this->adicionaRelacionamento('sup_solicitacaocctcod', 'sup_solicitacaocctcod');
        $this->adicionaRelacionamento('sup_solicitacaodatacanc', 'sup_solicitacaodatacanc');
        $this->adicionaRelacionamento('sup_solicitacaousucanc', 'sup_solicitacaousucanc');

        $this->adicionaFiltro('fil_codigo', '8993358000174');

        $this->adicionaJoin('DELX_FIL_Empresa', null, 1, 'fil_codigo', 'fil_codigo');

        $this->adicionaOrderBy('sup_solicitacaoseq', 1);
        $this->setSTop(25);
    }

    public function afterInsert($aCampos) {
        parent::afterInsert($aCampos);

        $sSql = "update tec_sequencia set tec_sequencianumero = " . $aCampos['sup_solicitacaoseq'] . " "
                . "where tec_sequenciaFilial = '8993358000174' and tec_sequenciaTabela ='SUP_Solicitacao'";

        $this->executaSql($sSql);
    }

}
