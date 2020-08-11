<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaContRecParc extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbcontrec_parc');
        
        $this->adicionaRelacionamento('empcnpj','empcnpj',true,true);
        $this->adicionaRelacionamento('pescnpj','Pessoa.pescnpj',true,true);
        $this->adicionaRelacionamento('recdocto','recdocto',true,true);
        $this->adicionaRelacionamento('recparc','recparc',true,true,true);
        $this->adicionaRelacionamento('recparcvlr','recparcvlr');
        $this->adicionaRelacionamento('recparcvenc','recparcvenc');
        $this->adicionaRelacionamento('recobs','recobs');
        $this->adicionaRelacionamento('recsit','recsit');
        $this->adicionaRelacionamento('recdatapag', 'recdatapag');
        
        $this->adicionaJoin('Pessoa');
        
        
    }
} 