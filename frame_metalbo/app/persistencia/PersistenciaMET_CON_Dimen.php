<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_CON_Dimen extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    
   public function getCadDim($sDados) {
        $sSql = "select prodacab,promatcod,ProClasseG ,ProAngHel,"
                . " prodchamin,prodchamax,prodaltmin,prodaltmax,proddiamin,proddiamax,procommin,procommax,prodiapmin,prodiapmax,"
                . "prodiaemin,prodiaemax,procomrmin,procomrmax,comphastma,comphastmi,DiamHastMi,DiamHastMa ,pfcmin, pfcmax"
                . " from widl.prod01 where procod = '" . $sDados . "' and grucod in(12,13) and probloqpro <> 'S'";
        $oObj = $this->consultaSql($sSql);
        return $oObj;
    }
}
