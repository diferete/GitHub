<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_QUAL_Prob_Rnc extends Persistencia {

    public function __construct() {
        parent::__construct();
        $this->setTabela('MET_QUAL_Prob_Rnc');
        
      $this->adicionaRelacionamento('codprobl', 'codprobl', true, true, true);
        $this->adicionaRelacionamento('descprobl', 'descprobl');
             
        
    }
    
   
    public function consultaproblrnc($codprobl) {
        $sSql = "select * from MET_QUAL_Rnc";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

 
    
    
    
}


    
    
    
    
    
