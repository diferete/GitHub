<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaPoliCadMaq extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbpolimaq');
        
        $this->adicionaRelacionamento('codmaq', 'codmaq',true,true,true);
        $this->adicionaRelacionamento('maquina', 'maquina');
        $this->adicionaRelacionamento('fabcod', 'PoliFab.fabcod');
        $this->adicionaRelacionamento('nomeclatura', 'nomeclatura');
        $this->adicionaRelacionamento('modelo', 'modelo');
        $this->adicionaRelacionamento('fabricacao', 'fabricacao');
        $this->adicionaRelacionamento('horasop', 'horasop');
        $this->adicionaRelacionamento('nroperador', 'nroperador');
        $this->adicionaRelacionamento('codsetor', 'PoliSetor.codsetor');
        $this->adicionaRelacionamento('serie', 'serie');
        $this->adicionaRelacionamento('patrimonio', 'patrimonio');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('ativa', 'ativa');
        $this->adicionaRelacionamento('seguranca','seguranca');
        $this->adicionaRelacionamento('responsavel','responsavel');
        $this->adicionaRelacionamento('usercad','usercad');
        $this->adicionaRelacionamento('datacad','datacad');
        $this->adicionaRelacionamento('horacad','horacad');
        
        $this->adicionaJoin('PoliFab');
        $this->adicionaJoin('PoliSetor');
        $this->adicionaOrderBy('codmaq',1);
    }
}