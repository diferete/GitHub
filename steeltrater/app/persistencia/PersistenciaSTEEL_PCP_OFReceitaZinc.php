<?php

/*
 * Implementa a classe de alteração da receita zincagem na ordens fabricação
 * @author Cleverton Hoffmann
 * @since 25/02/2021
 */

class PersistenciaSTEEL_PCP_OFReceitaZinc extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ordensFab');

        $this->adicionaRelacionamento('op', 'op', true, true, true);
        $this->adicionaRelacionamento('receita_zinc', 'receita_zinc');
        $this->adicionaRelacionamento('receita_zincdesc', 'receita_zincdesc');
        $this->adicionaRelacionamento('processozinc', 'processozinc');
        $this->adicionaRelacionamento('situacao', 'situacao');

        $this->adicionaOrderBy('op', 1);
        $this->setSTop('100');
    }

}
