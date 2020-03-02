<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_FIN_VisualizaNFE extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.NFC001');
        $this->adicionaRelacionamento('nfsfilcgc', 'nfsfilcgc', true, true);
        $this->adicionaRelacionamento('nfsnfser', 'nfsnfser', true);
        $this->adicionaRelacionamento('nfsnfnro', 'nfsnfnro', true, true);
        $this->adicionaRelacionamento('nfsnfechv', 'nfsnfechv');
        $this->adicionaRelacionamento('nfsdtemiss', 'nfsdtemiss');
        $this->adicionaRelacionamento('nfsclinome', 'nfsclinome');
        $this->adicionaRelacionamento('NfsEmailEn', 'NfsEmailEn');

        $this->adicionaOrderBy('nfsdtemiss', 1);
        $this->adicionaOrderBy('nfsnfnro', 1);
        $this->setSTop(75);
    }

}
