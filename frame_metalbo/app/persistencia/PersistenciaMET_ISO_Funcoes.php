<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_ISO_Funcoes extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_ISO_Funcoes');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');

        $this->adicionaOrderBy('nr', 1);
    }

    public function deletaDependencias($aDados) {

        $sSql = "delete from MET_ISO_FuncDesc where nr =" . $aDados[1] . "  and filcgc = " . $aDados[0];
        $this->executaSql($sSql);
    }

}
