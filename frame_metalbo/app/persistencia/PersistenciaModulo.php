<?php
class PersistenciaModulo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbmodulo');
        
        $this->adicionaRelacionamento('modcod','modcod',true,true,true);
        $this->adicionaRelacionamento('modescricao', 'modescricao');
        
        $this->adicionaOrderBy('modcod',1);

    }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

