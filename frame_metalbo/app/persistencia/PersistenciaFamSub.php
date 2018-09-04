<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaFamSub extends Persistencia{
    public function __construct() {
        parent::__construct();
        
         $this->setTabela('widl.PROD04A1');
        
         $this->adicionaRelacionamento('grucod','grucod',true);
         $this->adicionaRelacionamento('subcod', 'subcod',true);
         $this->adicionaRelacionamento('famcod', 'famcod',true);
         $this->adicionaRelacionamento('famsub', 'famsub');
         $this->adicionaRelacionamento('famsdes','famsdes');
         
         $this->setSTop(50);
         
       
    }
}