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
        $this->adicionaRelacionamento('nfsemailen', 'nfsemailen');
        $this->adicionaRelacionamento('nfsnfesit', 'nfsnfesit');


        $this->adicionaFiltro('nfsemailen', '');
        
        //$this->adicionaFiltro('nfsdtemiss', date('d/m/Y'), Persistencia::LIGACAO_AND, Persistencia::ENTRE, date('d/m/Y'));
        $this->adicionaFiltro('nfsdtemiss', '28/02/2020', Persistencia::LIGACAO_AND, Persistencia::ENTRE, '28/02/2020');


        $this->adicionaOrderBy('nfsdtemiss', 1);
        $this->adicionaOrderBy('nfsnfnro', 1);
        //$this->setSTop(75);
    }

    public function buscaDadosNf($aCamposChave) {
        $sSql = 'select nfsnfesit from widl.NFC001 where nfsfilcgc = ' . $aCamposChave['nfsfilcgc'] . ' and nfsnfnro = ' . $aCamposChave['nfsnfnro'] . ' and nfsnfser = ' . $aCamposChave['nfsnfser'];
        $oDadosNF = $this->consultaSql($sSql);

        return $oDadosNF->nfsnfesit;
    }

}
