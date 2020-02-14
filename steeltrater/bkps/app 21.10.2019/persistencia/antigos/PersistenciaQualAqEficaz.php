<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualAqEficaz extends Persistencia{
    public function __construct() {
        parent::__construct();
        $this->setTabela('tbacaoeficaz');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('nr', 'nr',true,true);
        $this->adicionaRelacionamento('seq', 'seq',true,true,true);
        $this->adicionaRelacionamento('acao', 'acao');
        $this->adicionaRelacionamento('dataprev', 'dataprev');
        $this->adicionaRelacionamento('datareal','datareal');
        $this->adicionaRelacionamento('usucodigo','usucodigo');
        $this->adicionaRelacionamento('usunome','usunome');
       
        
        $this->adicionaOrderBy('seq', 1);
    }
    
    
    
}