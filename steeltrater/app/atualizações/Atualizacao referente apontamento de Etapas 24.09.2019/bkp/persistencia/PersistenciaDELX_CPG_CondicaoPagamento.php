<?php

/*
 * Classe que implementa a persistencia de Condicaopagamento
 * 
 * @author Cleverton Hoffmann
 * @since 21/06/2018
 */

class PersistenciaDELX_CPG_CondicaoPagamento extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CPG_CONDICAOPAGAMENTO');

        $this->adicionaRelacionamento('cpg_codigo', 'cpg_codigo',true,true);
        $this->adicionaRelacionamento('cpg_descricao', 'cpg_descricao');
        $this->adicionaRelacionamento('cpg_numeroparcelas', 'cpg_numeroparcelas');
        $this->adicionaRelacionamento('cpg_taxaacrescimo', 'cpg_taxaacrescimo');
        $this->adicionaRelacionamento('cpg_taxatabelapedidos', 'cpg_taxatabelapedidos');
        $this->adicionaRelacionamento('cpg_tipocondicao', 'cpg_tipocondicao');
        $this->adicionaRelacionamento('cpg_acaoparaferiado', 'cpg_acaoparaferiado');
        $this->adicionaRelacionamento('cpg_diapagtoaposvencto', 'cpg_diapagtoaposvencto');
        $this->adicionaRelacionamento('cpg_textoparcelaavista', 'cpg_textoparcelaavista');
        $this->adicionaRelacionamento('cpg_percentualdesconto', 'cpg_percentualdesconto');
        $this->adicionaRelacionamento('cpg_databasevencto', 'cpg_databasevencto');
        $this->adicionaRelacionamento('cpg_prazomediocondpagto', 'cpg_prazomediocondpagto');
        $this->adicionaRelacionamento('cpg_tipovenctoprincipal', 'cpg_tipovenctoprincipal');
        $this->adicionaRelacionamento('cpg_margemdecontribuicao', 'cpg_margemdecontribuicao');
        $this->adicionaRelacionamento('cpg_diafixovencimento', 'cpg_diafixovencimento');
        $this->adicionaRelacionamento('cpg_cupom', 'cpg_cupom');
        $this->adicionaRelacionamento('cpg_datafixavencimento', 'cpg_datafixavencimento');
        $this->adicionaRelacionamento('cpg_tipovenctoprincpedcompra', 'cpg_tipovenctoprincpedcompra');
        $this->adicionaRelacionamento('cpg_valorminimoparcela', 'cpg_valorminimoparcela');

        $this->setSTop('1000');
        $this->adicionaOrderBy('cpg_codigo', 0);
    }

}