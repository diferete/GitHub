<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_ChamadoTipo extends Persistencia {

    public function __construct() {
        parent::__construct();
        $this->setTabela('MET_TEC_ChamadoTipo');

        $this->adicionaRelacionamento('tipo', 'tipo',true,true);
        $this->adicionaRelacionamento('subtipo', 'subtipo',true,true);
        $this->adicionaRelacionamento('subtipo_nome', 'subtipo_nome');
    }

}
