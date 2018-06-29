<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualAta extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbataqual');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('nr','nr',true,true);
        $this->adicionaRelacionamento('seq','seq',true,true,true);
        $this->adicionaRelacionamento('titulo','titulo');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('anexo','anexo');
        $this->adicionaRelacionamento('obs', 'obs');
    }
}