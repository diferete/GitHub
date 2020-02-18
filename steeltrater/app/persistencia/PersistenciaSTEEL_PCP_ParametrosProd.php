<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_ParametrosProd extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('steel_pcp_parametros');
        
        $this->adicionaRelacionamento('cod', 'cod',true,true,true);
        $this->adicionaRelacionamento('parametro', 'parametro');
        $this->adicionaRelacionamento('valor', 'valor');
        $this->adicionaRelacionamento('obs', 'obs');
        
        $this->adicionaOrderBy('cod', 1);
    }
}