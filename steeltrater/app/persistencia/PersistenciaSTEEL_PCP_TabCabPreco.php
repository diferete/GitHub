<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_TabCabPreco
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2019
 */

class PersistenciaSTEEL_PCP_TabCabPreco extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_TabCabPreco');

        $this->adicionaRelacionamento('nr', 'nr', true,true,true);
        $this->adicionaRelacionamento('emp_codigo','DELX_CAD_Pessoa.emp_codigo',false,false);
        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo');
        $this->adicionaRelacionamento('nometabela', 'nometabela');
        $this->adicionaRelacionamento('usuarioCadastro','usuarioCadastro');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('sit','sit');
        $this->adicionaRelacionamento('concatena','concatena');

        $this->setSTop('100');
        
        $this->adicionaJoin('DELX_CAD_Pessoa',null,1,'emp_codigo','emp_codigo');
        $this->adicionaOrderBy('nr',1);
    }

}