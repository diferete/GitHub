<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_RH_Colaboradores extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('vetorh.dbo.r034fun');
        $this->adicionaRelacionamento('numcad', 'numcad');
        $this->adicionaRelacionamento('nomfun', 'nomfun');
        $this->adicionaRelacionamento('dessit', 'dessit');
        $this->adicionaRelacionamento('nomccu', 'nomccu');
        $this->adicionaRelacionamento('grains', 'grains');
        $this->adicionaRelacionamento('desgra', 'desgra');
        $this->adicionaRelacionamento('titcar', 'titcar');

        $this->setBConsultaManual(true);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select vetorh.dbo.r034fun.numcad as 'vetorh.dbo.r034fun.numcad',"
                . "vetorh.dbo.r034fun.nomfun as 'vetorh.dbo.r034fun.nomfun',"
                . "vetorh.dbo.r010sit.dessit as 'vetorh.dbo.r034fun.dessit',"
                . "vetorh.dbo.r018ccu.nomccu as 'vetorh.dbo.r034fun.nomccu',"
                . "vetorh.dbo.r022gra.grains as 'vetorh.dbo.r022gra.grains',"
                . "vetorh.dbo.r022gra.desgra as 'vetorh.dbo.r034fun.desgra',"
                . "vetorh.dbo.r024car.titcar as 'vetorh.dbo.r034fun.titcar' "
                . "from vetorh.dbo.r034fun "
                . "left outer join [vetorh].dbo.r010sit on [vetorh].dbo.r034fun.sitafa = [vetorh].dbo.r010sit.codsit "
                . "left outer join vetorh..r024car on vetorh..r024car.codcar = vetorh..r034fun.codcar "
                . "left outer join vetorh..r018ccu on [vetorh].dbo.r034fun.codccu = vetorh..r018ccu.codccu "
                . "left outer join vetorh..r022gra on vetorh.dbo.r034fun.grains = vetorh.dbo.r022gra.grains ";

        $sSqlWhere = " and vetorh..r034fun.numcad not in(1,2,3,4)  and vetorh.dbo.r034fun.codfil = 1 ";
        $this->setSWhereManual($sSqlWhere);

        return $sSql;
    }

}
