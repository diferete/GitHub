<?php

/*
 * Classe que implementa a persistencia de Moeda
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class PersistenciaDELX_MOE_Moeda extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MOE_MOEDA');

        $this->adicionaRelacionamento('moe_codigo', 'moe_codigo', true, true);
        $this->adicionaRelacionamento('moe_descricao', 'moe_descricao');
        $this->adicionaRelacionamento('moe_padrao', 'moe_padrao');
        $this->adicionaRelacionamento('moe_simbolo', 'moe_simbolo');
        $this->adicionaRelacionamento('moe_descricaosingular', 'moe_descricaosingular');
        $this->adicionaRelacionamento('moe_descricaoplural', 'moe_descricaoplural');

        $this->setSTop('1000');
        $this->adicionaOrderBy('moe_codigo', 0);
    }

}
