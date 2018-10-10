<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */

class PersistenciaSTEEL_PCP_Certificado extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_CERTIFICADO');

        $this->adicionaRelacionamento('nrcert', 'nrcert', true, true, true);
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('notasteel', 'notasteel');
        $this->adicionaRelacionamento('notacliente', 'notacliente');
        $this->adicionaRelacionamento('opcliente', 'opcliente');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('dataensaio', 'dataensaio');
        $this->adicionaRelacionamento('dataemissao', 'dataemissao');
        $this->adicionaRelacionamento('peso', 'peso');
        $this->adicionaRelacionamento('quant', 'quant');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('hora', 'hora');
        
        $this->setSTop('300');
        $this->adicionaOrderBy('nrcert', 1);
    }

}
