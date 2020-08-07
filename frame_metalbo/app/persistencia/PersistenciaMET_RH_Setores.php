<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_RH_Setores extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('vetorh.dbo.r018ccu');
        $this->adicionaRelacionamento('codccu', 'codccu');
        $this->adicionaRelacionamento('nomccu', 'nomccu');


        $this->setBConsultaManual(true);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select vetorh.dbo.r018ccu.codccu as 'vetorh.dbo.r018ccu.codccu', "
                . "vetorh.dbo.r018ccu.nomccu as 'vetorh.dbo.r018ccu.nomccu' "
                . "from vetorh.dbo.r018ccu";
        
        return $sSql;
    }

}
