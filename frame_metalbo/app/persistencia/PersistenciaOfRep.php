<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaOfRep extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela("metop");
        $this->adicionaRelacionamento('op', 'op', true, true, true);
        $this->adicionaRelacionamento('cod', 'cod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('quant', 'quant');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaOrderBy('op', 1);

        $this->setSTop(20);

        $this->setBConsultaManual(true);




        /**
         *  foreach ($_REQUEST['parametrosCampos'] as $key => $value) {
          $procod = $value;
          };
         * 
         */
    }

    public function consultaManual() {
        parent::consultaManual();

        if ($_REQUEST['parametrosCampos']) {
            foreach ($_REQUEST['parametrosCampos'] as $sAtual) {
                $procod = $sAtual;
            }
        }

        $sSql = "select metop.op as 'metop.op',"
                . "metitenop.cod as 'metop.cod',"
                . "metitenop.prodes as 'metop.prodes',"
                . "metitenop.quant  as 'metop.quant',"
                . "convert(varchar,data,103) as 'metop.data',"
                . "metsituaca.situaca as 'metop.situaca' "
                . "from metop(nolock) "
                . "left outer join metitenop(nolock) "
                . "on metop.op = metitenop.op "
                . "left outer join metsituaca(nolock) "
                . "on metop.codsituaca = metsituaca.cod  ";
        
        $sSqlWhere = " where metop.op = metitenop.op "
                . "and codsituaca in ('1','2','3','4') "
                . "and metop.codsituaca = metsituaca.cod "
                . "and metitenop.cod = '" . trim($procod) . "' ";

        $this->setSWhereManual($sSqlWhere);
        return $sSql;
    }

}
