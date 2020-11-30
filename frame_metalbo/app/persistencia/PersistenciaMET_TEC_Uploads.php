<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_Uploads extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_Uploads');

        $this->adicionaRelacionamento($sNomeBD, $sNomeModel);
    }

}
