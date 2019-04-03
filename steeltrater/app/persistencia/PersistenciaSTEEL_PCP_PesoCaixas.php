<?php

/*
 * Classe que implementa a persistencia
 * 
 * @author Cleverton Hoffmann
 * @since 28/02/2019
 */

class PersistenciaSTEEL_PCP_PesoCaixas extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_PesoCaixas');

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('empcodigo', 'empcodigo');
        $this->adicionaRelacionamento('tipoCaixa', 'tipoCaixa');
        $this->adicionaRelacionamento('padrao', 'padrao');
        $this->adicionaRelacionamento('peso', 'peso');

        $this->setSTop('1000');
        $this->adicionaOrderBy('nr', 0);
        
    }
}
