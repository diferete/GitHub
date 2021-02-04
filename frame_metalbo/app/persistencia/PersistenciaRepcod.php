<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaRepcod extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.rep01');

        $this->adicionaRelacionamento('repcod', 'repcod', true);
        $this->adicionaRelacionamento('repdes', 'repdes');
        $this->adicionaOrderBy('repcod', 1);

        $this->setBConsultaManual(true);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select widl.rep01.repcod as 'widl.rep01.repcod', "
                . "widl.rep01.repdes as 'widl.rep01.repdes' "
                . "from widl.rep01 "
                . "left outer join tbrepcodoffice "
                . "on tbrepcodoffice.repcod = widl.rep01.repcod  ";
        if ($_SESSION['codsetor'] != 2) {
            $sSqlWhere = " tbrepcodoffice.officecod in (" . $_SESSION['repoffice'] . ")";
            $this->setSqlWhere($sSqlWhere);
        }

        return $sSql;
    }

}
