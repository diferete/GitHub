<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_contatoCert extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_contatoCert');
        
        $this->adicionaRelacionamento('emp_codigo','emp_codigo',true,true);
        $this->adicionaRelacionamento('empcertemail','empcertemail',true,true);
        $this->adicionaRelacionamento('DELX_CAD_Pessoa', 'DELX_CAD_Pessoa',false,false);
        
        $this->adicionaJoin('DELX_CAD_Pessoa');
    }
}
