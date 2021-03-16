<?php

/*
 * Classe que implementa a persistencia de DELX_TDS_TipoReceita
 * 
 * @author Cleverton Hoffmann
 * @since 22/09/2020
 */

class PersistenciaDELX_TDS_TipoReceita extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('TDS_TIPODESPESA');

        $this->adicionaRelacionamento('tds_codigo', 'tds_codigo', true, true);
        $this->adicionaRelacionamento('tds_descricao', 'tds_descricao');
        $this->adicionaRelacionamento('tds_inativa', 'tds_inativa');
        $this->adicionaRelacionamento('tds_contatitulo', 'tds_contatitulo');
        $this->adicionaRelacionamento('tds_tipo','tds_tipo');
        $this->adicionaRelacionamento('tds_grupo','tds_grupo');
        $this->adicionaRelacionamento('tds_desconsiderafluxo','tds_desconsiderafluxo');
        $this->adicionaRelacionamento('tds_despesaoperacional','tds_despesaoperacional');
        $this->adicionaRelacionamento('tds_classificacao','tds_classificacao');
        $this->adicionaRelacionamento('tds_controleviagem','tds_controleviagem');
        $this->adicionaRelacionamento('tds_grupodescricao','tds_grupodescricao');
        $this->adicionaRelacionamento('tds_tipodespesavaldocsup','tds_tipodespesavaldocsup');
        $this->adicionaFiltro('tds_tipo', 'R');
        $this->setSTop('50');
        $this->adicionaOrderBy('tds_codigo', 1);
    }

}
