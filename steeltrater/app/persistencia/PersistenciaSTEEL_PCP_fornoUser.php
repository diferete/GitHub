<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_fornoUser extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_fornouser');
        
        $this->adicionaRelacionamento('fornocod', 'fornocod',true,true);
        $this->adicionaRelacionamento('usercod','usercod',true,true);
        
        $this->setSTop('500');
                
    }
    
    
}