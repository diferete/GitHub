<?php

/* 
 * Classe que implementa as receitas das ofs
 * 
 * @author Avanei Martendal
 * @since 15/16/2018
 * 
 */

class PersistenciaSTEEL_PCP_Receitas extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_receitas');
        
        $this->adicionaRelacionamento('cod', 'cod',true,true,true);
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('peca', 'peca');
        $this->adicionaRelacionamento('material', 'material');
        $this->adicionaRelacionamento('classe', 'classe');
        $this->adicionaRelacionamento('dureza', 'dureza');
        $this->adicionaRelacionamento('bitola', 'bitola');
        $this->adicionaRelacionamento('metanol', 'metanol');
        $this->adicionaRelacionamento('oxigenio', 'oxigenio');
        $this->adicionaRelacionamento('nitrogenio', 'nitrogenio');
        $this->adicionaRelacionamento('amonia', 'amonia');
        $this->adicionaRelacionamento('glp', 'glp');
        $this->adicionaRelacionamento('co', 'co');
        $this->adicionaRelacionamento('carbono', 'carbono');
        $this->adicionaRelacionamento('imagem', 'imagem');
        $this->adicionaRelacionamento('temprev', 'temprev');
        $this->adicionaRelacionamento('instTrab','instTrab');
        $this->adicionaRelacionamento('progForno', 'progForno');
        $this->adicionaRelacionamento('codServ', 'codServ');
        $this->adicionaRelacionamento('codServMet','codServMet');
        $this->adicionaRelacionamento('codInsumo','codInsumo');
        $this->adicionaRelacionamento('tipoReceita','tipoReceita');
        
        $this->adicionaOrderBy('cod',1);
        $this->setSTop('40');
    }
}

