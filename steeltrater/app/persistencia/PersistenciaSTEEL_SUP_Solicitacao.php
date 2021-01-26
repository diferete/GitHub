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

        $this->adicionaRelacionamento('FIL_Codigo', 'DELX_FIL_Empresa.fil_codigo', false, false, false);
        $this->adicionaRelacionamento('FIL_Codigo', 'FIL_Codigo', true, true);
        $this->adicionaRelacionamento('SUP_SolicitacaoSeq', 'SUP_SolicitacaoSeq', true, true, true);
        $this->adicionaRelacionamento('SUP_SolicitacaoDataHora', 'SUP_SolicitacaoDataHora');
        $this->adicionaRelacionamento('SUP_SolicitacaoObservacao', 'SUP_SolicitacaoObservacao');
        $this->adicionaRelacionamento('SUP_SolicitacaoUsuCadastro', 'SUP_SolicitacaoUsuCadastro');
        $this->adicionaRelacionamento('SUP_SolicitacaoObsEntrega', 'SUP_SolicitacaoObsEntrega');
        $this->adicionaRelacionamento('SUP_SolicitacaoTipo', 'SUP_SolicitacaoTipo');
        $this->adicionaRelacionamento('SUP_SolicitacaoSituacao', 'SUP_SolicitacaoSituacao');
        $this->adicionaRelacionamento('SUP_SolicitacaoFaseApr', 'SUP_SolicitacaoFaseApr');
        $this->adicionaRelacionamento('SUP_SolicitacaoMRP', 'SUP_SolicitacaoMRP');
        $this->adicionaRelacionamento('SUP_SolicitacaoUsuAprovador', 'SUP_SolicitacaoUsuAprovador');
        $this->adicionaRelacionamento('SUP_SolicitacaoCCTCod', 'SUP_SolicitacaoCCTCod');
        $this->adicionaRelacionamento('SUP_SolicitacaoDataCanc', 'SUP_SolicitacaoDataCanc');
        $this->adicionaRelacionamento('SUP_SolicitacaoUsuCanc', 'SUP_SolicitacaoUsuCanc');

        $this->adicionaFiltro('FIL_Codigo', '8993358000174');

        $this->adicionaJoin('DELX_FIL_Empresa', null, 1, 'FIL_Codigo', 'fil_codigo');

        $this->adicionaOrderBy('SUP_SolicitacaoSeq', 1);
        $this->setSTop(25);
    }

    public function afterInsert($aCampos) {
        parent::afterInsert($aCampos);

        $sSql = "update tec_sequencia set tec_sequencianumero = " . $aCampos['sup_solicitacaoseq'] . " "
                . "where tec_sequenciaFilial = '8993358000174' and tec_sequenciaTabela ='SUP_Solicitacao'";

        $this->executaSql($sSql);
    }

}
