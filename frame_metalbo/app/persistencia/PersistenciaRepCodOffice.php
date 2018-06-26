<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PersistenciaRepCodOffice extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbrepcodoffice');
        
        $this->adicionaRelacionamento('filcgc','filcgc',true,true);
        $this->adicionaRelacionamento('officecod', 'officecod',true,true);
        $this->adicionaRelacionamento('officeseq', 'officeseq',true,true,true);
        $this->adicionaRelacionamento('repcod','repcod');
        
        $this->adicionaOrderBy('officeseq',1);
    }
}
