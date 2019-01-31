<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaChamadoTi extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('metcham');
        
        
        $this->adicionaRelacionamento('id','id',true,true,true);
        $this->adicionaRelacionamento('codsit','ChamadoSit.codsit');
        $this->adicionaRelacionamento('tipo', 'tipo');
        $this->adicionaRelacionamento('coduser','MetSisMetalbo.coduser');
        $this->adicionaRelacionamento('datacad','datacad');
        $this->adicionaRelacionamento('horacad','horacad');
        $this->adicionaRelacionamento('userweb','User.usucodigo');
        $this->adicionaRelacionamento('probl','probl');
        $this->adicionaRelacionamento('atendeti', 'atendeti');
        
        $this->adicionaOrderBy('id',1);
        $this->adicionaJoin('ChamadoSit');
        $this->adicionaJoin('MetSisMetalbo', NULL, 1, 'coduser','coduser');
        $this->adicionaJoin('User', NULL, 1, 'userweb','usucodigo');
        //$this->adicionaJoin('Setor', NULL, 1, 'User.codsetor','codsetor');
        
        $this->setSTop(50);
        
    }
}