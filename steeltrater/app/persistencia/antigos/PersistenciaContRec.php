<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaContRec extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbcontrec');
        
        $this->adicionaRelacionamento('empcnpj', 'empcnpj',true,true);
        $this->adicionaRelacionamento('pescnpj', 'Pessoa.pescnpj',true,true);
        $this->adicionaRelacionamento('recdocto', 'recdocto',true,true);
        $this->adicionaRelacionamento('recvlrtot', 'recvlrtot');
        $this->adicionaRelacionamento('recdtemiss', 'recdtemiss');
        $this->adicionaRelacionamento('recusuario', 'recusuario');
        $this->adicionaRelacionamento('condcod', 'condcod');
        
        $this->adicionaJoin('Pessoa');
    }
}